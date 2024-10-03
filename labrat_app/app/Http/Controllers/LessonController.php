<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Lesson;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;
use App\Models\Participation;



class LessonController extends Controller
{
//    show all the lessons for the admin
   public function showLessons($type)
   {
       $data=DB::table('lessons')->where('lessons.type',"=",$type)->
       join('users','users.id','=','lessons.t_id')->
       select('lessons.*','users.name',)->orderby('semester','asc')->paginate(10);

        //Returns all the professors
        //That is needed for the page lessons.blade.php and more specific
       // we need it when for the pop we want to edit or to add a new lesson
       $professors=DB::table('users')->where('role','=','Καθηγητής')->orderby('name')->get();

       return view('lessons',['lessons'=>$data,'type'=>$type,'professors'=>$professors]);

   }
//show all the lessons for the professors
   public function showLessonProfessor($type,$t_id){
       $conditions=[['lessons.type','=',$type],['lessons.t_id','=',$t_id]];
       $data=DB::table('lessons')->
       where($conditions)->
       join('users','users.id','=','lessons.t_id')->
       select('lessons.*','users.name',)->
       orderby('semester','asc')->
       paginate(10);
       return view('lessons',['lessons'=>$data,'type'=>$type]);

   }


//show all the lessons where they agree with the filters
   public function filterLessons($type,Request $request)
   {
       $t_id=$request->input('professor');
       $area=$request->input('area');
       $semester=$request->input('semester');

       $conditions=[['lessons.type','=',$type]];

       if($t_id!==null)
       {
           $t_id=(int)$t_id;
           $p=['lessons.t_id','=',$t_id];
           array_push($conditions,$p);
       }
       if($area!==null)
       {
           $area=(int)$area;
           $p=['l_area','=',$area];
           array_push($conditions,$p);
       }
       if($semester!==null)
       {
           $p=['semester','=',$semester];
           array_push($conditions,$p);
       }
       $data=DB::table('lessons')->where($conditions)
           ->join('users','users.id','=','lessons.t_id')
           ->select('lessons.*','users.name')
           ->orderby('semester','asc')
           ->paginate(10);
       $professors=DB::table('users')->where('role','=','Καθηγητής')->orderby('name')->get();

       return view('lessons',['lessons'=>$data,'type'=>$type,'professors'=>$professors]);
   }

   //search and show the lessons where the title is like the key word
   public function searchLesson($type,Request $request)
   {
       $key=$request->input('key');
       $conditions=[['lessons.type','=',$type]];
       $role='';
       if($key!='')
       {
           $p=['title','LIKE','%'.$key.'%'];
           array_push($conditions,$p);
       }

       if($request->has('t_id'))
       {
           $t_id=$request->input('t_id');
           $p=['t_id','LIKE','%'.$t_id.'%'];
           array_push($conditions,$p);
           $role='Professor';
       }
       $data=DB::table('lessons')->where($conditions)->join('users','users.id','=','lessons.t_id')->select('lessons.*','users.name',)->orderby('semester','asc')->paginate(10);
       if($role=='Professor')
       {
           return view('lessons',['lessons'=>$data,'type'=>$type,'key'=>$key]);
       }
       //Returns all the professors
       //That is needed for the page lessons.blade.php and more specific
       // we need it when for the pop we want to edit or to add a new lesson
       $professors=DB::table('users')->where('role','=','Καθηγητής')->orderby('name')->get();

       return view('lessons',['lessons'=>$data,'type'=>$type,'key'=>$key,'professors'=>$professors]);
   }



    //delete the lesson and all that are relevant (the reason is the cascade)
    public function destroy(Request $request)
    {
        $l_id=$request->input('les_id');
        DB::delete('delete from lessons where l_id=?',[$l_id]);
        return redirect()->back()->with('message','Η διαγραφή του μαθήματος έγινε επιτυχώς!');
    }


    //update or add a lesson
    public function updateAddLessons(Request $request)
    {

        $l_id=$request->input('l_id');
        $title=$request->input('title');
        $t_id=$request->input('professor');
        $area=$request->input('area');
        $type=$request->input('type');
        $semester=$request->input('semester');

        $description=$request->input('description');
        $description=str_replace(['<br>','<em>','</em>','<span style="text-decoration: underline;">','</span>','<strong>','</strong>','<li>', '</li>'],["\n","☺","☻",'♦','♣',"♥","♠",'• ',''],$description);
        $description=strip_tags($description,['☺','♦','♣',"♥","♠",'☻','• ',"\n"]);


        if($description==null){$description='Περιγραφή...';}
//        if(strlen($description)>255)
//        {
//            return redirect()->back()->with('warning','Η περιγραφή του μαθήματος έχει ξεπεράσει το όριο το 255 χαρακτήρων! Η αποθήκευση των νέων δεδομένων ήταν ανεπιτυχής!');
//        }

        $action=$request->input('action');
        //update the lesson
        if($action=='update')
        {
            DB::update('update lessons set title=?,t_id=?,l_area=?,type=?,semester=?,description=? where l_id=?',[$title,$t_id,$area,$type,$semester,$description,$l_id]);
            return redirect()->back()->with('message','Η ανανέωση πληροφοριών έγινε επιτυχώς!');
        }
        //create a lesson
        if($action=='add')
        {
            //check if the primary key of the lesson that we want to add is unique
            $validator = Validator::make($request->all(), [
                'l_id' => 'unique:lessons,l_id'
            ]);
            //if there is a lesson already in the db with the same primary key then show the following warning
            if ($validator->fails()) {
                return redirect()->back()->with('warning','Υπάρχει ήδη μάθημα με αυτό το κωδικό!');
            }
            //if there is not a lesson with the same primary key in the db then insert the new lesson and show the success message
            DB::insert('insert into lessons (l_id,title,t_id,l_area,type,semester,description) values (?,?,?,?,?,?,?)',[$l_id,$title,$t_id,$area,$type,$semester,$description]);
            return redirect()->back()->with('message','Τα δεδομένα προσθέθηκαν επιτυχώς!');
        }
    }

    // add multiple lesson with an excel file
    function addLessonsByFile(Request $request){

       $file=$request->file('file');

       $data=Excel::toArray([],$file)[0];
        array_shift($data); // remove the first row
        $notindb=[];
        $validator1 = Validator::make($request->all(), [
            'file' => 'required|mimes:xls,xlsx'
        ]);
        if($validator1->fails())
        {
            return redirect()->back()->with('warning','Το αρχείο απαιτείται να είναι της μορφής .xls ή .xlsx');
        }

        foreach($data as $row){
            $validator = Validator::make($row, [

                0 => ['required', function ($attribute, $value,$fail){
                    $value = (string) $value;
                    $count = DB::table('lessons')->where('l_id', $value)->count();
                    if ($count>=1 ) {
                        $fail("The lesson ID '{$value}' has already been taken.");
                    }
                }],
                1 =>['required'],
                2 => ['required', Rule::in(['Προπτυχιακό', 'Μεταπτυχιακό', 'Διδακτορικό'])],
            ]);
            if($validator->fails())
            {
                array_push($notindb,$row[0]);
            }
            if($validator->passes()) {
                DB::table('lessons')->insert([
                    'l_id' => str($row[0]),
                    'title' => $row[1],
                    't_id'=>$request->input('id'),
                    'l_area' => 0,
                    'description'=>'Περιγραφή...',
                    'type' => $row[2],
                    'semester' => str($row[3]).'ο Εξάμηνο',

                ]);
            }

        }
        return redirect()->back()->with([
            'message' =>(count($notindb)==0 || count($notindb)<count($data))? 'Τα δεδομένα προσθέθηκαν επιτυχώς!':null,
            'warning' => count($notindb)>0 ? 'Δεν προσθέθηκαν τα μαθήματα '.json_encode($notindb).'. Παρακαλώ ελέξτε ξανά το τύπο και το κωδικό του μαθήματος' : null,
        ]);
    }

//function that leads to the LessonArea.blade.php. All the users has access to this page. It is shows the home page of the lesson's text area with the lessons info
    public function LessonArea($l_id)
    {
        $data=DB::table('lessons')->where('l_id','=',$l_id)->join('users','users.id','=','lessons.t_id')->select('lessons.*','users.name',)->get();
        $data1=DB::table('notifications')->where('l_id','=',$l_id)->orderBy('created_at','desc')->paginate(3);
        $les_id='';
        $title='';
        $description='';
        $name='';
        foreach ($data as $d) {
            $les_id=$d->l_id;
            $title=$d->title;
            $description=nl2br($d->description);
            $name=$d->name;
        }

        $l_count = DB::table('participations')
            ->where('l_id', '=', $l_id)
            ->value(DB::raw('count(l_id)'));
        $n_count = DB::table('notifications')
            ->where('l_id', '=', $l_id)
            ->value(DB::raw('count(l_id)'));
        $t_count=DB::table('activity_team')
            ->where('l_id', '=', $l_id)
            ->value(DB::raw('count(l_id)'));
        $s_count=DB::table('activity_slot')
            ->where('l_id', '=', $l_id)
            ->value(DB::raw('count(l_id)'));
        $ct_count=DB::table('activity_choose_theme')
            ->where('l_id', '=', $l_id)
            ->value(DB::raw('count(l_id)'));
        $dt_count=DB::table('activity_determinate_themes')
            ->where('l_id', '=', $l_id)
            ->value(DB::raw('count(l_id)'));
        $v_count=DB::table('activity_voting')
            ->where('l_id', '=', $l_id)
            ->value(DB::raw('count(l_id)'));
        $q_count=DB::table('activity_quiz')
            ->where('l_id', '=', $l_id)
            ->value(DB::raw('count(l_id)'));

        return view('lessonarea',['title'=>$title,'l_id'=>$les_id,'description'=>$description,'name'=>$name,'info'=>$l_count,'notifications'=>$data1,'n_count'=>$n_count,'t_count'=>$t_count,'s_count'=>$s_count,'ct_count'=>$ct_count,'dt_count'=>$dt_count,'v_count'=>$v_count,'q_count'=>$q_count]);
    }


// Ενημέρωση περιγραφής ενός μαθήματος
   public function updateDescription(Request $request){
       $l_id=$request->input('l_id');
       $description=$request->input('description');

       $description=str_replace(['<br>','<em>','</em>','<span style="text-decoration: underline;">','</span>','<strong>','</strong>','<li>', '</li>'],["\n","☺","☻",'♦','♣',"♥","♠",'• ',''],$description);
       $description=strip_tags($description,['☺','♦','♣',"♥","♠",'☻','• ',"\n"]);

       if($description==null){$description='Περιγραφή...';}
       if(strlen($description)>255) {
           return redirect()->back()->with('warning','Η περιγραφή του μαθήματος έχει ξεπεράσει το όριο το 255 χαρακτήρων! Η αποθήκευση των νέων δεδομένων ήταν ανεπιτυχής!');
       }
           DB::update('update lessons set description=? where l_id=?',[$description,$l_id]);
           return redirect()->back()->with('message','Η ανανέωση πληροφοριών έγινε επιτυχώς!');
   }


}
