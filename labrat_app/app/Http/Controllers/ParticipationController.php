<?php

namespace App\Http\Controllers;
    use App\Exports\ParticipationExport;
    use Illuminate\Support\Facades\DB;
    use App\Models\Participation;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Validation\Rule;
    use Maatwebsite\Excel\Facades\Excel;

    use Symfony\Component\HttpFoundation\BinaryFileResponse;


class ParticipationController extends Controller
{
    //Τhis is a function that returns all the lessons for the students to join in the page jointolesson.blade.php
    public function Participations($type,$am)
    {

        $data=DB::table('lessons AS L')->where('L.l_area','=',1)
            ->join('users AS U', 'L.t_id', '=', 'U.id')
            ->leftJoin('participations AS P', function ($join)use ($am) {
                $join->on('L.l_id', '=', 'P.l_id')
                    ->where('P.am', '=',$am);
            })
            ->where('L.type', '=', $type)
            ->select('L.l_id', 'L.title', 'L.semester', 'U.name','P.id', DB::raw("IF(P.am='".$am."', 1, 0) AS part"))
            ->orderby('L.semester','asc')->paginate(26);
        $professors=DB::table('users')->where('role','=','Καθηγητής')->orderby('name')->get();

        return view('jointolessons',['lessons'=>$data,'type'=>$type,'professors'=>$professors]);
    }

    //εμφάνιση των μαθημάτων με βάσει των κριτηρίων που εισάγει ο χρήστης
    public function filterLessons($type,$am,Request $request)
    {
        $conditions=[['L.type','=',$type],['L.l_area','=',1]];
        $semester=$request->input('semester');
        $t_id=$request->input('professor');

        if($semester!==null)
        {
            $p=['semester','=',$semester];
            array_push($conditions,$p);
        }
        if($t_id!==null)
        {
            $t_id=(int)$t_id;
            $p=['L.t_id','=',$t_id];
            array_push($conditions,$p);
        }
        $data=DB::table('lessons AS L')->where($conditions)
            ->join('users AS U', 'L.t_id', '=', 'U.id')
            ->leftJoin('participations AS P', function ($join)use ($am) {
                $join->on('L.l_id', '=', 'P.l_id')
                    ->where('P.am', '=',$am);
            })
            ->where('L.type', '=', $type)
            ->select('L.l_id', 'L.title', 'L.semester', 'U.name','P.id', DB::raw("IF(P.am='".$am."', 1, 0) AS part"))
            ->orderby('L.semester','asc')->paginate(26);

        $professors=DB::table('users')->where('role','=','Καθηγητής')->orderby('name')->get();
        return view('jointolessons',['lessons'=>$data,'type'=>$type,'professors'=>$professors]);
    }

    //this is a function tha a student can join to a lesson
    public function join(Request $request)
    {
        $s_am=$request->input('am');
        $l_id=$request->input('l_id');
        DB::insert('insert into participations (l_id,am) values (?,?)',[$l_id,$s_am]);
        return redirect()->back()->with('message','Η συμμετοχή προστέθηκε επιτυχώς');
    }
    //this is a function tha a student can leave from a lesson
    public function leave(Request $request)
    {
        $p_id=$request->input('p_id');
        DB::delete('delete from  participations where id=?',[$p_id]);
        return redirect()->back()->with('message','Η συμμετοχή διαγράφηκε επιτυχώς');
    }

    //function that shows all the participants of a lesson to the admin and the teachers (participants.blade.php)
    public function Participants($l_id,$title,$name){
        $data=DB::table('Participations AS P')->
        where('P.l_id','=',$l_id)->
        join('users','users.am','=','P.am')->
        Select('users.*','P.*')->orderby('P.am','asc')->paginate(26);

        return view('participants',['participants'=>$data,'l_id'=>$l_id,'title'=>$title,'name'=>$name]);
    }
    //function to export the participants to a file
    public function ExrportParticipants(Request $request){

        $l_id=$request->input('l_id');
        $filename=$request->input('filename');
        $filename=$filename.'.xlsx';

        return Excel::download(new ParticipationExport($l_id), $filename);


    }
    //function tha provides the ability to insert in the database new participation to a lesson (for Admin and Teachers).(participants.blade.php)
    public function ImportParticipants(Request $request){
        $file=$request->file('file');
        $l_id=$request->input('l_id');

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

                0 => ['required', function ($attribute, $value,$fail) use ($l_id){
                    $value = (string) $value;
                    $count = DB::table('users')->where('am', $value)->count();
                    $existingParticipation = DB::table('participations')
                        ->where('am', $value)
                        ->where('l_id', $l_id)
                        ->first();

                    if ($count==0 ) {
                        $fail("The user '{$value}' there are not in the system.");
                    }

                    if($existingParticipation){ $fail("This participation already exists."); }
                }],
            ]);
            if($validator->fails())
            {
                array_push($notindb,$row[0]);
            }
            if($validator->passes()) {
                DB::table('participations')->insert([
                    'am' => str($row[0]),
                    'l_id' => str($l_id)

                ]);
            }

        }
        return redirect()->back()->with([
            'message' =>(count($notindb)==0 || count($notindb)<count($data))? 'Τα δεδομένα προσθέθηκαν επιτυχώς!':null,
            'warning' => count($notindb)>0 ? 'Δεν προσθέθηκαν οι συμμετοχές '.json_encode($notindb).'. Οι προαναφερόμενες συμμετοχές, είτε υπάρχουν ήδη, είτε δεν είναι εγγεγραμμένοι χρήστες στο σύστημα!' : null,
        ]);

    }

//function tha a teacher or the admin can search a participant by name or am  (participants.blade.php)
    public function searchparticipants(Request $request,$l_id,$title,$name){

        $key=$request->input('key');

        $data = DB::table('Participations AS P')
            ->where('P.l_id', '=', $l_id)
            ->join('users', 'users.am', '=', 'P.am')
            ->where(function ($query) use ($key) {
                $query->where('users.name', 'LIKE', '%' . $key . '%')
                    ->orWhere('users.am', 'LIKE', '%' . $key . '%');
            })
            ->select('users.*', 'P.*')
            ->orderBy('P.am', 'asc')
            ->paginate(26);

        return view('participants',['participants'=>$data,'l_id'=>$l_id,'title'=>$title,'name'=>$name]);
    }

    //function that give the ability to the students to search the lessons by title or semester (jointolessons.blade.php).
        public function SearchForParticipation(Request $request,$type,$am){

            $key=$request->input('key');


            $data=DB::table('lessons AS L')->
            where('L.l_area','=',1)->
            where( function ($query) use ($key) {
                $query->where('L.title','LIKE','%'.$key.'%')
                    ->orWhere('L.semester','LIKE','%'.$key.'%');
            })
                ->join('users AS U', 'L.t_id', '=', 'U.id')
                ->leftJoin('participations AS P', function ($join)use ($am) {
                    $join->on('L.l_id', '=', 'P.l_id')
                        ->where('P.am', '=',$am);
                })
                ->where('L.type', '=', $type)
                ->select('L.l_id', 'L.title', 'L.semester', 'U.name','P.id', DB::raw("IF(P.am='".$am."', 1, 0) AS part"))
                ->orderby('L.semester','asc')->paginate(26);

            $professors=DB::table('users')->where('role','=','Καθηγητής')->orderby('name')->get();

            return view('jointolessons',['lessons'=>$data,'type'=>$type,'key'=>$key,'professors'=>$professors]);
        }



        // Ελεγχος αν ένας χρήστης συμετέχει στο μάθημα
        public function participationCheck(Request $request){
            $l_id=$request->input('l_id');
            $am=$request->input('am');

            $data=DB::table('participations')->where('am','=',$am)->where('l_id','=',$l_id)->first();

            if(!$data) {
                return response()->json(['message' => 'fail']);
            }
            else {
                return response()->json(['message' => 'success']);
            }

        }


}
