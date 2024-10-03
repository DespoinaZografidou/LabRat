<?php

namespace App\Http\Controllers;

use App\Exports\VotingExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ActivityVotingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

        public function index($l_id,$title,$name)
    {
        $data=DB::table('activity_voting AS V')->
        select('V.*',)->
        where('V.l_id','=',$l_id)->
        orderby('V.created_at', 'desc')->paginate(15);

        return view('voting_activities',['title'=>$title,'l_id'=>$l_id,'name'=>$name,'act_voting'=>$data]);
    }


    public function create_update(Request $request)
    {
        $l_id=$request->input('l_id');
        $as_id=$request->input('act_id');
        $title=$request->input('title');
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
            DB::insert('insert into activity_voting (l_id,title,text,created_at,updated_at) values (?,?,?,?,?)',[$l_id,$title,$text,$startdate,$enddate]);
            return redirect()->back()->with('message','Η προσθήκη των δεδομένων έγινε επιτυχώς!');
        }
        // αν είναι για τη ενημέρωση δραστηριότητας slot
        if($request->input('action')=='update'){
            DB::update('update activity_voting set l_id=?,title=?,text=?,created_at=?,updated_at=? where id=?',[$l_id,$title,$text,$startdate,$enddate,$as_id]);
            return redirect()->back()->with('message','Η ανανέωση πληροφοριών έγινε επιτυχώς!');
        }

    }

    public function destroy(Request $request){
        $id=$request->input('vt_id');
        DB::delete('delete from activity_voting where id=?',[$id]);
        return redirect()->back()->with('message','Η διαγραφή της δραστηριότητας έγινε επιτυχώς!');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ShowtheVoting($l_id, $title, $name, $act_id, Request $request)
    {
        $am = $request->input('am');
        $role = $request->input('role');

        $activity = DB::table('activity_voting')->where('id', '=', $act_id)->get();

        $data = DB::table('questions as Q')
            ->select('Q.id as q_id', 'Q.av_id', 'Q.text as question', 'Q.type', 'A.text as answer', 'A.id as a_id')
            ->selectRaw('(SELECT COUNT(V.a_id) FROM voting AS V WHERE V.a_id = A.id GROUP BY V.a_id) AS votes ')
            ->selectRaw('(SELECT COUNT(V.q_id) FROM voting AS V WHERE V.q_id = Q.id GROUP BY V.q_id) AS allthevotes')
            ->selectRaw('(SELECT COUNT(DISTINCT V.am) FROM voting AS V WHERE V.q_id = Q.id ) AS voters ')
            ->leftJoin('answers as A', 'A.q_id', '=', 'Q.id')
            ->where('Q.av_id', $act_id)
            ->orderBy('Q.id')
            ->orderBy('A.id')
            ->get();

        $allowtosee=1;
        $choises=[];
        $allowtovote=1;

        //έλεγξε αν ο χρήστης έχει ψηφήσει
        $checkuser=DB::table('voting AS V')
            ->where('am','=',$am)
            ->leftJoin('questions as Q','V.q_id','=','Q.id')
            ->where('Q.av_id','=',$act_id)
            ->first();
        //έλεγξε αν η δραστηριότητα έχει λήξει
        $checkactivity=DB::table('activity_voting')
            ->where('id', '=', $act_id)
            ->where('updated_at', '<', DB::raw('CURRENT_TIMESTAMP'))
            ->where('updated_at', '<', DB::raw('CURRENT_TIMESTAMP'))
            ->first();

        if($checkuser || $checkactivity){
            $allowtovote=0;
            $choises=DB::table('questions as Q')
                ->selectRaw('CONCAT(V.q_id,",",V.a_id) as choise,Q.type,V.q_id ')
                ->where('Q.av_id','=',$act_id)
                ->leftJoin('voting as V',function($join)use ($am){
                    $join->on('V.q_id','=','Q.id')
                        ->where('V.am','=',$am);
                })->get();
        }

        if($role==='Μαθητής'){
            $numofvoters=DB::table('questions as Q')
                ->leftJoin('answers as A', 'A.q_id', '=', 'Q.id')
                ->leftJoin('voting AS V', 'V.q_id', '=', 'Q.id')
                ->where('Q.av_id', '=', $act_id)
                ->distinct('V.am')
                ->count();

            $nummofparticipants=DB::table('participations')->where('l_id','=',$l_id)->count();

            if($numofvoters==$nummofparticipants || $checkactivity){
                $allowtosee=1;
            }else{
                $allowtosee=0;
            }
        }
        return view('allthequestions', ['title' => $title, 'l_id' => $l_id, 'name' => $name, 'activity' => $activity, 'questions' => $data, 'allowtovote'=>$allowtovote, 'choises'=>$choises,'allowtosee'=>$allowtosee, ]);

    }

    public function create_update_questions(Request $request)
    {
        $act_id=$request->input('act_id');
        $text=$request->input('text');
        $type=$request->input('type');


        if($text===null) { $text='';}

        if($request->input('action')==='create'){

            DB::table('questions')->insert(['av_id'=>$act_id , 'text'=>$text ,'type'=>$type]);
            return redirect()->back()->with('message','Η δημιουργία ερώτησης έγινε επιτυχώς!');

        }
        if($request->input('action')==='update'){
            $q_id=$request->input('q_id');

            $check=DB::table('voting as V')->where('q_id','=',$q_id)->first();
            if($check)
            {
                return redirect()->back()->with('warning','Η διαγραφή/ανανέωση της ερώτησης δεν είναι εφικτή καθώς έχει ξεκινήσει η διαδικασία της ψηφοφορίας');
            }
            // Update the record with a locking mechanism within a transaction

                DB::transaction(function () use ($act_id, $text, $type, $q_id) {
                    // Apply lock for update

                    DB::table('questions')
                        ->where('id', $q_id)
                        ->lockForUpdate()
                        ->update([
                            'av_id' => $act_id,
                            'text' => $text,
                            'type' => $type,
                        ]);
            });
            return redirect()->back()->with('message','Η ανανέωση του της ερώτησης έγινε επιτυχώς');
        }

    }



 public function deleteQuestion(Request $request)
 {
     try {
        $q_id=$request->input('q_id');
        $check=DB::table('voting as V')->where('q_id','=',$q_id)->first();
        if($check)
        {
             return redirect()->back()->with('warning','Η διαγραφή/ανανέωση της ερώτησης δεν είναι εφικτή καθώς έχει ξεκινήσει η διαδικασία της ψηφοφορίας');
        }
        $recordExists = DB::table('questions')->where('id', $q_id)->exists();
        if (!$recordExists) {
            return redirect()->back()->with('warning', 'Η ερώτηση που προσπαθήσατε να διαγράψετε δεν υπάρχει.');
        }
        DB::transaction(function () use ($q_id) {
            DB::delete('delete from questions where id = ?', [$q_id]);
        });
         return redirect()->back()->with('message','Η διαγραφή της ερώτησης έγινε επιτυχώς');
    } catch (\Exception $e) {
    // Handle exceptions that might occur within the transaction
    return redirect()->back()->with('warning', 'Προέκυψε σφάλμα κατά τη διαγραφή της ερώτησης.');
}

 }

 public function DeleteAnswer(Request $request)
 {
     try{
         $a_id=$request->input('a_id');
         $check=DB::table('voting as V')->where('a_id','=',$a_id)->first();
         if($check)
         {
             return redirect()->back()->with('warning','Η διαγραφή απάντησης δεν είναι εφικτή καθώς έχει ξεκινήσει η διαδικασία της ψηφοφορίας');
         }
         $recordExists = DB::table('answers')->where('id', $a_id)->exists();
         if (!$recordExists) {
             return redirect()->back()->with('warning', 'Η απάντηση που προσπαθήσατε να διαγράψετε δεν υπάρχει.');
         }
         DB::transaction(function () use ($a_id) {
             DB::delete('delete from answers where id = ?', [$a_id]);
         });
         return redirect()->back()->with('message','Η διαγραφή της απάντησης έγινε επιτυχώς');
     }catch (\Exception $e) {
         // Handle exceptions that might occur within the transaction
         return redirect()->back()->with('warning', 'Προέκυψε σφάλμα κατά τη διαγραφή της απάντησης.');
     }

 }

 public function addAnswers(Request $request)
 {
     try{
        $q_id=$request->input('q_id');
        $text=$request->input('text',[]);

        foreach($text as $t){
            DB::table('answers')->insert([ 'q_id'=>$q_id, 'text'=>$t ]);
        }
         return redirect()->back()->with('message','Η προσθήκη των απαντήσεων έγινε επιτυχώς');
     }catch (\Exception $e) {
         // Handle exceptions that might occur within the transaction
         return redirect()->back()->with('warning', 'Προέκυψε σφάλμα κατά τη προσθήκη των απαντήσεων.');
     }

 }




    public function vote(Request $request)
    {
        // Get the user's ID and votes from the request
        $am = $request->input('am');
        $votes = $request->input('v', []);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Process each vote
            foreach ($votes as $v) {
                $v = explode(',', $v);
                DB::table('voting')->insert([
                    'a_id' => intval($v[1]),
                    'am' => $am,
                    'q_id' => intval($v[0]),
                ]);
            }

            // Commit the transaction if everything was successful
            DB::commit();

            // Redirect with a success message
            return redirect()->back()->with('message', 'Η προσθήκη ψήφου έγινε επιτυχώς');
        } catch (\Exception $e) {
            // An error occurred, so we roll back the transaction
            DB::rollBack();

            // Handle the error and provide a suitable response
            return redirect()->back()->with('warning', 'Προέκυψε σφάλμα κατά την προσθήκη των ψήφων');
        }
    }


    public function exportVotes(Request $request){

        $act_id=$request->input('act_id');
        $filename=$request->input('filename');
        $filename=$filename.'.xlsx';
        return Excel::download(new VotingExport($act_id), $filename);
        return redirect()->back()->with('message','Τα δεδομένα προσθέθηκαν επιτυχώς!');
    }

}
