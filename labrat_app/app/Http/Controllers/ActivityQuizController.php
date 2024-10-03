<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityQuizController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Εμφάνισε τις δραστηριότητες Quiz
        public function index($l_id,$title,$name,Request $request)
        {
            $am = $request->input('am');
            $role = $request->input('role');
            if($role!=='Μαθητής')
            {

                $data = DB::table('activity_quiz AS Q')->
                select('Q.*')->
                where('Q.l_id', '=', $l_id)->
                orderby('Q.created_at', 'desc')->paginate(15);
            }
        else{
            $data = DB::table('activity_quiz AS Q')
                ->select('Q.*')
                ->selectRaw('(SELECT COUNT(T.am) FROM quiz_tries AS T WHERE T.aq_id = Q.id AND T.am = ?) as allthetries', [$am])
                ->selectRaw('(SELECT finalscore FROM quiz_tries AS T WHERE T.aq_id = Q.id AND T.am = ? ORDER BY T.id DESC LIMIT 1) as finalgrade', [$am])
                ->selectRaw('(SELECT SUM(maxgrade) FROM quiz_questions AS T WHERE aq_id = Q.id) as maxgrade')
                ->where('Q.l_id', '=', $l_id)
                ->groupBy('Q.id','Q.l_id','Q.title','Q.text','Q.created_at','Q.updated_at','Q.tries')
                ->orderBy('Q.created_at', 'desc')
                ->paginate(15);

        }

        return view('quiz_activities',['title'=>$title,'l_id'=>$l_id,'name'=>$name,'act_quiz'=>$data]);
    }

    // Δημιουργία/Ενημέρωση των δραστηριοτήτων Quiz
    public function create_update(Request $request)
    {
        $l_id=$request->input('l_id');
        $as_id=$request->input('act_id');
        $title=$request->input('title');
        $text=$request->input('text');
        $tries=$request->input('tries');

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
            DB::transaction(function () use ($l_id,$title,$text,$startdate,$enddate,$tries,$as_id) {
                DB::insert('insert into activity_quiz (l_id,title,text,created_at,updated_at,tries) values (?,?,?,?,?,?)', [$l_id, $title, $text, $startdate, $enddate, $tries]);
            });
            return redirect()->back()->with('message','Η προσθήκη των δεδομένων έγινε επιτυχώς!');
        }
        // αν είναι για τη ενημέρωση δραστηριότητας slot
        if($request->input('action')=='update'){
            DB::transaction(function () use ($l_id,$title,$text,$startdate,$enddate,$tries,$as_id) {
                DB::update('update activity_quiz set l_id=?,title=?,text=?,created_at=?,updated_at=?,tries=? where id=?', [$l_id, $title, $text, $startdate, $enddate, $tries, $as_id]);
            });
            return redirect()->back()->with('message','Η ανανέωση πληροφοριών έγινε επιτυχώς!');
        }

    }

    //Διαγραφή Δραστηριότητας Quiz
    public function destroy(Request $request){
        $id=$request->input('q_id');
        DB::transaction(function () use ($id) {
            DB::delete('delete from activity_quiz where id=?', [$id]);
        });
        return redirect()->back()->with('message','Η διαγραφή της δραστηριότητας έγινε επιτυχώς!');
    }


   // Εμφάνιση μίας δραστηριότητας Quiz
    public function showTheQuiz($l_id, $title, $name, $act_id, Request $request){
        $am = $request->input('am');
        $role = $request->input('role');
        $choises=[];
        $activity=DB::table('activity_quiz as A')->select('A.*')
            ->selectRaw('(SELECT SUM(maxgrade) FROM quiz_questions AS T WHERE T.aq_id = A.id) as maxgrade')
            ->where('A.id', '=', $act_id)->get();
        $allowtosee=0;
        $t_id=0;

        // Εμφάνιση όλων των ερωτήσεων και των πιθανών απαντήσεν του Quiz
        $data = DB::table('quiz_questions as Q')
            ->select('Q.id as q_id','Q.aq_id','Q.text as question', 'Q.maxgrade', 'Q.type','A.text as answer','A.grade','A.id as a_id')
            ->leftJoin('quiz_answers as A', 'A.qq_id', '=', 'Q.id')
            ->where('Q.aq_id', '=', $act_id)
            ->orderBy('Q.id')
            ->orderBy('A.id')
            ->get();
        // Αν ο χρήστης δεν είνα μαθητής τότε επέτρεψέ του να δεί τα πάντα
        if($role!=='Μαθητής'){
            $allowtosee=1;
        }
        // αν ο χρήστης είναι μαθητής
        else{

            //Αν η δραστηριότητα είναι απενεργή
            $activitystatus=DB::table('activity_quiz')
                ->where('id', '=', $act_id)
                ->where('updated_at', '<', DB::raw('CURRENT_TIMESTAMP'))
                ->first();
            //Αν είναι απενεργή η δραστηριότητα τότε εμφάνισε τα αποτελέσματα του μαθητή στην τελευταία του προσπάθεια
            if($activitystatus){
                $allowtosee=1;
                if($request->input('tryid')){

                    $tryid=intval($request->input('tryid'));
                    $choises=$this->returnChoices($act_id,$tryid);
                    $choises=$choises['choises'];
                    $allthetries=DB::table('quiz_tries')->select('id')->where('am','=',$am)->where('aq_id','=',$act_id)->orderBy('id','desc')->get();
                   return view('allthequizquestions', ['title' => $title, 'l_id' => $l_id, 'name' => $name, 'activity' => $activity, 'questions' => $data, 'choises'=>$choises,'allowtosee'=>$allowtosee,'t_id'=>$tryid,'allthetries'=>$allthetries]);
                }

                $lastTrysId= DB::table('quiz_tries')->select('id')->where('am','=',$am)->where('aq_id','=',$act_id)->latest('id')->first();

                if($lastTrysId){
                $choises=$this->returnChoices($act_id,$lastTrysId->id);
                $choises=$choises['choises'];
                $allthetries=DB::table('quiz_tries')->select('id')->where('am','=',$am)->where('aq_id','=',$act_id)->orderBy('id','desc')->get();
                return view('allthequizquestions', ['title' => $title, 'l_id' => $l_id, 'name' => $name, 'activity' => $activity, 'questions' => $data, 'choises'=>$choises,'allowtosee'=>$allowtosee,'t_id'=>$lastTrysId->id,'allthetries'=>$allthetries]);
                }
                else{
                    return redirect()->back()->with('warning','Η πρόσβαση δεν είναι δυνατή! Το Quiz έχει λήξει και δεν υπάρχουν κατηχωρημένες προσπάθειες σε αυτή τη δραστηριότητα.');
                }
            }//αν είναι ενεργή η δραστηριότητα
            else{
                //Ελεγχος αν υπάρχει αλλη προσπάθεια του μαθητή στο συγκερκιμένο Quiz που έχει υποβάλει
                $tries=DB::table('quiz_tries')->where('am','=',$am)->where('aq_id','=',$act_id)->where('delivered','=',1)->count();
                //o max αριθμός προσπαθειών του συγκεκριμένου Quiz
                $act=DB::table('activity_quiz')->select('tries','title')->where('id', '=', $act_id)->first();

                //αν ο μαθητής έχει εξαντλήσει την τις προσπάθειές του και η δραστηριότητα είναι ακόμα ενεργή
                if($act->tries==$tries) {
                    return redirect()->back()->with('warning','Η έχεις εξαντλήσει όλες τις προσπάθειες συμμετοχής για το συγκεκριμένο quiz.');
                }else{
                    //αν υπάρχει προσπάθεια που δεν υποβλήθηκε από το μαθητή
                    $unfinishedtry=DB::table('quiz_tries')->select('delivered','id')->where('am','=',$am)->where('aq_id','=',$act_id)->latest('id')->first();
                    //αν υπάρχει προσπάθεια που για κάποιο λογο δεν υποβλήθηκε ρώτησε το χρήστη αν θέλει να συνεχίσει τη τελευταία του προσπάθεια
                    if($unfinishedtry && $unfinishedtry->delivered===0) {
                        if($request->input('continue')==='yes'){
                           // αν ναι τότε εμφάνισε τις επιλογές του μαθητή που έκανε μέχρι εκείνη τη στιγμή
                            $choises = $this->returnChoices($act_id, $unfinishedtry->id);
                            $choises = $choises['choises'];
                            return view('allthequizquestions', ['title' => $title, 'l_id' => $l_id, 'name' => $name, 'activity' => $activity, 'questions' => $data, 'choises' => $choises, 'allowtosee' => $allowtosee, 't_id' => $unfinishedtry->id]);

                        }
                        if($request->input('continue')==='no'){
                            //αν οχι τοτε ξεκίνησε νέα προσπάθεια
                            $TryId=DB::table('quiz_tries')->insertGetId(['aq_id'=>$act_id,'am'=>$am,'delivered'=>0]);
                            return view('allthequizquestions', ['title' => $title, 'l_id' => $l_id, 'name' => $name, 'activity' => $activity, 'questions' => $data, 'choises'=>$choises,'allowtosee'=>$allowtosee,'t_id'=> $TryId ]);
                    } // αν δεν υπάρχει προσπάθεια που δεν υποβλήθηκε τότε
                        else{
                                $n_button='';
                            // αν δεν υπάρχουν άλλες προσπάθειες μή δείξεις την ερώτηση για νέα προσπάθεια
                            if($act && $act->tries === $tries + 1){
                                $n_button='no';
                            }
                            // αν υπάρχουν ακόμα άλλες προσπάθειες τότε δείξε την ερώτηση για νέα προσπάθεια
                            else{
                                $n_button='yes';
                            }
                            return redirect()->back()->with([
                                'question' => 'Υπάρχει στο σύστημα μία ΜΗ ολοκληρωμένη προσπάθεια σας στο συγκέκριμένο κουίζ.<br>'.
                                    'Παρακαλώ επιλέξτε τί από τα παρακάτω επιθυμήτε:<br>'.
                                    '1. Επιλέξτε το κουμπί "Συνέχεια", αν επιθυμήτε να συνεχίσετε τη προσπάθεια σας στο συγκεκριμένο quiz.<br>'.
                                    '2. Επιλέξτε το κουμπί "Νέα προσπάθεια", αν επιθυμήτε να κάνετε μία καινούργια προσπάθεια στο συγκεκριμένο quiz.<br>',
                                'action' => '/showTheQuiz/'.$l_id.'/'.$title.'/'.$name.'/'.$act_id,
                                'c_button'=>'yes',
                                'n_button'=>$n_button,
                                'act_title'=>$act->title,
                                'title'=>$l_id.'-'.$title.'<br>Διδάσκων: '.$name,

                            ]);
                        }

                    }

                    //αν είναι η πρώτη του προσπάθεια ή είναι καινούργια προσπάθεια
                    if( $tries < $act->tries ){
                        if($request->input('continue')==='no'){
                            $TryId=DB::table('quiz_tries')->insertGetId(['aq_id'=>$act_id,'am'=>$am,'delivered'=>0]);
                            return view('allthequizquestions', ['title' => $title, 'l_id' => $l_id, 'name' => $name, 'activity' => $activity, 'questions' => $data, 'choises'=>$choises,'allowtosee'=>$allowtosee,'t_id'=> $TryId ]);
                        }
                        else{
                            return redirect()->back()->with([
                                'question' => 'Παρακαλώ επίλέξτε μια το κουμπί "Νέα προσπάθεια", αν επιθυμήτε να κάνεται μία νέα προσπάθεια στο συγκεκριμένο κουίζ.',
                                'action' => '/showTheQuiz/'.$l_id.'/'.$title.'/'.$name.'/'.$act_id,
                                'c_button'=>'no',
                                'n_button'=>'yes',
                                'act_title'=>$act->title,
                                'title'=>$l_id.' '.$title.'<br>Διδάσκων: '.$name,
                            ]);
                        }
                    }
                }
            }
        }
        return view('allthequizquestions', ['title' => $title, 'l_id' => $l_id, 'name' => $name, 'activity' => $activity, 'questions' => $data, 'choises'=>$choises,'allowtosee'=>$allowtosee,'t_id'=>$t_id ]);
    }

//    //Δείξε την άλλη προσπάθεια του μαθητή
//    public function showAtry($l_id, $title, $name, $act_id,$try_id, Request $request)
//    {
////        return redirect()->back()->with('message',json_encode($act_id));
//
//        $am = $request->input('am');
//        $activity=DB::table('activity_quiz as A')->select('A.*')
//            ->selectRaw('(SELECT SUM(maxgrade) FROM quiz_questions AS T WHERE T.aq_id = A.id) as maxgrade')
//            ->where('A.id', '=', $act_id)->get();
//        // Εμφάνιση όλων των ερωτήσεων και των πιθανών απαντήσεν του Quiz
//        $data = DB::table('quiz_questions as Q')
//            ->select('Q.id as q_id','Q.aq_id','Q.text as question', 'Q.maxgrade', 'Q.type','A.text as answer','A.grade','A.id as a_id')
//            ->leftJoin('quiz_answers as A', 'A.qq_id', '=', 'Q.id')
//            ->where('Q.aq_id', '=', $act_id)
//            ->orderBy('Q.id')
//            ->orderBy('A.id')
//            ->get();
//        $allowtosee=1;
//        $choises=[];
//        $choises=$this->returnChoices($act_id,$try_id);
//        $choises=$choises['choises'];
//        $allthetries=DB::table('quiz_tries')->select('id')->where('am','=',$am)->where('aq_id','=',$act_id)->orderBy('id','desc')->get();
//        return redirect()->back()->with('message',json_encode($choises));
//    }

//επιστροφή επιλογών όλων των απαντήσεων ενός χρήστη
    public function returnChoices($act_id,$IdLastTry)
    {
        $choises1=DB::table('quiz_questions as Q')
            ->select('A.grade as grade')
            ->selectRaw('CONCAT(C.qq_id,",",C.text) as choise, Q.type, C.qq_id as q_id')
            ->where('Q.aq_id','=',$act_id)
            ->where(function ($query) {
                $query->where('Q.type', '=', 'Ναι/Όχι')
                    ->orWhere('Q.type', '=', 'Μίας Επιλογής')
                    ->orWhere('Q.type', '=', 'Πολλαπλής Επιλογής');
            })
            ->leftJoin('quiz_choices as C',function($join)use ($IdLastTry){
                $join->on('C.qq_id','=','Q.id')
                    ->where('C.t_id','=',$IdLastTry);
            })
            ->leftJoin('quiz_answers as A', function($join){
                $join->on('C.qq_id','=','A.qq_id')
                    ->on('C.text','=','A.id');
            });

        $choises2=DB::table('quiz_questions as Q')
            ->select('C.grade as grade')
            ->selectRaw('C.text as choise, Q.type, C.qq_id as q_id')
            ->where('Q.aq_id','=',$act_id)
            ->where('Q.type', '=', 'Ελεύθερου Κειμένου')
            ->leftJoin('quiz_choices as C',function($join)use ($IdLastTry){
                $join->on('C.qq_id','=','Q.id')
                    ->where('C.t_id','=',$IdLastTry);
            });


        $choises3=DB::table('quiz_questions as Q')
            ->select(DB::raw('CASE WHEN A.grade > 0 THEN A.grade ELSE (SELECT grade FROM quiz_answers AS b WHERE b.qq_id = Q.id AND b.text = "=") END AS grade'))
            ->selectRaw('C.text as choise, Q.type, C.qq_id as q_id')
            ->where('Q.aq_id','=',$act_id)
            ->where('Q.type', '=', 'Αντιστοίχιση')
            ->leftJoin('quiz_choices as C',function($join)use ($IdLastTry){
                $join->on('C.qq_id','=','Q.id')
                    ->where('C.t_id','=',$IdLastTry);
            })
            ->leftJoin('quiz_answers as A', function($join){
                $join->on('C.qq_id','=','A.qq_id')
                    ->on('C.text','=','A.text');
            });


        $choises = $choises1->union($choises2)->union($choises3)->get();

        return ['choises'=>$choises];
    }

    // Δημιουργία / Ενημέρωση ερώτήσεων για την δραστηριότητα Quiz
    public function create_update_questions(Request $request)
    {
        $act_id=$request->input('act_id');
        $text=$request->input('text');
        $type=$request->input('type');

        $grade=0;
        if($type==='Ελεύθερου Κειμένου'){
            $grade=$request->input('maxgrade');
        }


        if($text===null) {
            $text='';
        }

        if($request->input('action')==='create'){

            DB::table('quiz_questions')->insert(['aq_id'=>$act_id , 'text'=>$text ,'type'=>$type ,'maxgrade'=>$grade]);
            return redirect()->back()->with('message','Η δημιουργία ερώτησης έγινε επιτυχώς!');

        }
        if($request->input('action')==='update'){
            $q_id=$request->input('q_id');

            $check=DB::table('quiz_tries')->where('aq_id','=',$act_id)->first();
            if($check)
            {
                return redirect()->back()->with('warning','Η διαγραφή/ανανέωση της ερώτησης δεν είναι εφικτή καθώς έχει ξεκινήσει η διαδικασία των κουίζ.');
            }
            // Update the record with a locking mechanism within a transaction

            DB::transaction(function () use ($act_id, $text, $type, $q_id, $grade) {
                // Apply lock for update

                DB::table('quiz_questions')
                    ->where('id', $q_id)
                    ->lockForUpdate()
                    ->update([
                        'aq_id' => $act_id,
                        'text' => $text,
                        'type' => $type,
                        'maxgrade'=>$grade
                    ]);
            });
            return redirect()->back()->with('message','Η ανανέωση του της ερώτησης έγινε επιτυχώς');
        }

    }


    //Διαγραφή ερώτησης της δραστηριότητας Quiz
    public function deleteQuestion(Request $request)
    {
        try {
            $q_id=$request->input('q_id');
            $check=DB::table('quiz_choices')->where('qq_id','=',$q_id)->first();
            // Έλεγχος αν έχει ξεκινήσει η διαδικασία των Quiz
            if($check) {
                return redirect()->back()->with('warning','Η διαγραφή/ανανέωση της ερώτησης δεν είναι εφικτή καθώς έχει ξεκινήσει η διαδικασία της ψηφοφορίας');
            }
            //Έλεγχος αν υπάρχει η εγγραφή
            $recordExists = DB::table('quiz_questions')->where('id', $q_id)->exists();
            if (!$recordExists) {
                return redirect()->back()->with('warning', 'Η ερώτηση που προσπαθήσατε να διαγράψετε δεν υπάρχει.');
            }
            DB::transaction(function () use ($q_id) {
                DB::delete('delete from quiz_questions where id = ?', [$q_id]);
            });
            return redirect()->back()->with('message','Η διαγραφή της ερώτησης έγινε επιτυχώς');
        } catch (\Exception $e) {
            // Handle exceptions that might occur within the transaction
            return redirect()->back()->with('warning', 'Προέκυψε σφάλμα κατά τη διαγραφή της ερώτησης.');
        }

    }

    // Διαγραφή μιας πιθανής απάντησης
    public function DeleteAnswer(Request $request)
    {
        try{
            $a_id=$request->input('a_id');
            $check= DB::table('quiz_choices as QC')
                ->where('text','=',str($a_id))->first();
            // Έλεγχος αν έχει ξεκινήσει η διαδικασία των quiz
            if($check) {
                return redirect()->back()->with('warning','Η διαγραφή απάντησης δεν είναι εφικτή καθώς έχει ξεκινήσει η διαδικασία της ψηφοφορίας');
            }
            // Έλεγχος αν υπάρχει η εγγραφή
            $recordExists = DB::table('quiz_answers')->where('id', $a_id)->exists();
            if (!$recordExists) {
                return redirect()->back()->with('warning', 'Η απάντηση που προσπαθήσατε να διαγράψετε δεν υπάρχει.');
            }


            $q_id= DB::table('quiz_answers')->select('qq_id')->where('id','=',$a_id)->first();

            //ανανέωση πίνακα των ερωτήσεων με τον καινούργιο Sum
            DB::transaction(function () use ($a_id) {
                DB::delete('delete from quiz_answers where id = ?', [$a_id]);
            });

            $maxgrade = DB::table('quiz_answers')
                ->where('qq_id','=',$q_id->qq_id)
                ->where('grade','>=',0)
                ->sum('grade');

            DB::transaction(function () use ($maxgrade,$q_id) {
                DB::table('quiz_questions')->where('id', '=', $q_id->qq_id)->update(['maxgrade' => $maxgrade]);
            });


            return redirect()->back()->with('message','Η διαγραφή της απάντησης έγινε επιτυχώς');
        }catch (\Exception $e) {
            // Handle exceptions that might occur within the transaction
            return redirect()->back()->with('warning', 'Προέκυψε σφάλμα κατά τη διαγραφή της απάντησης.');
        }

    }

    //Δημιουργία πιθανών απαντήσεων και εισαγωγή βαθμολογίων
    public function addAnswers(Request $request)
    {
        $request->validate([
            'q_id' => 'required|numeric',
            'falsegrade' => 'sometimes|nullable',
            'text' => 'sometimes|array|nullable', // 'ft' is optional and should be an array if it exists
            'grade' => 'sometimes|array|nullable',  // 'v' is optional and should be an array if it exists
            'l1' => 'sometimes|array|nullable', // 'l1' is optional and should be an array if it exists
            'l2' => 'sometimes|array|nullable', // 'l2' is optional and should be an array if it exists
        ]);
        try{


            $q_id=$request->input('q_id');
            $text=[];

            if($request->has('text')){
                $text=$request->input('text',[]);
            }

            $grade=$request->input('grade',[]);


            if($request->has('l1') && $request->has('l2'))
            {
                $l1=$request->input('l1',[]);
                $l2=$request->input('l2',[]);

                for ($i = 0; $i < count($l1); $i++) {
                    if($l1[$i]!==null && $l2[$i]!==null)
                    {
                        $answer=$l1[$i].'='.$l2[$i];
                        $text[]=$answer;
                    }
                    else{
                        array_splice($grade, $i,1 );
                    }

                }
            }
            if($request->has('falsegrade')){
                $text[]='=';
                $falsegrade=$request->input('falsegrade');
                $grade[]=$falsegrade;
            }

            // Check if the arrays have the same number of elements
            if (count($grade) === count($text)) {
                // Iterate over both arrays simultaneously using numeric indexing
                $count = count($grade);
                for ($i = 0; $i < $count; $i++) {
                    DB::table('quiz_answers')->insert([ 'qq_id'=>$q_id, 'text'=>$text[$i], 'grade'=>$grade[$i],]);
                }
            } else {
                return redirect()->back()->with('warning', 'Προέκυψε σφάλμα κατά τη προσθήκη των απαντήσεων.');
            }
            $maxgrade=DB::table('quiz_answers')->where('qq_id','=',$q_id)->where('grade','>=',0)->sum('grade');
            DB::table('quiz_questions')->where('id','=',$q_id)->update(['maxgrade'=>$maxgrade,]);

            return redirect()->back()->with('message','Η προσθήκη απαντήσεων έγινε επιτυχώς!');
        }catch (\Exception $e) {
            // Handle exceptions that might occur within the transaction
            return redirect()->back()->with('warning', 'Προέκυψε σφάλμα κατά τη προσθήκη των απαντήσεων.');
        }
    }


// Αποθήκευση/υποβολή απαντήσεων του χρήστη
    public function answerOfTheQuiz(Request $request){
        // Validate inputs
        $request->validate([
            't_id' => 'required|numeric',
            'ft' => 'sometimes|array|nullable', // 'ft' is optional and should be an array if it exists
            'v' => 'sometimes|array|nullable',  // 'v' is optional and should be an array if it exists
            'l1' => 'sometimes|array|nullable', // 'l1' is optional and should be an array if it exists
            'l2' => 'sometimes|array|nullable', // 'l2' is optional and should be an array if it exists
        ]);


        // Get the user's ID and votes from the request
        $t_id = $request->input('t_id');
        $free_text = $request->input('ft', []);

        $multiple_choices = $request->input('v', []);
        $l1 = $request->input('l1', []);
        $l2 = $request->input('l2', []);
        $uniqvalues=[];

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Delete existing quiz choices for the given t_id
            DB::delete('DELETE FROM quiz_choices WHERE t_id = ?', [$t_id]);

            if(count($l1)>0 && count($l1)>0) {
                for ($i = 0; $i < count($l1); $i++) {
                    if ($l1[$i] !== null && $l2[$i] !== null) {
                        $m1 = explode(',', $l1[$i]);
                        $m2 = explode(',', $l2[$i]);
                        $answer = $m1[1] . '=' . $m2[1];

                        $element=$m1[0].'=>'.$answer;
                        if(!in_array($element,$uniqvalues))
                        {
                            $uniqvalues[] = $element;
                            DB::table('quiz_choices')->insert([
                                'text' => $answer,
                                't_id' => $t_id,
                                'qq_id' => intval($m1[0]),
                            ]);
                        }

                    }

                }
            }

            foreach ($free_text as $key => $value) {
                if($value==null){
                    break;
                }
                DB::table('quiz_choices')->insert([
                    'text' => $value,
                    't_id' => $t_id,
                    'qq_id' => intval($key),
                ]);
            }

            // Insert new quiz choices
            foreach ($multiple_choices as $m) {
                $m = explode(',', $m);
                DB::table('quiz_choices')->insert([
                    'text' => intval($m[1]),
                    't_id' => $t_id,
                    'qq_id' => intval($m[0]),
                ]);
            }

            // Update the quiz try as delivered
            DB::table('quiz_tries')->where('id', $t_id)->update(['delivered' => 1]);

            // Commit the transaction if everything was successful
            DB::commit();

            // Redirect with a success message
            return redirect($request->input('previousPageUrl'))->with('message','Η υποβολή του quiz έγινε επιτυχώς.');
        } catch (\Exception $e) {
            // An error occurred, so we roll back the transaction
            DB::rollBack();

            // Handle the error and provide a suitable response
            return redirect()->back()->with('warning', 'Προέκυψε σφάλμα κατά την υποβολή του quiz.');
        }
    }


    //Αυτόματη αποθήκευση
    public function AutoSaveTest(Request $request)
    {

        $request->validate([
            't_id' => 'required|numeric',
            'textValues' => 'sometimes|array|nullable', // 'ft' is optional and should be an array if it exists
            'checkedValues' => 'sometimes|array|nullable',  // 'v' is optional and should be an array if it exists
            'l1Values' => 'sometimes|array|nullable', // 'l1' is optional and should be an array if it exists
            'l2Values' => 'sometimes|array|nullable', // 'l2' is optional and should be an array if it exists
        ]);

        $t_id = $request->input('t_id');
        $multiple_choices = $request->input('checkedValues',[]);
        $free_text = $request->input('textValues',[]);
        $l1 = $request->input('l1Values',[]);
        $l2 = $request->input('l2Values',[]);

        $uniqvalues=[];

        // Start a database transaction
        DB::beginTransaction();

        try {

            DB::table('quiz_choices')->where('t_id', $t_id)->delete();

            if(count($l1)>0 && count($l1)>0) {
                for ($i = 0; $i < count($l1); $i++) {
                    if ($l1[$i] !== null && $l2[$i] !== null) {
                        $m1 = explode(',', $l1[$i]);
                        $m2 = explode(',', $l2[$i]);
                        $answer = $m1[1] . '=' . $m2[1];
                        $element=$m1[0].'=>'.$answer;
                        if(!in_array($element,$uniqvalues))
                        {
                            $uniqvalues[] = $element;
                            DB::table('quiz_choices')->insert([
                                'text' => $answer,
                                't_id' => $t_id,
                                'qq_id' => intval($m1[0]),
                            ]);
                        }

                    }

                }
            }

            foreach ($free_text as $ft) {
                $ft = explode(',', $ft, 2);

                if($ft[1]==null){
                    break;
                }
                DB::table('quiz_choices')->insert([
                    'text' => $ft[1],
                    't_id' => $t_id,
                    'qq_id' => intval($ft[0]),
                ]);
            }

            // Insert new quiz choices
            foreach ($multiple_choices as $m) {
                $m = explode(',', $m);
                DB::table('quiz_choices')->insert([
                    'text' => intval($m[1]),
                    't_id' => $t_id,
                    'qq_id' => intval($m[0]),
                ]);
            }



//            // Commit the transaction if everything was successful
            DB::commit();

        return response()->json(['message' => 'success']);
        } catch (\Exception $e) {
            // An error occurred, so we roll back the transaction
            DB::rollBack();

            // Handle the error and provide a suitable response
            return redirect()->back()->with('warning', 'Προέκυψε σφάλμα κατά την υποβολή του quiz.');
        }

    }



}
