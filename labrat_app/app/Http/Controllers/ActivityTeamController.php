<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Team;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TeamsExport;

class ActivityTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //Δείξε όλες της δραστηριότητες (team_activities.blade.php)
    public function showTeamActivities($l_id,$title,$name)
    {
       $data=DB::table('activity_team')->where('l_id','=',$l_id)->orderby('created_at', 'desc')->paginate(15);
        $p_count = DB::table('participations')->where('l_id', '=', $l_id)->value(DB::raw('count(l_id)'));
        return view('team_activities',['title'=>$title,'l_id'=>$l_id,'name'=>$name,'acteams'=>$data,'p_count'=>$p_count]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //δημιουργία ή Ανανέωση της δραστηριότητας ομάδας(popup-windows/activityTeam-Delete-Add-Edit.blade.php για τη σελίδα team_activities.blade.php)
    public function create_update(Request $request)
    {
        $l_id=$request->input('l_id');
        $ta_id=$request->input('act_id');
        $title=$request->input('title');
        $maxnum=$request->input('maxnum');
        $text=$request->input('text');
        $text=str_replace(['<br>','<em>','</em>','<span style="text-decoration: underline;">','</span>','<strong>','</strong>','<li>', '</li>'],["\n","☺","☻",'♦','♣',"♥","♠",'• ',''],$text);
        $text=strip_tags($text,['☺','♦','♣',"♥","♠",'☻','• ',"\n"]);
        $status=0;

        date_default_timezone_set('Europe/Athens');
        $currentTimestamp = time();
        $date=date('Y-m-d H:i:s', $currentTimestamp);


        date_default_timezone_set('Europe/Athens');

        $startdate=date('Y-m-d H:i:s', strtotime($request->input('startdate')));
        $enddate=date('Y-m-d H:i:s', strtotime($request->input('enddate')));


        if($enddate<$startdate)
        {
            return redirect()->back()->with('warning','Η προσθήκη των δεδωμένων έγινε ανεπιτυχώς!. Η ημερομηνία έναρξης και λήξης δεν ήταν λάθος καταχωρημένες!');
        }

        if($request->input('action')=='add'){
            DB::insert('insert into activity_team (l_id,title,text,mnp,created_at,updated_at,status) values (?,?,?,?,?,?,?)',[$l_id,$title,$text,$maxnum,$startdate,$enddate,$status]);
            return redirect()->back()->with('message','Η προσθήκη των δεδομένων έγινε επιτυχώς!');
        }
        if($request->input('action')=='update'){

            DB::update('update activity_team set l_id=?,title=?,text=?,mnp=?,created_at=?,updated_at=?,status=? where id=?',[$l_id,$title,$text,$maxnum,$startdate,$enddate,$status,$ta_id]);
            return redirect()->back()->with('message','Η ανανέωση πληροφοριών έγινε επιτυχώς!');
        }

    }

//εμφάνιση την επιλεγμένη δραστηριότητα στη σελίδα  με της πληροφορείες της και της ομάδες που έχουν δημιουργηθεί ( alltheteams.blade.php)
    function showTheActivityTeam($l_id,$title,$name,$at_id){

        $activity=DB::table('activity_team')->where('id', '=', $at_id)->get();

        $data=DB::table('teams as T')->where('at_id','=',$at_id)
            ->select('T.*', 'U.name','U.am')
            ->selectRaw('(SELECT GROUP_CONCAT(u.am, " - ", u.name SEPARATOR " , ") FROM teams AS T1 JOIN users AS u  ON u.am=T1.am  WHERE T1.t_id = T.t_id AND T1.at_id = T.at_id ) AS Allthenames')
            ->selectRaw('(SELECT count(*) FROM  teams AS T1  WHERE T1.t_id = T.t_id AND T1.at_id = T.at_id ) AS num')
            ->join('users as U','U.am','=','T.am')->orderBy('T.t_id')->get();

        $participants =  DB::table('participations as P')
            ->select('P.am', 'U.name')
            ->leftJoin('teams as T', function ($join) use ($at_id) {
                $join->on('T.am', '=', 'P.am')
                    ->where('T.at_id', '=', $at_id);
            })
            ->join('users as U', 'U.am', '=', 'P.am')
            ->whereNull('T.am')
            ->where('P.l_id', '=', $l_id)
            ->get();

        return view('alltheteams',['title'=>$title,'l_id'=>$l_id,'name'=>$name,'activity'=>$activity,'teams'=>$data,'participants'=>json_encode($participants)]);
    }


//Επιβεβαίωση αιτήματος συμετοχής σε ομάδα ( popup_windows/team_Confirm_Reject_Create.blade.php για τη σελίδα Student_home.blade.php )
    public function confirmTheTeam(Request $request){

        $id=$request->input('join_id');

        DB::update('update teams set confirm=? where  id=?',[1,$id]);
        return redirect()->back()->with('message','Η επιβεβαίωση συμμετοχής στης ομάδα έγινε επιτυχώς!');
    }

    //Απόρριψη/Αποχώρηση από ομάδας ( popup_windows/team_Confirm_Reject_Create.blade.php για τη σελίδα Student_home.blade.php )
    //και εισαγωγή στον πινακά reject_team η εγγραφή
    public function rejectTheTeam(Request $request){

        $data =$request->input('reject_data');
        $data=json_decode($data,true);
        $del_id=$data['del_id'];

        DB::delete('delete from teams where id=?',[$del_id]);

        //Ψάξε να βρείς ποιά άλλα άτομα είναι στην ίδια ομάδα για να σταλθεί το μνμ αποχώρησης
        $receivers= DB::table('teams')
            ->select('am')
            ->where('t_id','=',$data['t_id'])
            ->where('at_id','=',$data['at_id'])
            ->where('confirm','=',1)
            ->get();

        foreach($receivers as $r){
            DB::insert('insert into reject_team(am,at_id,receiver_am,confirm) values(?,?,?,?)',[$data['am'],$data['at_id'],$r->am,2]);
        }
         return redirect()->back()->with('message','Η αποχώρηση από την ομάδα έγινε επιτυχώς!');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // Εισαγωγή/Δημιουργία νέας ομάδας (popup_windows/team_Confirm_Reject_Create.blade.php για τη σελίδα Student_home.blade.php )
    public function createAteam(Request $request)
    {
        $am=$request->input('am');
        $at_id=$request->input('at_id');
        $t_id=$request->input('t_id');

        //'Ελεγγος αν υπάρχει ήδη καταχωρημένη αίτηση συμμετοχής για το χρήστη
        $check=Team::where('at_id', $at_id)->where('am', $am)->count();

            if($request->has('confirm'))
            {
                if($check>0){
                    return redirect()->back()->with('warning','Η δημιουργία ομάδας δεν καταχωρηθηκε!Υπαρχεί αίτηση συμμετοχής από ήδη υπάρχουσα ομάδα');
                }
                else{
                    DB::insert('insert into teams(am,at_id,t_id,confirm) values(?,?,?,?)',[$am,$at_id,$t_id,1]);
                }
            }
            else {
                if ($check > 0) {
                    return redirect()->back()->with('warning', 'Η είσαγωγή του νέου μέλους της ομάδας δεν καταχωρηθηκε!Υπαρχεί αίτηση συμμετοχής από ήδη υπάρχουσα ομάδα');
                }
                else{
                DB::insert('insert into teams(am,at_id,t_id) values(?,?,?)', [$am, $at_id, $t_id]);
                }
            }

        return redirect()->back()->with('message','Η δημιουργία ομάδας έγινε επιτυχώς!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Διαγραφή ομάδας ομάδας από το διαχειριστή της ομάδας
    public function deleteMyTeam(Request $request)
    {
      $t_id=$request->input('t_id');
      $at_id=$request->input('at_id');

      DB::delete('delete from teams where t_id=? AND at_id=?',[$t_id,$at_id]);

      return redirect()->back()->with('message','Η διαγραφή ομάδας έγινε επιτυχώς!');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Εξαγωγή ομάδων σε αρχείο
    public function ExrportTeams(Request $request){

        $at_id=$request->input('at_id');
        $filename=$request->input('filename');
        $filename=$filename.'.xlsx';

        return Excel::download(new TeamsExport($at_id), $filename);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //διαγραφή ομάδας
    public function destroy(Request $request)
    {
        $id=$request->input('at_id');
        DB::delete('delete from activity_team where id=?',[$id]);
        return redirect()->back()->with('message','Η διαγραφή της δραστηριότητας έγινε επιτυχώς!');
    }

    //Διεξαγωγή των τελικών ομάδων
    public function theFinalTeams(Request $request){
        $at_id=$request->input('at_id');
        DB::delete('delete from teams where at_id=? AND confirm IS NULL',[$at_id]);
        DB::update('update activity_team set status=?  where id=?',[1,$at_id]);
        return redirect()->back()->with('message','Οι ομάδες διαμορφώθηκαν επιτυχώς!');
    }

}
