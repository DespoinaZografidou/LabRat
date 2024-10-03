<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $professors=DB::table('users')->where('role','=','Καθηγητής')->count();
        $students=DB::table('users')->where('role','=','Μαθητής')->count();
        $admin=DB::table('users')->where('role','=','Διαχειριστής')->count();

        $professors1=DB::table('users')->where('role','=','Καθηγητής')->where('system_status','=',1)->count();
        $students1=DB::table('users')->where('role','=','Μαθητής')->where('system_status','=',1)->count();
        $admin1=DB::table('users')->where('role','=','Διαχειριστής')->where('system_status','=',1)->count();

        $professors0=DB::table('users')->where('role','=','Καθηγητής')->where('system_status','=',0)->count();
        $students0=DB::table('users')->where('role','=','Μαθητής')->where('system_status','=',0)->count();
        $admin0=DB::table('users')->where('role','=','Διαχειριστής')->where('system_status','=',0)->count();

        $plessons=DB::table('lessons')->where('type','=','Προπτυχιακό')->count();
        $mlessons=DB::table('lessons')->where('type','=','Μεταπτυχιακό')->count();
        $dlessons=DB::table('lessons')->where('type','=','Διδακτορικό')->count();

        $plessons1=DB::table('lessons')->where('type','=','Προπτυχιακό')->where('l_area','=',1)->count();
        $mlessons1=DB::table('lessons')->where('type','=','Μεταπτυχιακό')->where('l_area','=',1)->count();
        $dlessons1=DB::table('lessons')->where('type','=','Διδακτορικό')->where('l_area','=',1)->count();

        $plessons0=DB::table('lessons')->where('type','=','Προπτυχιακό')->where('l_area','=',0)->count();
        $mlessons0=DB::table('lessons')->where('type','=','Μεταπτυχιακό')->where('l_area','=',0)->count();
        $dlessons0=DB::table('lessons')->where('type','=','Διδακτορικό')->where('l_area','=',0)->count();
        return view("home",['professors'=>$professors,'students'=>$students,'admin'=>$admin,'professors1'=>$professors1,'students1'=>$students1,'admin1'=>$admin1,'professors0'=>$professors0,'students0'=>$students0,'admin0'=>$admin0,'plessons'=>$plessons,'mlessons'=>$mlessons,'dlessons'=>$dlessons,'plessons1'=>$plessons1,'mlessons1'=>$mlessons1,'dlessons1'=>$dlessons1,'plessons0'=>$plessons0,'mlessons0'=>$mlessons0,'dlessons0'=>$dlessons0]);
    }

    public function StudentsHome($type,$am){

            //show all the lessons for the Students that they had joined
            $data= DB::table('participations as P')
                ->select('L.*', 'U.name', 'P.id', 'P.am')
                ->leftJoin('lessons as L',function($join){
                    $join->on('L.l_id', '=', 'P.l_id')
                    ->where('L.l_area','=',1);
                })
                ->leftJoin('users as U', 'U.id', '=', 'L.t_id')
                ->where('P.am', '=',$am)
                ->where('L.type','=' ,$type)->orderby('L.semester','asc')->paginate(3, ['*'], 'lessons');

        //show all the notifications from the lessons that the student has joined in
            $notifications=DB::table('notifications as N')
                ->select('N.*', 'L.l_id', 'L.title as l_title', 'U.name')
                ->join('participations AS P', function($join) use ($am) {
                    $join->on('N.l_id', '=', 'P.l_id')
                    ->where('P.am', '=', $am);
                })
                ->join('lessons AS L', 'L.l_id', '=', 'P.l_id')
                ->join('users AS U', 'U.id', '=', 'L.t_id')
                ->orderby('N.created_at','desc')->paginate(3, ['*'], 'notifications');


            return view('home',['lessons'=>$data,'type'=>$type,'notifications'=>$notifications]);


    }

    public function announcments($am,$activity)
    {
        $teamNotifications=DB::table('teams AS T')
            ->select('T.id as id','T.confirm', 'T.at_id', 'At.title AS at_title', 'L.title AS l_title', 'L.l_id', 'U.name','AT.created_at', 'AT.updated_at')
            ->selectSub(function ($query) {
                $query->select(DB::raw("GROUP_CONCAT(u.am, ' - ', u.name SEPARATOR ', ')"))
                    ->from('users AS u')
                    ->join('teams AS T1', 'u.am', '=', 'T1.am')
                    ->whereColumn('T1.t_id', '=', 'T.t_id')
                    ->whereColumn('T1.at_id', '=', 'T.at_id');
            }, 'Allthenames')
            ->join('activity_team AS AT', 'AT.id', '=', 'T.at_id')
            ->join('lessons AS L', 'L.l_id', '=', 'AT.l_id')
            ->join('users AS U', 'U.id', '=', 'L.t_id')
            ->where('T.am', '=', $am)
            ->unionAll(function ($query) use ($am) {
                $query->select('A.id as id','A.confirm','A.at_id', 'At.title AS at_title', 'L.title AS l_title', 'L.l_id', 'U.name','AT.created_at', 'AT.updated_at')
                    ->selectSub(function ($query) {
                        $query->select(DB::raw("GROUP_CONCAT(u.am, ' - ', u.name)"))
                            ->from('users AS u')
                            ->whereColumn('u.am', '=', 'A.am');
                    }, 'Allthenames')
                    ->from('reject_team AS A')
                    ->join('activity_team AS AT', 'AT.id', '=', 'A.at_id')
                    ->join('lessons AS L', 'L.l_id', '=', 'AT.l_id')
                    ->join('users AS U', 'U.id', '=', 'L.t_id')
                    ->where('A.receiver_am', '=', $am)
                    ->where('A.confirm', '=', 2);
            })->paginate(3, ['*'], 'teamNotifications');


        $slotNotifications=DB::table('slot_notification AS SN')
            ->select('SN.id as id','SN.msg','S.slot_time AS s_title', 'As.id AS as_id', 'As.title AS as_title', 'L.title AS l_title', 'L.l_id', 'U.name','As.created_at', 'As.updated_at')
            ->Join('slots as S','S.id', '=', 'SN.slot_id')
            ->join('activity_slot AS As', 'As.id', '=', 'S.as_id')
            ->join('lessons AS L', 'L.l_id', '=', 'As.l_id')
            ->join('users AS U', 'U.id', '=', 'L.t_id')
            ->where('SN.receiver_am', '=', $am)
            ->orderBy('SN.id','desc')
            ->paginate(3, ['*'], 'slotNotifications');
        return view('anouncements',['teamNotifications'=>$teamNotifications,'slotNotifications'=>$slotNotifications,'activity'=>$activity]);
    }

    public function TeacherHome($type,$am){

        //show all the lessons for the Students that they had joined
        $data= DB::table('lessons as L')
            ->select('L.*', 'U.name')
            ->leftJoin('users as U', 'U.id', '=', 'L.t_id')
            ->where('L.t_id', '=',$am)
            ->where('L.l_area','=',1)
            ->where('L.type','=' ,$type)
            ->orderby('L.semester','asc')
            ->paginate(3, ['*'], 'lessons');

        //show all the notifications from the lessons that the student has joined in
        $notifications=DB::table('notifications as N')
            ->select('N.*', 'L.l_id', 'L.title as l_title', 'U.name')

            ->join('lessons AS L',function ($join) use ($am) {
                $join->on('L.l_id', '=', 'N.l_id')
                    ->where('L.t_id','=',$am);
            })
            ->join('users AS U', 'U.id', '=', 'L.t_id')
            ->orderby('N.created_at','desc')->paginate(3, ['*'], 'notifications');


        $determinateNotifications=DB::table('lessons AS L')
            ->where('L.t_id','=',$am)
            ->select('ACT.id AS act_id', 'ACT.title AS act_title', 'L.title AS l_title', 'L.l_id', 'U.name','ACT.created_at', 'ACT.updated_at')
            ->selectRaw("(SELECT COUNT('D.adt_id') FROM determinate_themes as D WHERE D.confirm=0 AND D.adt_id=ACT.id GROUP BY D.adt_id) as dt_count")
            ->join('activity_determinate_themes AS ACT', function($join){
                $join->on('ACT.l_id', '=', 'L.l_id')
                ->where('ACT.created_at', '<',DB::raw('ACT.updated_at'))
                ->where('ACT.updated_at', '>',now());
            })
            ->join('users AS U', 'U.id', '=', 'L.t_id')
            ->orderBy('act_id','desc')
            ->paginate(3, ['*'], 'determinateNotifications');
        foreach ($determinateNotifications as $key => $d) {
            if ($d->dt_count == 0) {
                unset($determinateNotifications[$key]);
            }
        }

        return view('home',['type'=>$type,'lessons'=>$data,'notifications'=>$notifications,'determinateNotifications'=>$determinateNotifications]);

    }



}
