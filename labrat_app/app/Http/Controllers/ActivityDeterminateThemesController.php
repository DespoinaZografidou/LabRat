<?php

namespace App\Http\Controllers;

use App\Exports\DeterminateThemesExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ActivityDeterminateThemesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //Εμφάνιση όλων των δραστηριοτήτων προσδιορισμός θεμάτων
    public function index($l_id,$title,$name)
    {
        $data= DB::table('activity_determinate_themes AS A')->
        select('A.*','T.title as at_title')->
        leftJoin('activity_team AS T','T.id','=','A.at_id')->
        where('A.l_id','=',$l_id)->
        orderby('A.created_at', 'desc')->paginate(15);

        //εμφάνιση των δραστηριοτήτων teams  για την επιλογή συσχετιζόμενης δραστηριότητας teams
        $actteams= DB::table('activity_team')->select('id', 'title')->where('l_id', '=', $l_id)->where('status', '=', 1)->orderby('created_at', 'desc')->get();

        return view('determinate_theme_activities',['title'=>$title,'l_id'=>$l_id,'name'=>$name,'themes'=>$data,'actteams'=>json_encode($actteams)]);
    }

    // δημιουργία/ενημερώση μιας δραστηριότητας προσδιορισμός θεμάτων
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
        $confirm=$request->input("confirmation");

        date_default_timezone_set('Europe/Athens');
        $startdate=date('Y-m-d H:i:s', strtotime($request->input('startdate')));
        $enddate=date('Y-m-d H:i:s', strtotime($request->input('enddate')));

        //έλεγχος αν οι ημερομήνίες λήξης και έναρξης είναι έγκυρες
        if($enddate<$startdate){
            return redirect()->back()->with('warning','Η προσθήκη των δεδωμένων έγινε ανεπιτυχώς!. Η ημερομηνία έναρξης και λήξης δεν ήταν λάθος καταχωρημένες!');
        }
        // αν είναι για τη δημιουργία δραστηριότητας
        if($request->input('action')=='add'){
            DB::transaction(function () use ($l_id,$title,$text,$startdate,$enddate,$at_id,$as_id,$confirm) {
                DB::insert('insert into activity_determinate_themes (l_id,title,text,created_at,updated_at,at_id,confirmation) values (?,?,?,?,?,?,?)', [$l_id, $title, $text, $startdate, $enddate, $at_id,$confirm]);
            });
            return redirect()->back()->with('message','Η προσθήκη των δεδομένων έγινε επιτυχώς!');
        }
        // αν είναι για τη ενημέρωση δραστηριότητας
        if($request->input('action')=='update'){
            DB::transaction(function () use ($l_id,$title,$text,$startdate,$enddate,$at_id,$as_id,$confirm) {
                DB::update('update activity_determinate_themes set l_id=?,title=?,text=?,created_at=?,updated_at=?,at_id=?,confirmation=? where id=?', [$l_id, $title, $text, $startdate, $enddate, $at_id, $confirm ,$as_id]);
            });
            return redirect()->back()->with('message','Η ανανέωση πληροφοριών έγινε επιτυχώς!');
        }
        } catch (\Exception $e) {
            // Handle exceptions that might occur within the transactions
            return redirect()->back()->with('warning', 'Προέκυψε σφάλμα κατά την εκτέλεση της ενέργειας.');
        }

    }

    //Διαγρφή μίας δραστηριότητας προσδιορισμός θεμάτων
    public function destroy(Request $request){
        try {
        $id=$request->input('dt_id');
            // Check if the record exists before attempting deletion
            $recordExists = DB::table('activity_determinate_themes')->where('id', $id)->exists();
            if (!$recordExists) {
                return redirect()->back()->with('warning', 'Η δραστηριότητα που προσπαθήσατε να διαγράψετε δεν υπάρχει.');
            }

        DB::transaction(function () use ($id) {
            DB::delete('delete from activity_determinate_themes where id=?', [$id]);
        });
        return redirect()->back()->with('message','Η διαγραφή της δραστηριότητας έγινε επιτυχώς!');
        } catch (\Exception $e) {
            // Handle exceptions that might occur within the transaction
            return redirect()->back()->with('warning', 'Προέκυψε σφάλμα κατά τη διαγραφή της δραστηριότητας.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //Εμφάνιση δραστηριότητας προσδιορισμός θεμάτων
    public function showTheActivityDetermination($l_id, $title, $name, $dt_id, Request $request)
    {
        $activity = DB::table('activity_determinate_themes')->where('id', '=', $dt_id)->get();
        $data = '';
        $counter = '';
        $teamorpart = '';
        $role = $request->input('role');
        $am = $request->input('am');


        foreach ($activity as $a) {
             // αν δεν υπάρχει συσχετιζόμενη δραστηριότητα ομάδας
            if ($a->at_id != null) {
                $at_id = $a->at_id;
            //εφμάνιση όλων των περιοδικών και των μαθητών/συμμετοχών της δραστηριότητας
                $data = DB::table('journals AS J')
                    ->leftJoin('determinate_themes AS D', 'J.id', '=', 'D.j_id')
                    ->leftJoin('teams AS T', function ($join) use ($at_id) {
                        $join->on('T.t_id', '=', 'D.am')
                            ->where('T.at_id', '=', $at_id);
                    })
                    ->leftJoin('users AS U', 'U.am', '=', 'T.am')
                    ->select('J.*', 'T.t_id as am','D.id as d_id','D.title AS d_title','D.confirm',DB::raw("GROUP_CONCAT(U.am,'-',U.name) AS part"))
                    ->where('J.adt_id', '=', $dt_id)
                    ->groupBy('T.t_id', 'J.id', 'J.adt_id', 'J.title', 'J.text','J.link','D.title','D.id','D.confirm')
                    ->orderBy('J.title')
                    ->orderBy('D.title')
                    ->get();

                //Αν ο χρήστης είναι δεν είναι μαθητής εμφάνισε μία λίστα με τα ονόματα όλων των μαθητών που συμετέχουν στο μάθημα
                if ($role !== 'Μαθητής') {
                    $query="SELECT GROUP_CONCAT(U.am, '-', U.name) as info, T.t_id as am FROM teams AS T JOIN users AS U ON T.am=U.am WHERE T.at_id=".$at_id." GROUP BY T.t_id EXCEPT SELECT GROUP_CONCAT(U.am, '-', U.name) as info, T.t_id as am FROM journals AS J LEFT JOIN determinate_themes AS D ON j.id=D.j_id LEFT JOIN teams AS T ON T.t_id=D.am AND T.at_id=".$at_id." LEFT JOIN users AS U ON T.am=U.am WHERE J.adt_id=".$dt_id." GROUP BY T.t_id";
                    $teamorpart = DB::select(DB::raw($query));


                }
                //Αν ο χρήστης είναι μαθητής τότε εμφάνισε τα στοιχεία του για πιθανή δεσμεύση
                if ($role === 'Μαθητής') {
                    $teamorpart = DB::table('teams AS T')
                        ->select('T.t_id as am', DB::raw('GROUP_CONCAT(U.am, "-", U.name) as info'))
                        ->leftJoin('teams AS T1', function ($join) {
                            $join->on('T1.t_id', '=', 'T.t_id')
                                ->on('T1.at_id', '=', 'T.at_id');
                        })
                        ->join('users AS U', 'T1.am', '=', 'U.am')
                        ->where('T.am', '=', $am)
                        ->where('T.at_id', '=', $a->at_id)
                        ->groupBy('T.t_id')
                        ->get();
                }
                $counter = 'Αριθμός Ομάδων: ' . count($teamorpart);
            }//αν ύπάρχει συσχετιζόμενη δραστηριότητα ομάδα εμφάνισε ολά τα περιοδικά και τις αντιστοιχες ομάδες που τα έχουν δεσμεύσει
            else {
                $data = DB::table('journals as J')
                    ->select('J.*', 'users.am','D.id as d_id', 'D.title AS d_title','D.confirm',DB::raw('CONCAT(users.am, " - ", users.name) AS part'))
                    ->leftJoin('determinate_themes AS D', 'J.id', '=', 'D.j_id')
                    ->leftJoin('users', 'users.am', '=', 'D.am')
                    ->where('J.adt_id', '=', $dt_id)
                    ->orderBy('J.title')
                    ->orderBy('D.title')
                    ->get();
                //Αν ο χρήστης δεν είναι μαθητής εμφάνισε όλες τις ομάδες της συσχετιζόμενης δραστηριότητας ομάδα
                if ($role !== 'Μαθητής') {
                    $query="SELECT CONCAT(U.am, '-', U.name) as info, P.am as am FROM participations AS P JOIN users AS U ON P.am=U.am AND P.l_id='".$l_id."' EXCEPT SELECT CONCAT(U.am, '-', U.name) as info, U.am as am FROM journals AS J LEFT JOIN determinate_themes AS D ON J.id=D.j_id LEFT JOIN users AS U ON D.am=U.am WHERE J.adt_id=".$dt_id.";";
                    $teamorpart = DB::select(DB::raw($query));
                }
                //Αν ο χρήστης είναι μαθητής εμφάνισε την ομάδα του από τη συσχετιζόμενη δραστηριότητα ομάδα
                if ($role === 'Μαθητής') {
                    $teamorpart = DB::table('participations AS P')
                        ->select(DB::raw('CONCAT(U.am, "-", U.name) as info'), 'P.am as am')
                        ->join('users AS U', 'U.am', '=', 'P.am')
                        ->where('P.l_id', '=', $l_id)
                        ->where('P.am', '=', $am)
                        ->get();
                }
                $counter = 'Αριθμός Συμμετοχών: ' . count($teamorpart);
            }
        }
        $c_themes=DB::table('journals AS J')
            ->where('J.adt_id', '=', $dt_id)
            ->count('*');
        return view('allthejournals', ['title' => $title, 'l_id' => $l_id, 'name' => $name, 'activity' => $activity, 'themes' => $data, 'c_themes'=>$c_themes,'info' => $counter, 'teamorpart' => json_encode($teamorpart)]);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Δημιουργία/ενημέρωση περιοδικού από τον καθηγητή/διαχειριστή
    public function create_update_journal(Request $request)
    {
        $act_id=$request->input('act_id');
        $title = $request->input('title');
        $text=$request->input('text');
        $link=$request->input('link');
        if($text===null){
            $text='';
        }

        if($request->input('action')==='create'){
            $check=DB::table('journals as J')
                ->where('adt_id','=',$act_id)
                ->where('title','=',$title)->first();
            if($check){
                return redirect()->back()->with('warning', 'Η δημιουργία του Περιοδικού/Θέματος απέτυχε! Υπάρχει ήδη περιοδικό/θέμα με το συγκεκριμένο τίτλο σε αυτή τη δραστηριότητα');
            }

            DB::insert('insert into journals (adt_id,title,text,link) values (?,?,?,?)', [$act_id, $title, $text, $link]);
            return redirect()->back()->with('message','Η δημιουργία Περιοδικού/θέματος έγινε επιτυχώς!');

        }
        if($request->input('action')==='update'){
            $id=$request->input('id');
            // Update the record with a locking mechanism within a transaction
                DB::transaction(function () use ($act_id, $title, $text, $link,$id) {
                    // Apply lock for update

                    DB::table('journals')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->update([
                            'adt_id' => $act_id,
                            'title' => $title,
                            'text' => $text,
                            'link' => $link,
                        ]);
                });

            return redirect()->back()->with('message','Η ανανέωση του Περιοδικού/θέματος έγινε επιτυχώς');
        }

    }

    // Διαγραφή περιοδικού
    public function deleteJournals(Request $request)
    {
        try {
            $id = $request->input('id');

            // Check if the record exists before attempting deletion
            $recordExists = DB::table('journals')->where('id', $id)->exists();
            $participations=DB::table('determinate_themes')->where('j_id','=',$id)->first();
            if (!$recordExists) {
                return redirect()->back()->with('warning', 'Το Περιοδικό/θέμα που προσπαθήσατε να διαγράψετε δεν υπάρχει.');
            }
            if($participations)
            {
                return redirect()->back()->with('warning', 'Το Περιοδικό/θέμα που προσπαθήσατε να διαγράψετε, δεν δύναται να διαγραφεί διότι υπάρχουν συμμετοχές.');
            }

            // Delete the record within a transaction
            DB::transaction(function () use ($id) {
                DB::delete('delete from journals where id = ?', [$id]);
            });

            return redirect()->back()->with('message', 'Η διαγραφή του Περιοδικό/θέμα έγινε επιτυχώς!');
        } catch (\Exception $e) {
            // Handle exceptions that might occur within the transaction
            return redirect()->back()->with('warning','Προέκυψε σφάλμα κατά τη διάρκεια αυτής της ενέργειας');
        }
    }

    // Προσθήκη πολλαπλών άρθρων σε ένα περιοδικό μιας δραστηριότητας Προσδιορισμός θεμάτων
    public function add_paper(Request $request)
    {
        $j_id=$request->input('j_id');
        $act_id=$request->input('dt_id');
        $titles=$request->input('title',[]);
        $confirm=1;
        $am=' ';
        $existingtitles=[];

         foreach ($titles as $t)
         {
             $check = DB::table('determinate_themes as D')
                 ->where('j_id', '=', $j_id)
                 ->where('adt_id','=', $act_id)
                 ->where('title', 'LIKE', '%' . $t . '%')->first();

             if($check){
                 array_push($existingtitles, $t);
             }
             else{
                 DB::table('determinate_themes')->insert([
                     'adt_id' => $act_id,
                     'j_id' => $j_id,
                     'title' => $t,
                     'am' => $am,
                     'confirm' => $confirm
                 ]);
             }
         }
        return redirect()->back()
            ->with('message', (count($existingtitles)<count($titles)) ? 'Η δημιουργία των Άρθρων/Θεμάτων έγινε επιτυχώς!' : null)
            ->with('warning', (count($existingtitles)>1 || count($existingtitles)==count($titles)) ?'Η δημιουργία των Άρθρων/Θεμάτων '.json_encode($existingtitles,JSON_UNESCAPED_UNICODE).' απέτυχε! Υπάρχει ήδη άρθρο/θέμα με το συγκεκριμένο τίτλο σε αυτό το περιοδικό/θέμα':null);
    }


    //δεσμευση Αρθρου από ομάδα/μαθητή
    public function jointhepaper(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $id = $request->input('dt_id');
            $act_id = $request->input('act_id');
            $message=$request->input('names');
            $am = $request->input('am');
            $at_id = $request->input('at_id');


            //Αν το θέμα είναι ήδη δεσμευμένο
            $check1 = DB::table('determinate_themes')->where('id', '=', $id)->lockForUpdate()->first();
            //Αν υπάρχει θέμα που ο συγκεκριμένος μαθητής/ομαδα έχει δεσμεύσει ήδη στην ίδια δραστηριότητα
            $check2 = DB::table('determinate_themes')->where('adt_id', '=', $act_id)->where('am', '=', $am)->lockForUpdate()->first();

            //Αν το θέμα είναι ήδη δεσμευμένο και είναι αποκλειστικό
            if ($check1->am!==' ') { return redirect()->back()->with('warning', 'Το θέμα είναι ήδη δεσμευμένο!'); }

            //αν υπάρχει ήδη άλλο θέμα που ο χρήστης/ομάδα έχει δηλώσει
            if ($check2) {
                // αν δεν υπάρχει συσχετιζόμενη δραστηριότητα ομάδα
                if ($at_id == null) {
                    DB::table('determinate_themes_notifications')
                        ->where('dt_id', $id)
                        ->where('receiver_am', $am)
                        ->update(['msg' => DB::raw("CONCAT(msg, ' αποδεσμεύτηκε')"),]);
                }
                //αν υπάρχει συσχετιζόμενη ομάδα
                else {

                    // Αλλιώς δεσμευσε το Άρθρο και δημιούργησε τις κατάλληλες ειδοποιήσεις για του μαθητές
                    $receivers = DB::table('teams')
                        ->select('am')
                        ->where('t_id', '=', $am)
                        ->where('at_id', '=', $at_id)
                        ->get();
                    foreach ($receivers as $r) {
                        DB::table('determinate_themes_notifications')
                            ->where('dt_id', $check2->id)
                            ->where('receiver_am', $r->am)
                            ->update(['msg' => DB::raw("CONCAT(msg, ' αποδεσμεύτηκε')"),]);
                    }
                }

                DB::table('determinate_themes')->where('id', '=', $check2->id)->update(['am' => ' ',]);
            }
    // αν δεν υπαρχει άρθρο που ο μαθητής/ομαδα να έχει δηλώσει
            //αν δεν υπάρχει συσχετιζόμενη ομάδα δημιούργησε την αντίστοιχη ειδοποίηση για τη δέσμευση του άρθρου από τον μαθητή
            if ($at_id == null){
                DB::table('determinate_themes_notifications')
                    ->insert(['dt_id'=>$id, 'msg'=>' ', 'receiver_am'=>$am]);
            }
            // Αν υπάρχει συσχετιζόμενη ομάδα δημιούργησε τις αντίστοιχες ειδοποιήσεις για τη δέσμευση του άρθρου από τον μαθητή
            else{
                $receivers = DB::table('teams')
                    ->select('am')
                    ->where('t_id', '=', $am)
                    ->where('at_id', '=', $at_id)
                    ->get();
                foreach ($receivers as $r) {
                    DB::table('determinate_themes_notifications')
                        ->insert([
                            'dt_id'=>$id,
                            'msg'=>$message,
                            'receiver_am'=>$r->am
                        ]);
                }
            }
            //δέσμευσε το θέμα
            DB::table('determinate_themes')->where('id', '=', $id)->update(['am' => $am,]);
            return redirect()->back()->with('message', 'Η δέσμευση του Άρθρου/Θέματος έγινε επιτυχώς!');
        });

    }

    //διαγραφή άρθρου
    public function deletepaper(Request $request)
    {
        try {
            $id = $request->input('d_id');

            // Έλεγχος αν υπάρχει η εγγραφή ακόμα
            $recordExists = DB::table('determinate_themes')->where('id', $id)->exists();
            // Έλεγχος αν υπάρχει το άρθρο είναι δεσμευμένο
            $participations=DB::table('determinate_themes')->where('id','=',$id)->first();
            if (!$recordExists) {
                return redirect()->back()->with('warning', 'Το Άρθρο/θέμα που προσπαθήσατε να διαγράψετε δεν υπάρχει.');
            }
            if($participations->am!==' ') {
                return redirect()->back()->with('warning', 'Το Άρθρο/θέμα που προσπαθήσατε να διαγράψετε, δεν δύναται να διαγραφεί διότι υπάρχουν συμμετοχές.');
            }

            // αν δεν είναι δεσμευμένο και ύπαρχει ακόμα η εγγραφή διεγραψε το άρθρο
            DB::transaction(function () use ($id) {
                DB::delete('delete from determinate_themes where id = ?', [$id]);
            });

            return redirect()->back()->with('message', 'Η διαγραφή του Άρθρο/θέμα έγινε επιτυχώς!');
        } catch (\Exception $e) {
            // Handle exceptions that might occur within the transaction
            return redirect()->back()->with('warning', 'Προέκυψε σφάλμα κατά τη διάρκεια αυτής της ενέργειας');
        }
    }

    // συμμετοχή σε συγκεκριμένο περιοδικό και εισαγωγή άρθρου που θέλει να δεσμεύσει ο μαθητή/ η ομαδα
    public function jointheJournal(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $title = $request->input('title');
            $act_id = $request->input('act_id');
            $message=$request->input('names');
            $am = $request->input('am');
            $at_id = $request->input('at_id');
            $j_id = $request->input('j_id');
            $confirm=$request->input('con');
            if($confirm===null)
            {
                $confirm=0;
            }

            //Αν το θέμα είναι ήδη δεσμευμένο
            $check1 = DB::table('determinate_themes')->where('adt_id', '=', $act_id)->where('title', 'LIKE','%'.$title.'%')->lockForUpdate()->first();
            //Αν υπάρχει θέμα που ο συγκεκριμένος μαθητής/ομαδα έχει δεσμεύσει ήδη στην ίδια δραστηριότητα
            $check2 = DB::table('determinate_themes')->where('adt_id', '=', $act_id)->where('am', '=', $am)->lockForUpdate()->first();

            //Αν το θέμα είναι ήδη δεσμευμένο και είναι αποκλειστικό
            if ($check1) { return redirect()->back()->with('warning', 'Το θέμα είναι ήδη δεσμευμένο!'); }

            //αν υπάρχει ήδη άλλο θέμα που ο χρήστης/ομάδα έχει δηλώσει
            if ($check2) {
               DB::delete('delete from determinate_themes where id=?',[$check2->id]);
            }

            //Εισαγωγή Άρθρου
            $newRowId= DB::table('determinate_themes')
                ->insertGetId(['adt_id'=>$act_id,'j_id'=>$j_id,'title'=>$title,'am' => $am,'confirm'=>$confirm]);

            //Αν δεν υπάρχει συσχετιζόμεη ομάδα
            if ($at_id == null){
                DB::table('determinate_themes_notifications')
                    ->insert(['dt_id'=> $newRowId, 'msg'=>' ', 'receiver_am'=>$am]);
            }else{
                //Αν υπάρχει συσχετιζόμενη ομάδα
                $receivers = DB::table('teams')
                    ->select('am')
                    ->where('t_id', '=', $am)
                    ->where('at_id', '=', $at_id)
                    ->get();
                foreach ($receivers as $r) {
                    DB::table('determinate_themes_notifications')
                        ->insert([
                            'dt_id'=> $newRowId,
                            'msg'=>$message,
                            'receiver_am'=>$r->am
                        ]);
                }
            }

            return redirect()->back()->with('message', 'Η προσθήκη του Άρθρου/Θέματος έγινε επιτυχώς!');
        });

    }

    //  Επιβεβαίωση Άρθρου
    public function Confirm(Request $request){
        try {
        $confirm=1;
        $dt_id=$request->input('dt_id');
        DB::transaction(function () use ($dt_id,$confirm) {
            DB::table('determinate_themes')->where('id', '=', $dt_id)->lockForUpdate()->update(['confirm' => $confirm]);
        });
        return redirect()->back()->with('message', 'Η προσθήκη του Άρθρου/Θέματος έγινε επιτυχώς!');
        } catch (\Exception $e) {
            // Handle exceptions that might occur within the transaction
            return redirect()->back()->with('warning', 'Προέκυψε σφάλμα κατά τη διάρκεια αυτής της ενέργειας');
        }
    }


    //Απόρρυψη Άρθρου
    public function Reject(Request $request){
        try {
            $confirm=2;
            $dt_id=$request->input('dt_id');
            DB::transaction(function () use ($dt_id,$confirm) {
                DB::table('determinate_themes')->where('id', '=', $dt_id)->lockForUpdate()->update(['confirm' => $confirm]);
            });
            return redirect()->back()->with('message', 'Η προσθήκη του Άρθρου/Θέματος έγινε επιτυχώς!');
        } catch (\Exception $e) {
            // Handle exceptions that might occur within the transaction
            return redirect()->back()->with('warning', 'Προέκυψε σφάλμα κατά τη διάρκεια αυτής της ενέργειας');
        }
    }


    //εισαγωγή περιοδικών μέσω αρχείου
    public function importJournals(Request $request){
        $file=$request->file('file');
        $act_id=$request->input('act_id');

        $data = Excel::toArray([], $file)[0];
        array_shift($data); // remove the first row
        // Iterate through the data and cast specific columns to timestamps
        $data = array_map(function ($row) {
            if($row[2]=='' || $row[2]==null)
            $row[2] = null;
            return $row;
        }, $data);

        $notindb=[];
        $validator1 = Validator::make($request->all(), [
            'file' => 'required|mimes:xls,xlsx'
        ]);
        if($validator1->fails()) {
            return redirect()->back()->with('warning','Το αρχείο απαιτείται να είναι της μορφής .xls ή .xlsx');
        }

        foreach ($data as $row) {
            $validator = Validator::make($row, [
                0 => ['required', function ($attribute, $value, $fail) use ($act_id) {
                    $existingdate = DB::table('journals')
                        ->where('title',$value)
                        ->where('adt_id', $act_id)
                        ->first();

                    if ($existingdate) {
                        $fail("Υπάρχει ήδη θέμα/Περιοδικό με το τίτλο '" . $value."'");
                    }
                }],
            ]);

            if($validator->fails())
            {
                array_push($notindb,$row[0]);
            }
            if($validator->passes()) {
                $textLines = explode("\n", e($row[1])); // Split the text into lines
                $formattedText = '';
                foreach ($textLines as $line) {
                    $formattedText .= "<p>{$line}</p>\n"; // Wrap each line in <p> tags
                }
                DB::table('journals')->insert([
                    'adt_id' => $act_id,
                    'title' => $row[0],
                    'text'=> $formattedText,
                    'link'=>$row[2],
                ]);
            }
        }

        return redirect()->back()->with([
            'message' =>(count($notindb)==0 || count($notindb)<count($data))? 'Τα δεδομένα προσθέθηκαν επιτυχώς!':null,
            'warning' => count($notindb)>0 ? 'Δεν προσθέθηκαν τα θέματα/περιοδικά με τους τίτλους '.json_encode($notindb,JSON_UNESCAPED_UNICODE).'. Τα προαναφερόλενα θέματα/περιοδικά, υπάρχουν ήδη!' : null,
        ]);

    }


    //Εξαγωγή σε αρχείο τα περιοδικά,άρθρα και τις συμμετοχές
    public function exportJournals(Request $request){
        $act_id=$request->input('act_id');
        $at_id=$request->input('at_id');
        $filename=$request->input('filename');
        $filename=$filename.'.xlsx';
        return Excel::download(new DeterminateThemesExport($act_id,$at_id), $filename);
        return redirect()->back()->with('message','Τα δεδομένα προσθέθηκαν επιτυχώς!');
    }


}
