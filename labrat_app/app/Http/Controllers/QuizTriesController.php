<?php

namespace App\Http\Controllers;

use App\Exports\QuizExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class QuizTriesController extends Controller
{

// Επιστροφή των απατνήσεων του μαθητή
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

    //επιστροφή ώλλων των μαθητών που συμμετείχαν στη διαδικασία των Quiz
    public function QuizParticipation($act_id,$l_id,$title,$name){

            $choises=[];

            $maxnum = DB::table('quiz_questions')
            ->where('aq_id', $act_id)
            ->sum('maxgrade');

            $activity=DB::table('activity_quiz')->where('id', '=', $act_id)->get();

            $data = DB::table('quiz_questions as Q')
            ->select('Q.id as q_id','Q.aq_id','Q.text as question', 'Q.maxgrade', 'Q.type','A.text as answer','A.grade','A.id as a_id')
            ->leftJoin('quiz_answers as A', 'A.qq_id', '=', 'Q.id')
            ->where('Q.aq_id', '=', $act_id)
            ->orderBy('Q.id')
            ->orderBy('A.id')
            ->get();
            $tries=DB::table('quiz_tries AS QT')->where('QT.aq_id','=', $act_id)->orderBy('am')->orderBy('id')->get();

            $quizpart=$tries->count('am');
            $lessonpart='';
            $delpart=$tries->where('delivered','=',1)->count('delivered');

        return view('quiz_participation', ['title' => $title, 'l_id' => $l_id, 'name' => $name,'data'=>$tries,'activity'=>$activity,'maxgrade'=>$maxnum,'quizpart'=>$quizpart,'delpart'=> $delpart,'questions'=>$data,'choises'=>$choises]);

    }

    // Επιστροφή όλων των απαντήσεων ενός μαθητή
    public function studentQuiz(Request $request){
      $act_id=$request->input('act_id');
      $try_id=$request->input('try_id');

        $choises = $this->returnChoices($act_id, $try_id);
        $choises = $choises['choises'];

        return response()->json(['choises'=>$choises]);

    }

    //Αποθήκευση/ Επισημοποιήση βαθμολογίας του μαθητή
    public function gradeQuiz(Request $request){
            $try_id=$request->input('t_id');
            $grade=$request->input('totalgrade');
            $scores=$request->input('score',[]);

        foreach ($scores as $key => $value) {
            DB::table('quiz_choices')->where('t_id','=',$try_id)->where('qq_id','=',$key)->update([
                'grade' => $value,

            ]);
        }


            DB::table('quiz_tries')->where('id','=',$try_id)->update(['finalscore'=>$grade]);
        return redirect()->back()->with('message', 'Η Βαθμολογία υποβλήθηκε επιτυχώς'.json_encode($scores));
    }


    // εξαγωγή σε αρχείο τα αποτελέσματα των Quiz
    public function exportResults(Request $request){
        $act_id=$request->input('act_id');

        $filename=$request->input('filename');
        $filename=$filename.'.xlsx';
        return Excel::download(new QuizExport($act_id), $filename);
        return redirect()->back()->with('message','Τα δεδομένα προσθέθηκαν επιτυχώς!');
    }

    // Αναζήτηση συμμετοχών με βάση το am του μαθητή
    public function searchQuizParticipation($act_id,$l_id,$title,$name,Request $request){
        $key=$request->input('key');
        $conditions=[['QT.aq_id', '=', $act_id]];
        if($key!=NULL)
        {
            $p=['QT.am','=',$key];
            array_push($conditions,$p);
        }
        $choises=[];

        $maxnum = DB::table('quiz_questions')
            ->where('aq_id', $act_id)
            ->sum('maxgrade');

        $activity=DB::table('activity_quiz')->where('id', '=', $act_id)->get();

        $data = DB::table('quiz_questions as Q')
            ->select('Q.id as q_id','Q.aq_id','Q.text as question', 'Q.maxgrade', 'Q.type','A.text as answer','A.grade','A.id as a_id')
            ->leftJoin('quiz_answers as A', 'A.qq_id', '=', 'Q.id')
            ->where('Q.aq_id', '=', $act_id)
            ->orderBy('Q.id')
            ->orderBy('A.id')
            ->get();
        $tries=DB::table('quiz_tries AS QT')->where($conditions)->orderBy('am')->orderBy('id')->get();

        $quizpart=$tries->count('am');
        $lessonpart='';
        $delpart=$tries->where('delivered','=',1)->count('delivered');

        return view('quiz_participation', ['title' => $title, 'l_id' => $l_id, 'name' => $name,'data'=>$tries,'activity'=>$activity,'maxgrade'=>$maxnum,'quizpart'=>$quizpart,'delpart'=> $delpart,'questions'=>$data,'choises'=>$choises]);

    }



}
