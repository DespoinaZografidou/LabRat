<?php

namespace App\Http\Controllers;

use App\Exports\ChooseThemesExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class ActivityChooseThemeController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //εμφάνιση όλων των δραστηριότήτων Επιλογής Θεμάτων του μαθήματος
    public function index($l_id, $title, $name)
    {
        $data = DB::table('activity_choose_theme AS A')->
        select('A.*', 'T.title as at_title')->
        leftJoin('activity_team AS T', 'T.id', '=', 'A.at_id')->
        where('A.l_id', '=', $l_id)->
        orderby('A.created_at', 'desc')->paginate(15);


        //εμφάνιση των δραστηριοτήτων teams  για την επιλογή συσχετιζόμενης δραστηριότητας teams
        $actteams = DB::table('activity_team')->
        select('id', 'title')->
        where('l_id', '=', $l_id)->
        where('status', '=', 1)->
        orderby('created_at', 'desc')->get();

        return view('choose_theme_activities', ['title' => $title, 'l_id' => $l_id, 'name' => $name, 'themes' => $data, 'actteams' => json_encode($actteams)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // δημιουργία/ενημέρωση κάποιας δραστηριότητας Επιλογής θεμάτων
    public function create_update(Request $request)
    {
        try {
            $l_id = $request->input('l_id');
            $as_id = $request->input('act_id');
            $title = $request->input('title');
            $at_id = $request->input('at_id');
            $text = $request->input('text');


            date_default_timezone_set('Europe/Athens');
            $startdate = date('Y-m-d H:i:s', strtotime($request->input('startdate')));
            $enddate = date('Y-m-d H:i:s', strtotime($request->input('enddate')));

            // Check if the end date is before the start date
            if ($enddate < $startdate) {
                return redirect()->back()->with('warning', 'Η προσθήκη των δεδομένων έγινε ανεπιτυχώς!. Η ημερομηνία έναρξης και λήξης δεν ήταν λάθος καταχωρημένες!');
            }

            if ($request->input('action') == 'add') {
                // Create a new record within a transaction
                DB::transaction(function () use ($l_id, $title, $text, $startdate, $enddate, $at_id) {
                    DB::insert('insert into activity_choose_theme (l_id, title, text, created_at, updated_at, at_id) values (?, ?, ?, ?, ?, ?)', [$l_id, $title, $text, $startdate, $enddate, $at_id]);
                });

                return redirect()->back()->with('message', 'Η προσθήκη των δεδομένων έγινε επιτυχώς!');
            }

            if ($request->input('action') == 'update') {
                // Update the record with a locking mechanism within a transaction
                DB::transaction(function () use ($l_id, $title, $text, $startdate, $enddate, $at_id, $as_id) {
                    // Apply lock for update
                    DB::table('activity_choose_theme')
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

                return redirect()->back()->with('message', 'Η ανανέωση πληροφοριών έγινε επιτυχώς!');
            }
        } catch (\Exception $e) {
            // Handle exceptions that might occur within the transactions
            return redirect()->back()->with('warning', 'Προέκυψε σφάλμα κατά την εκτέλεση της ενέργειας.');
        }
    }


    //Διαγραφή μίας δραστηριότητας επιλογής θεμάτος
    public function destroy(Request $request)
    {
        try {
            $id = $request->input('ct_id');

            // Check if the record exists before attempting deletion
            $recordExists = DB::table('activity_choose_theme')->where('id', $id)->exists();
            if (!$recordExists) {
                return redirect()->back()->with('warning', 'Η δραστηριότητα που προσπαθήσατε να διαγράψετε δεν υπάρχει.');
            }

            // Delete the record within a transaction
            DB::transaction(function () use ($id) {
                DB::delete('delete from activity_choose_theme where id = ?', [$id]);
            });

            return redirect()->back()->with('message', 'Η διαγραφή της δραστηριότητας έγινε επιτυχώς!');
        } catch (\Exception $e) {
            // Handle exceptions that might occur within the transaction
            return redirect()->back()->with('warning', 'Προέκυψε σφάλμα κατά τη διαγραφή της δραστηριότητας.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    //Εμφάνιση μίας συγκεκριμένης δραστηριότητας θέματος
    public function showTheActivityThemes($l_id, $title, $name, $ct_id, Request $request)
    {
            $activity = DB::table('activity_choose_theme')->where('id', '=', $ct_id)->get();
            $data = '';
            $counter = '';
            $teamorpart = '';
            $role = $request->input('role');
            $am = $request->input('am');


            foreach ($activity as $a) {
                //αν ύπάρχει συσχετιζόμενη δραστηριότητα ομάδα εμφάνισε όλα τα θέματα και τις ομάδες που συμμετέχουν
                if ($a->at_id !== null) {
                    $at_id = $a->at_id;

                    $data = DB::table('themes AS Th')
                        ->leftJoin('themes_choises AS TC', 'Th.id', '=', 'TC.th_id')
                        ->leftJoin('teams AS T', function ($join) use ($at_id) {
                            $join->on('T.t_id', '=', 'TC.am')
                                ->where('T.at_id', '=', $at_id);
                        })
                        ->leftJoin('users AS U', 'U.am', '=', 'T.am')
                        ->select('Th.*', 'T.t_id as am', DB::raw("GROUP_CONCAT(U.am,' - ',U.name) AS part"))
                        ->where('Th.ct_id', '=', $ct_id)
                        ->groupBy('T.t_id', 'Th.id', 'Th.ct_id', 'Th.title', 'Th.text', 'Th.file', 'Th.excusive')
                        ->orderBy('Th.title')
                        ->get();

                    //Αν ο χρήστης δεν είναι μαθητής εμφάνισε όλες τις ομάδες από τη συσχετιζόμενη δραστηριότητα ομάδα
                    if ($role !== 'Μαθητής') {
                        $query="SELECT GROUP_CONCAT(U.am, '-', U.name) as info, T.t_id as am FROM teams AS T JOIN users AS U ON T.am=U.am WHERE T.at_id=".$at_id." GROUP BY T.t_id EXCEPT SELECT GROUP_CONCAT(U.am, '-', U.name) as info, T.t_id as am FROM themes AS Th LEFT JOIN themes_choises AS TC ON Th.id=TC.th_id LEFT JOIN teams AS T ON T.t_id=TC.am AND T.at_id=".$at_id." LEFT JOIN users AS U ON T.am=U.am WHERE Th.ct_id=".$ct_id." GROUP BY T.t_id";
                        $teamorpart = DB::select(DB::raw($query));

                    }
                    //Αν ο χρήστης είναι μαθητής εμφάνισε την ομάδα του χρήστη από την δραστηριότητα ομάδα
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
                }
                // Αν δεν ύπάρχει συσχετιζόμενη δραστηριότητα ομάδα εμφάνισε τα θέματα με τους μαθητές που δέσμευσαν τα θέματα
                else {
                    $data = DB::table('themes')
                        ->select('themes.*', 'users.am', DB::raw('CONCAT(users.am, " - ", users.name) AS part'))
                        ->leftJoin('themes_choises', 'themes.id', '=', 'themes_choises.th_id')
                        ->leftJoin('users', 'users.am', '=', 'themes_choises.am')
                        ->where('themes.ct_id', '=', $ct_id)
                        ->orderBy('themes.title')
                        ->get();
                    //Αν ο χρήστης δεν είναι μαθητής επέστρεψε όλους τους μαθητές που συμμετέχουν στο μάθημα
                    if ($role !== 'Μαθητής') {
                        $query="SELECT CONCAT(U.am, '-', U.name) as info, P.am as am FROM participations AS P JOIN users AS U ON P.am=U.am AND P.l_id='".$l_id."' EXCEPT SELECT CONCAT(U.am, '-', U.name) as info, U.am as am FROM themes AS Th LEFT JOIN themes_choises AS TC ON Th.id=TC.th_id LEFT JOIN users AS U ON TC.am=U.am WHERE Th.ct_id=".$ct_id.";";
                        $teamorpart = DB::select(DB::raw($query));
                    }
                    //Αν χρήστης είναι μαθητής τότε επέστρεψε το όνομά του και τα στοιχεία του
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
            $c_themes=DB::table('themes AS Th')
                ->where('Th.ct_id', '=', $ct_id)
                ->count('*');
            return view('allthethemes', ['title' => $title, 'l_id' => $l_id, 'name' => $name, 'activity' => $activity, 'themes' => $data, 'c_themes'=>$c_themes,'info' => $counter, 'teamorpart' => json_encode($teamorpart)]);
    }


    //δημιουργία/ανανέωση θέματος στο αρχείο( allthethemes.blade.php) για τον καθηγητή κσι το διαχειριστή
    public function create_update_theme(Request $request)
    {
        $act_id=$request->input('act_id');
        $title = $request->input('title');
        $text=$request->input('text');
        if($text===null){
            $text='';
        }
        $exclusive=intval($request->input('exclusive'));
        $fileName=' ';
        if ($request->file('file')!==null) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('themes'), $fileName);
        }

        if($request->input('action')==='create'){
            DB::insert('insert into themes (ct_id,title,text,file,excusive) values (?,?,?,?,?)', [$act_id, $title, $text,$fileName,$exclusive]);
            return redirect()->back()->with('message','Η δημιουργία θέματος έγινε επιτυχώς!');
        }
        if($request->input('action')==='update'){
            $id=$request->input('id');

            if ($request->file('file')!==null) {
                DB::transaction(function () use ($act_id, $title, $text, $exclusive, $fileName, $id) {

                    DB::table('themes')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->update([
                            'ct_id' => $act_id,
                            'title' => $title,
                            'text' => $text,
                            'file' => $fileName,
                            'excusive' => $exclusive,
                        ]);
                });
            }else{
                DB::transaction(function () use ($act_id, $title, $text, $exclusive, $id) {
                    DB::table('themes')
                        ->where('id', $id)
                        ->lockForUpdate()
                        ->update([
                            'ct_id' => $act_id,
                            'title' => $title,
                            'text' => $text,
                            'excusive' => $exclusive,
                        ]);
                });
            }
            return redirect()->back()->with('message','Η ανανέωση του θέματος έγινε επιτυχώς');
        }

    }
        /**
         * Show the form for editing the specified resource.
         *
         * @param int $id
         * @return \Illuminate\Http\Response
         */

        //Διαγραφή θέματος
        public function deleteTheme(Request $request)
        {
            try {
                $id = $request->input('id');

                // Έλεγχος αν υπάρχει αυτή η η εγγραφή
                $recordExists = DB::table('themes')->where('id', $id)->exists();
                if (!$recordExists) {
                return redirect()->back()->with('warning', 'Το θέμα που προσπαθήσατε να διαγράψετε δεν υπάρχει.');
                }


                DB::transaction(function () use ($id) {
                    DB::delete('delete from themes where id = ?', [$id]);
                });

            return redirect()->back()->with('message', 'Η διαγραφή της δραστηριότητας έγινε επιτυχώς!');
            } catch (\Exception $e) {
                // Handle exceptions that might occur within the transaction
                return redirect()->back()->with('warning', 'Προέκυψε σφάλμα κατά τη διαγραφή της δραστηριότητας.');
            }
        }

        // download το αρχείο περιγραφής του θέματος
        public function downloadthemedescription($filename){
            $filePath = public_path('themes/' . $filename); // Replace with the actual file path
            return response()->download($filePath, $filename);
        }


    //δέσμεση θέματος από κάποιον μαθητή ή όμάδας
    public function JoinTheTheme(Request $request){
        return DB::transaction(function () use ($request) {
        $th_id=$request->input('th_id');
        $am=$request->input('am');

        $at_id=$request->input('at_id');
        $message=$request->input('names');
        $act_id=$request->input('act_id');
        $exclusive=$request->input('exclusive');

        //Αν το θέμα είναι ήδη δεσμευμένο
        $check1=DB::table('themes_choises')->where('th_id','=',$th_id)->lockForUpdate()->first();

        //Αν υπάρχει θέμα που ο συγκεκριμένος μαθητής/ομαδα έχει δεσμεύσει ήδη στην ίδια δραστηριότητα
        $check2=DB::table('themes_choises')->where('ct_id','=',$act_id)->where('am','=',$am)->lockForUpdate()->first();


        //Αν το θέμα είναι ήδη δεσμευμένο και είναι αποκλειστικό
        if($check1 && $exclusive==1){
                return redirect()->back()->with('warning','Το θέμα είναι ήδη δεσμευμένο!');
        }

        //αν υπάρχει ήδη άλλο θέμα που ο χρήστης/ομάδα έχει δηλώσει αποδέσμευσε το παλίο θέμα και δέσμευσε την καινούργια του επιλογή
            //δημιούργησε τις κατάλληλες ειδοποιήσεις.
        if($check2){
            if($at_id==null) {
                DB::table('choose_themes_notifications')
                    ->where('th_id', $check2->th_id)
                    ->where('receiver_am', $am)
                    ->update(['msg' => DB::raw("CONCAT(msg, 'αποδεσμεύτηκε')"),]);
            }
            else{
                $receivers=DB::table('teams')
                    ->select('am')
                    ->where('t_id','=',$am)
                    ->where('at_id','=',$at_id)
                    ->get();
                foreach($receivers as $r) {
                    DB::table('choose_themes_notifications')
                        ->where('th_id', $check2->th_id)
                        ->where('receiver_am', $r->am)
                        ->update(['msg' => DB::raw("CONCAT(msg, ' αποδεσμεύτηκε')"),]);
                }

            }
            DB::delete('delete from themes_choises where id=?',[$check2->id]);
        }
            //αλλιως εισήγαγε την δέσμεση
        DB::insert('insert into themes_choises (th_id,am,ct_id) values (?,?,?)',[$th_id,$am,$act_id]);

        //δημιουργία ειδοποιήσεων
        if($at_id==null){
            $message='';
            DB::insert('insert into choose_themes_notifications (th_id,msg,receiver_am) values (?,?,?)',[$th_id,$message,$am]);
        }
        else{
            $receivers=DB::table('teams')
                ->select('am')
                ->where('t_id','=',$am)
                ->where('at_id','=',$at_id)
                ->get();
            foreach($receivers as $r) {
                DB::insert('insert into choose_themes_notifications (th_id,msg,receiver_am) values (?,?,?)',[$th_id,$message,$r->am]);
            }
        }

        return redirect()->back()->with('message','Το θέμα δεσμέυτηκε επιτυχώς!');
        });
    }



    //εισαγωγή νέων θέματος μέσω αρχείου
    public function importThemes(Request $request){
        $file=$request->file('file');
        $act_id=$request->input('act_id');

        $data = Excel::toArray([], $file)[0];
        array_shift($data); // remove the first row
        // Iterate through the data and cast specific columns to timestamps

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
                    $existingdate = DB::table('themes')
                        ->where('title', $value)
                        ->where('ct_id', $act_id)
                        ->first();

                    if ($existingdate) {
                        $fail("Υπάρχει ήδη θέμα με το τίτλο '" . $value."'");
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
                DB::table('themes')->insert([
                    'ct_id' => $act_id,
                    'title' => $row[0],
                    'text'=> $formattedText,
                    'file'=>' ',
                    'excusive'=>$row[2]

                ]);
            }
        }

        return redirect()->back()->with([
            'message' =>(count($notindb)==0 || count($notindb)<count($data))? 'Τα δεδομένα προσθέθηκαν επιτυχώς!':null,
            'warning' => count($notindb)>0 ? 'Δεν προσθέθηκαν τα θέματα με τους τίτλους '.json_encode($notindb).'. Τα προαναφερόλενα θέματα, υπάρχουν ήδη!' : null,
        ]);

    }

   //κατέβασε το αρχείο με τις συμμετοχές του κάθε θέματος
    public function exportThemes(Request $request){
        $act_id=$request->input('act_id');
        $at_id=$request->input('at_id');
        $filename=$request->input('filename');
        $filename=$filename.'.xlsx';
        return Excel::download(new ChooseThemesExport($act_id,$at_id), $filename);
        return redirect()->back();
    }
}


