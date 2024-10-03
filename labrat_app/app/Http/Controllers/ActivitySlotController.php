<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SlotsExport;


class ActivitySlotController extends Controller
{
    //εμφάνιση όλων των δραστηριοτήτων Slot στο χώρο του μαθήματος στο αρχείο (slot_activities.blade.php)
    public function showtheActivitiesSlots($l_id,$title,$name)
    {
        $data= DB::table('activity_slot AS S')->
            select('S.*', 'T.title as at_title')->
            leftJoin('activity_team AS T', 'T.id', '=', 'S.at_id')->
            where('S.l_id', '=', $l_id)->
            orderby('S.created_at', 'desc')->paginate(15);



        //εμφάνιση των δραστηριοτήτων teams  για την επιλογή συσχετιζόμενης δραστηριότητας teams
        $actteams= DB::table('activity_team')->select('id', 'title')->where('l_id', '=', $l_id)->where('status', '=', 1)->orderby('created_at', 'desc')->get();

        return view('slot_activities',['title'=>$title,'l_id'=>$l_id,'name'=>$name,'actslots'=>$data,'actteams'=>json_encode($actteams)]);
    }


    // δημιουργία/ενημέρωση δραστηριότητας slots του μαθήματος στο αρχείο (slot_activities.blade.php)
    public function create_update(Request $request)
    {
        try {
        $l_id=$request->input('l_id');
        $as_id=$request->input('act_id');
        $title=$request->input('title');
        $at_id=$request->input('at_id');
        $text=$request->input('text');
        $text=str_replace(['<br>','<em>','</em>','<span style="text-decoration: underline;">','</span>','<strong>','</strong>','<li>', '</li>'],["\n","☺","☻",'♦','♣',"♥","♠",'• ',''],$text);
        $text=strip_tags($text,['☺','♦','♣',"♥","♠",'☻','• ',"\n"]);

        date_default_timezone_set('Europe/Athens');
        $startdate=date('Y-m-d H:i:s', strtotime($request->input('startdate')));
        $enddate=date('Y-m-d H:i:s', strtotime($request->input('enddate')));

        //έλεγχος αν οι ημερομήνίες λήξης και έναρξης είναι έγκυρες
        if($enddate<$startdate){
            return redirect()->back()->with('warning','Η προσθήκη των δεδωμένων έγινε ανεπιτυχώς!. Η ημερομηνία έναρξης και λήξης δεν ήταν λάθος καταχωρημένες!');
        }
        // αν είναι για τη δημιουργία δραστηριότητας slot
        if($request->input('action')=='add'){
            DB::transaction(function () use ($l_id,$title,$text,$startdate,$enddate,$at_id) {
                DB::insert('insert into activity_slot (l_id,title,text,created_at,updated_at,at_id) values (?,?,?,?,?,?)', [$l_id, $title, $text, $startdate, $enddate, $at_id]);
            });
            return redirect()->back()->with('message','Η προσθήκη των δεδομένων έγινε επιτυχώς!');
        }
        // αν είναι για τη ενημέρωση δραστηριότητας slot
        if($request->input('action')=='update'){
            DB::transaction(function () use ($l_id,$title,$text,$startdate,$enddate,$at_id,$as_id) {
                DB::table('activity_slot')
                    ->where('id', $as_id)
                    ->update([
                        'l_id' => $l_id,
                        'title' => $title,
                        'text' => $text,
                        'created_at' => $startdate,
                        'updated_at' => $enddate,
                        'at_id' => $at_id,
                    ]);
            });
            return redirect()->back()->with('message','Η ανανέωση πληροφοριών έγινε επιτυχώς!');
        }
        } catch (\Exception $e) {
            // Handle exceptions that might occur within the transactions
            return redirect()->back()->with('warning', 'Προέκυψε σφάλμα κατά την εκτέλεση της ενέργειας.');
        }

    }

    // διαγραφή δραστηριότητας slots του μαθήματος στο αρχείο (slot_activities.blade.php)
    public function destroy(Request $request){
        try {
            $id=$request->input('as_id');
            $recordExists = DB::table('activity_slot')->where('id', $id)->exists();
            if (!$recordExists) {
                return redirect()->back()->with('warning', 'Η δραστηριότητα που προσπαθήσατε να διαγράψετε δεν υπάρχει.');
            }

            DB::transaction(function () use ($id) {
                DB::delete('delete from activity_slot where id=?',[$id]);
            });

        return redirect()->back()->with('message','Η διαγραφή της δραστηριότητας έγινε επιτυχώς!');
        } catch (\Exception $e) {
            // Handle exceptions that might occur within the transaction
            return redirect()->back()->with('warning', 'Προέκυψε σφάλμα κατά τη διαγραφή της δραστηριότητας.');
        }
    }

    //Εφμάνιση όλων των slots της Δραστηριότητας στο αρχείο (alltheslots.blade.php)
    function showTheActivitySlot($l_id,$title,$name,$as_id,$date,Request $request){

        $activity=DB::table('activity_slot')->where('id', '=', $as_id)->get();
        $data='';
        $counter='';
        $teamorpart='';
        $role=$request->input('role');
        $am=$request->input('am');
        $thedate=$date;

        $dates=DB::table('slots as S')
            ->select(DB::raw('DATE(S.slot_time) as created_date'))
            ->where('S.as_id', '=', $as_id)
            ->groupBy('created_date')
            ->orderBy('created_date','asc')
            ->get();

        date_default_timezone_set('Europe/Athens');
        if($thedate!== '-'){
            $thedate=date('Y-m-d', strtotime($date));

        }
        else{
            if(count($dates)>0)
            {
                $thedate=date('Y-m-d', strtotime($dates[0]->created_date));
            }
            else{
                $thedate=true;
            }

        }




        foreach ($activity as $a) {
            //αν ύπάρχει συσχετιζόμενη δραστηριότητα teams εμφάνισε της ομάδες για κάθε slot που είναι δεσμευμένο
            if($a->at_id!=null) {
                $at_id=$a->at_id;
                $data = DB::table('slots as S')
                    ->select('S.*')
                    ->selectSub(function ($query) use ($at_id) {
                        $query->select(DB::raw("GROUP_CONCAT(u.am, ' - ', u.name)"))
                            ->from('users AS u')
                            ->join('teams AS T1', 'u.am', '=', 'T1.am')
                            ->whereColumn('T1.t_id', '=', 'S.am')
                            ->where('T1.at_id', '=', $at_id);
                    }, 'part')
                    ->where(DB::raw('DATE(S.slot_time)'),'=',$thedate)
                    ->where('S.as_id', '=', $as_id)
                    ->orderBy('S.slot_time', 'asc')
                    ->get();

                //Αν αυτός που θέλει να μπει να δει τα slot δεν είναι μαθητής εμφάνισε
                // όλες της ομάδες της συσχετιζόμενη δραστηριότητας για να την επιλογή ομάδας
                //αν θελήσει να δεσμεύσει κάποιο slot εκ μέρους της.
                if($role!=='Μαθητής'){
                    $teamorpart=DB::table('teams AS T')
                        ->select(DB::raw('GROUP_CONCAT(U.am, "-", U.name) as info'),'T.t_id as am')
                        ->leftJoin('slots as S', function ($join) use ($as_id) {
                            $join->on('S.am', '=', 'T.t_id')
                                ->where('S.as_id', '=', $as_id);
                        })
                        ->join('users AS U','T.am', '=', 'U.am')
                        ->where('T.at_id','=',$a->at_id)
                        ->whereNull('S.am')
                        ->groupBy('T.t_id')
                        ->orderBy('T.t_id')->get();
                }
                //Αν αυτός που θέλει να μπει να δει τα slot είναι μαθητής εμφάνισε την ομάδα του στη συσχετιζόμενη
                // δραστηριότητας για να την επιλογή ομάδας αν θελήσει να δεσμεύσει κάποιο slot .
                if($role==='Μαθητής'){
                    $teamorpart = DB::table('teams AS T')
                        ->select('T.t_id as am', DB::raw('GROUP_CONCAT(U.am, "-", U.name) as info'))
                        ->leftJoin('teams AS T1', function ($join) {
                            $join->on('T1.t_id', '=', 'T.t_id')
                                ->on('T1.at_id', '=', 'T.at_id');
                        })
                        ->join('users AS U', 'T1.am', '=', 'U.am')
                        ->where('T.am', '=', $am)
                        ->where('T.at_id', '=',$a->at_id)
                        ->groupBy('T.t_id')
                        ->get();

                }
                $counter='Αριθμός Ομάδων: '.count($teamorpart);
            }//αν δεν ύπάρχει συσχετιζόμενη δραστηριότητα teams εμφάνισε της ομάδες για κάθε slot που είναι δεσμευμένο
            else{
                $data = DB::table('slots as S')
                    ->select('S.*')
                    ->selectSub(function ($query) {
                        $query->select(DB::raw("CONCAT(U.am, '-', U.name)"))
                            ->from('users AS U')
                            ->whereColumn('U.am', '=', 'S.am');
                    }, 'part')
                    ->where('S.as_id', '=', $as_id)
                    ->where(DB::raw('DATE(S.slot_time)'),'=',$thedate)
                    ->orderBy('S.slot_time', 'asc')
                    ->get();
                //Αν αυτός που θέλει να μπει να δει τα slot δεν είναι μαθητής εμφάνισε όλες της συμμετοχές του
                // μαθήματος για να την επιλογή φοιτητή αν θελήσει να δεσμεύσει κάποιο slot εκ μέρους του.
                if($role!=='Μαθητής'){
                    $teamorpart=DB::table('participations AS P')->select(DB::raw('CONCAT(U.am, "-", U.name) as info'),'P.am as am')
                        ->leftJoin('slots as S', function ($join) use ($as_id) {
                            $join->on('S.am', '=', 'P.am')
                                ->where('S.as_id', '=', $as_id);
                        })
                        ->join('users AS U','U.am', '=' ,'P.am')
                        ->whereNull('S.am')
                        ->where('P.l_id','=',$l_id)
                        ->orderBy('P.am','desc')->get();

                }
                //Αν αυτός που θέλει να μπει να δει τα slot είναι μαθητής εμφάνισε τη συμμετοχή του στο μάθημα
                // για να δεσμεύσει κάποιο slot .
                if($role==='Μαθητής'){
                    $teamorpart=DB::table('participations AS P')
                        ->select(DB::raw('CONCAT(U.am, "-", U.name) as info'),'P.am as am')
                        ->join('users AS U','U.am', '=' ,'P.am')
                        ->where('P.l_id','=',$l_id)
                        ->where('P.am','=',$am)
                        ->get();
                }
                $counter='Αριθμός Συμμετοχών: '.count($teamorpart);
            }
        } return view('alltheslots',['title'=>$title,'l_id'=>$l_id,'name'=>$name,'activity'=>$activity,'slots'=>$data,'info'=>$counter,'teamorpart'=>json_encode($teamorpart),'dates'=>$dates,'thedate'=>$thedate]);
    }

//δημιουργία slots στο αρχείο( alltheslots.blade.php) για τον καθηγητή κσι το διαχειριστή
    public function createslots(Request $request){
        $as_id=$request->input('as_id');
        $duration='+'.$request->input('slot_duration').' minutes';

        date_default_timezone_set('Europe/Athens');
        $slot_date=date('Y-m-d ', strtotime($request->input('slot_date')));
        $start=date('H:i:s', strtotime($request->input('slot_time_start')));
        $end=date('H:i:s', strtotime($request->input('slot_time_end')));

        $allslotsid=DB::transaction(function () use ($as_id) {
            return DB::table('slots')->select('id')->where('as_id', '=', $as_id)->get();
        });
        foreach ($allslotsid as $a)
        {
            $a=$a->id;
            DB::transaction(function () use ($a) {
                DB::table('slot_notification')
                    ->where('slot_id', $a)
                    ->lockForUpdate()
                    ->update([
                        'msg' => DB::raw("CONCAT(msg, ' αποδεσμεύτηκε')")
                    ]);
            });
        }
        DB::transaction(function () use ($as_id) {
            DB::table('slots')
                ->where('as_id', $as_id)
                ->lockForUpdate()
                ->update([
                    'am' =>' ',
                ]);
        });
        while($start<=$end){
            $timestamp = date('Y-m-d H:i:s',strtotime($slot_date . ' ' . $start));
            DB::insert('insert into slots (as_id,slot_time,am) values (?,?,?)',[$as_id,$timestamp,' ']);
            $start= date('H:i:s', strtotime($start . $duration));
        }


        return redirect()->back()->with('message','Η δημιουργία slot έγινε επιτυχώς!');
    }

//δέσμεση σλοτ στο αρχείο( alltheslots.blade.php)
    public function JoinInTheSlot(Request $request){
        return DB::transaction(function () use ($request) {
        $slot_id=$request->input('slot_id');
        $am=$request->input('am');
        $at_id=$request->input('at_id');
        $message=$request->input('names');
        $as_id=$request->input('as_id');

        //Αν το slot είναι ήδη δεσμευμένο
        $check=DB::table('slots')->Select('am')->where('id','=',$slot_id)->get();

        //Αν υπάρχει ήδη slot που ο μαθητής/ομάδα έχει δεσμέυσει στη συγκεκριμένη δραστηριότητα
        $checkslots=DB::table('slots')->where('am','=',$am)->where('as_id','=',$as_id)->first();

        if(!$checkslots){}
        else{
            DB::table('slots')->where('id', '=',$checkslots->id)->update(['am' => ' ',]);
            DB::table('slot_notification')->where('slot_id', $checkslots->id)->update(['msg' => DB::raw("CONCAT(msg, ' αποδεσμεύτηκε')")]);

        }
        foreach($check as $c){
            if($c->am!=' '){
                return redirect()->back()->with('warning','Το Slot είναι ήδη δεσμευμένο!');
            }
        }

        DB::table('slots')->where('id', '=',$slot_id)->update(['am' => $am,]);
        //δημιουργία ειδοποιήσεων
        if($at_id==null){
            $message='';
            DB::insert('insert into slot_notification (slot_id,msg,receiver_am) values (?,?,?)',[$slot_id,$message,$am]);
        }
        else{
            $receivers=DB::table('teams')
                ->select('am')
                ->where('t_id','=',$am)
                ->where('at_id','=',$at_id)
                ->get();
            foreach($receivers as $r) {
                DB::insert('insert into slot_notification (slot_id,msg,receiver_am) values (?,?,?)', [$slot_id, $message, $r->am]);
            }
        }

        return redirect()->back()->with('message','Το Slot δεσμέυτηκε επιτυχώς!');
        });
    }

    //Αποδέσμευση slot στο αρχείο( alltheslots.blade.php)
    public function deleteInTheSlot(Request $request){
        $slot_id = $request->input('slot_id');
        $am = ' ';

        DB::beginTransaction();

        try {
            DB::table('slot_notification')
                ->where('slot_id', $slot_id)
                ->update([
                    'msg' => DB::raw("CONCAT(msg, ' αποδεσμεύτηκε')")
                ]);

            DB::table('slots')
                ->where('id', $slot_id)
                ->update(['am' => $am]);

            DB::commit();

            return redirect()->back()->with('message', 'Το Slot αποδεσμέυτηκε επιτυχώς!');
        } catch (\Exception $e) {
            DB::rollback();
            // Handle the exception (log, show an error message, etc.)
            return redirect()->back()->with('warning', 'Προέκυψε σφάλμα κατά την αποδέσμευση του Slot.');
        }
    }

    //διαγρφή slot στο αρχείο( alltheslots.blade.php) για τον καθηγητή κσι το διαχειριστή
    public function deleteTheSlot(Request $request){
        $slot_id=$request->input('slot_id');
        $data=DB::table('slots')->where('id','=',[$slot_id])->lockForUpdate()->first();
        if($data && $data->am==' '){
            DB::transaction(function () use ($slot_id) {
            DB::delete('delete from slots where id=?',[$slot_id]);
            });
            return redirect()->back()->with('message','Το Slot διαγράφηκε επιτυχώς');
        }
        return redirect()->back()->with('warning','Το Slot είναι δεσμευμένο.');

    }

    //εισαγωγή slot μέσω αρχείου
    public function importslots(Request $request){
        $file=$request->file('file');
        $as_id=$request->input('as_id');

        $data = Excel::toArray([], $file)[0];
        $dates=[];
        array_shift($data); // remove the first row

        // Iterate through the data and cast specific columns to timestamps
        $data = array_map(function ($row) use (&$dates) {
            date_default_timezone_set('Europe/Athens');
           if($row[0]!==null){
            $startdate = $row[0] + $row[1];
            $startdate = ($startdate - 25569) * 86400;
            $startdate = date('Y-m-d H:i', round($startdate - 10800));
            $startdate = date('Y-m-d H:i', strtotime($startdate . ' +1 hour'));

            $enddate =  floatval($row[0]) + floatval($row[2]);
            $enddate = ($enddate - 25569) * 86400;
            $enddate = date('Y-m-d H:i', round($enddate - 10800));
            $enddate = date('Y-m-d H:i', strtotime($enddate . ' +1 hour'));

            $duration = ' +' . $row[3] . ' minutes';
            while ($startdate <= $enddate) {
                $dates[] = [$startdate];
                $startdate = date('Y-m-d H:i', strtotime($startdate . $duration));
            }
           }
            return $row;
        }, $data);



        $notindb=[];
        $validator1 = Validator::make($request->all(), [
            'file' => 'required|mimes:xls,xlsx'
        ]);
        if($validator1->fails())
        {
            return redirect()->back()->with('warning','Το αρχείο απαιτείται να είναι της μορφής .xls ή .xlsx');
        }

        foreach ($dates as $row) {

            $validator = Validator::make($row, [
                0 => ['required', function ($attribute, $value, $fail) use ($as_id) {

                    $existingdate = DB::table('slots')
                        ->where('slot_time', $value)
                        ->where('as_id', $as_id)
                        ->first();

                    if ($existingdate) {
                        $fail("Υπάρχει ήδη slot με τη συγκεκριμένη την ημερομηνία" . $value);
                    }
                }],
            ]);

            if($validator->fails())
            {
                array_push($notindb,$row[0]);
            }
            if($validator->passes()) {
                date_default_timezone_set('Europe/Athens');
                DB::table('slots')->insert([
                    'as_id' => $as_id,
                    'slot_time' => $row[0],
                    'am'=>' ',

                ]);
            }
        }

        return redirect()->back()->with([
            'message' =>(count($notindb)==0 || count($notindb)<count($dates))? 'Τα δεδομένα προσθέθηκαν επιτυχώς!':null,
            'warning' => count($notindb)>0 ? 'Δεν προσθέθηκαν τα slot με της ημερομηνίες '.json_encode($notindb).'. Τα προαναφερόλενα slot, υπάρχουν ήδη!' : null,
        ]);


    }
    //εξαγωγή slots σε αρχείο
    public function exportslots(Request $request){
        $as_id=$request->input('as_id');
        $at_id=$request->input('at_id');
        $filename=$request->input('filename');
        $filename=$filename.'.xlsx';
        return Excel::download(new SlotsExport($as_id,$at_id), $filename);
        return redirect()->back()->with('message','Τα δεδομένα προσθέθηκαν επιτυχώς!');
    }


}
