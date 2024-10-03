<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnouncementController extends Controller
{


    //Εμφάνιση ειδοποιήσεων από τις δραστηριότητες ομάδες  των μαθημάτων που συμμετέχει ο μαθητής (announcements.blade.php)
    public function announcmentsTeams($am,$activity)
    {
        $counterResults = $this->announcmentsCounter($am);
        $team = $counterResults['team'];
        $slot = $counterResults['slot'];
        $c_theme = $counterResults['c_theme'];
        $d_theme = $counterResults['d_theme'];

        $teamNotifications=DB::table('teams AS T')
            ->select('T.id as id','T.confirm', 'T.at_id', 'At.title AS at_title', 'L.title AS l_title', 'L.l_id', 'U.name','AT.created_at', 'AT.updated_at as updated_at')
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
            })->where('AT.created_at', '<',DB::raw('AT.updated_at'))->orderBy('updated_at')
            ->paginate(3, ['*'], 'teamNotifications');

        return view('anouncements',['teamNotifications'=>$teamNotifications,'teams'=>$team,'slots'=>$slot,'c_themes'=>$c_theme,'d_themes'=>$d_theme,'activity'=>$activity]);
    }

    //Εμφάνιση ειδοποιήσεων από τις δραστηριότητες Slots  των μαθημάτων που συμμετέχει ο μαθητής (announcements.blade.php)
    public function announcmentsSlots($am,$activity)
    {
        $counterResults = $this->announcmentsCounter($am);
        $team = $counterResults['team'];
        $slot = $counterResults['slot'];
        $c_theme = $counterResults['c_theme'];
        $d_theme = $counterResults['d_theme'];

        $slotNotifications=DB::table('slot_notification AS SN')
            ->select('SN.id as id','SN.msg','S.slot_time AS s_title', 'As.id AS as_id', 'As.title AS as_title', 'L.title AS l_title', 'L.l_id', 'U.name','As.created_at', 'As.updated_at')
            ->Join('slots as S','S.id', '=', 'SN.slot_id')
            ->join('activity_slot AS As', 'As.id', '=', 'S.as_id')
            ->join('lessons AS L', 'L.l_id', '=', 'As.l_id')
            ->join('users AS U', 'U.id', '=', 'L.t_id')
            ->where('SN.receiver_am', '=', $am)
            ->where('As.created_at', '<',DB::raw('As.updated_at'))
            ->orderBy('As.updated_at','desc')
            ->paginate(3, ['*'], 'slotNotifications');
        return view('anouncements',['slotNotifications'=>$slotNotifications,'teams'=>$team,'slots'=>$slot,'c_themes'=>$c_theme,'d_themes'=>$d_theme,'activity'=>$activity]);
    }


    //Εμφάνιση ειδοποιήσεων από τις δραστηριότητες Επιλογή Θέματος των μαθημάτων που συμμετέχει ο μαθητής (announcements.blade.php)
    public function announcmentsChooseThemes($am,$activity)
    {
        $counterResults = $this->announcmentsCounter($am);
        $team = $counterResults['team'];
        $slot = $counterResults['slot'];
        $c_theme = $counterResults['c_theme'];
        $d_theme = $counterResults['d_theme'];

        $chooseNotifications=DB::table('choose_themes_notifications AS CT')
            ->select('CT.id as id','CT.msg','TH.title AS th_title', 'ACT.id AS act_id', 'ACT.title AS act_title', 'L.title AS l_title', 'L.l_id', 'U.name','ACT.created_at', 'ACT.updated_at')
            ->Join('themes as TH','TH.id', '=', 'CT.th_id')
            ->join('activity_choose_theme AS ACT', 'ACT.id', '=', 'TH.ct_id')
            ->join('lessons AS L', 'L.l_id', '=', 'ACT.l_id')
            ->join('users AS U', 'U.id', '=', 'L.t_id')
            ->where('CT.receiver_am', '=', $am)
            ->where('ACT.created_at', '<',DB::raw('ACT.updated_at'))
            ->orderBy('ACT.updated_at','desc')
            ->paginate(3, ['*'], 'chooseNotifications');

        return view('anouncements',['chooseNotifications'=>$chooseNotifications,'teams'=>$team,'slots'=>$slot,'c_themes'=>$c_theme,'d_themes'=>$d_theme,'activity'=>$activity]);
    }

    //Εμφάνιση ειδοποιήσεων από τις δραστηριότητες Προσδιορισμός Θεμάτων των μαθημάτων που συμμετέχει ο μαθητής (announcements.blade.php)
    public function announcmentsDeterminateThemes($am,$activity)
    {
        $counterResults = $this->announcmentsCounter($am);
        $team = $counterResults['team'];
        $slot = $counterResults['slot'];
        $c_theme = $counterResults['c_theme'];
        $d_theme = $counterResults['d_theme'];

        $determinateNotifications=DB::table('determinate_themes_notifications AS DT')
            ->select('DT.id as id','DT.msg','D.title AS d_title','D.confirm','J.title as j_title', 'ACT.id AS act_id', 'ACT.title AS act_title', 'L.title AS l_title', 'L.l_id', 'U.name','ACT.created_at', 'ACT.updated_at')
            ->Join('determinate_themes as D','D.id', '=', 'DT.dt_id')
            ->join('journals as J','J.id','=','D.j_id')
            ->join('activity_determinate_themes AS ACT', 'ACT.id', '=', 'D.adt_id')
            ->join('lessons AS L', 'L.l_id', '=', 'ACT.l_id')
            ->join('users AS U', 'U.id', '=', 'L.t_id')
            ->where('DT.receiver_am', '=', $am)
            ->where('ACT.created_at', '<',DB::raw('ACT.updated_at'))
            ->orderBy('ACT.updated_at','desc')
            ->paginate(3, ['*'], 'determinateNotifications');
        return view('anouncements',['determinateNotifications'=>$determinateNotifications,'teams'=>$team,'slots'=>$slot,'c_themes'=>$c_theme,'d_themes'=>$d_theme,'activity'=>$activity]);
    }


    //Υπολογίζει πόσες ειδοποιήσεις από κάθε δραστηριότητα αφορούν τον μαθητή
    public function announcmentsCounter($am)
    {

        $team1 = DB::table('teams AS T')
            ->join('activity_team AS AT', 'AT.id', '=', 'T.at_id')
            ->where('T.am', '=', $am)
            ->where('AT.created_at', '<', DB::raw('AT.updated_at'))
            ->where('AT.created_at', '<=', DB::raw('CURRENT_TIMESTAMP'))
            ->where('AT.updated_at', '>', DB::raw('CURRENT_TIMESTAMP'))
            ->count();

        $team2 = DB::table('reject_team AS A')
            ->join('activity_team AS AT', 'AT.id', '=', 'A.at_id')
            ->where('A.receiver_am', '=', $am)  // Fixed the reference to 'A.receiver_am'
            ->where('AT.created_at', '<', DB::raw('AT.updated_at'))
            ->where('AT.created_at', '<=', DB::raw('CURRENT_TIMESTAMP'))
            ->where('AT.updated_at', '>', DB::raw('CURRENT_TIMESTAMP'))
            ->count();
        $team = $team1 + $team2;
        $slot = DB::table('slot_notification AS SN')
            ->join('slots as S', 'S.id', '=', 'SN.slot_id')
            ->join('activity_slot AS Asl', 'Asl.id', '=', 'S.as_id')
            ->where('Asl.created_at', '<', DB::raw('Asl.updated_at'))
            ->where('Asl.created_at', '<=', DB::raw('CURRENT_TIMESTAMP'))
            ->where('Asl.updated_at', '>', DB::raw('CURRENT_TIMESTAMP'))
            ->where('SN.receiver_am', '=', $am)
            ->count();
        $c_theme = DB::table('choose_themes_notifications AS CT')
            ->Join('themes as TH', 'TH.id', '=', 'CT.th_id')
            ->join('activity_choose_theme AS ACT', 'ACT.id', '=', 'TH.ct_id')
            ->where('ACT.created_at', '<', DB::raw('ACT.updated_at')) // Changed 'Asl.updated_at' to 'ACT.updated_at'
            ->where('ACT.created_at', '<=', DB::raw('CURRENT_TIMESTAMP'))
            ->where('ACT.updated_at', '>', DB::raw('CURRENT_TIMESTAMP'))
            ->where('CT.receiver_am', '=', $am)
            ->count();

        $d_theme=DB::table('determinate_themes_notifications AS DT')
            ->Join('determinate_themes as D','D.id', '=', 'DT.dt_id')
            ->join('activity_determinate_themes AS ACT', 'ACT.id', '=', 'D.adt_id')
            ->where('DT.receiver_am', '=', $am)
            ->where('ACT.created_at', '<', DB::raw('ACT.updated_at'))
            ->where('ACT.created_at', '<=', DB::raw('CURRENT_TIMESTAMP'))
            ->where('ACT.updated_at', '>', DB::raw('CURRENT_TIMESTAMP'))->count();
        return ['team' => $team, 'slot' => $slot, 'c_theme' => $c_theme,'d_theme'=>$d_theme];
    }


    //διαγραφή ειδοποιήσεων για τις δραστηριότητες slot στο αρχείο (announcements.blade.php)
    public function deleteSlotNotification(Request $request)
    {
        $sn_id=$request->input('id');
        DB::delete('delete from slot_notification where id=?',[$sn_id]);
        return redirect()->back()->with('message','Η διαγραφή ειδοποίηση έγινε επιτυχώς!');
    }


    //διαγραφή ειδοποιήσεων για τις δραστηριότητες ομάδες στο αρχείο (announcements.blade.php)
    public function deletethereject(Request $request)
    {
        DB::delete('delete from reject_team where id=?',[$request->input('a_id')]);
        return redirect()->back()->with('message','Η διαγραφή ειδοποίηση έγινε επιτυχώς!');
    }

    //διαγραφή ειδοποιήσεων για τις δραστηριότητες Επιλογής θεμάτων στο αρχείο (announcements.blade.php)
    public function deleteChooseNotification(Request $request)
    {
        $ctn_id=$request->input('id');
        DB::delete('delete from choose_themes_notifications where id=?',[$ctn_id]);
        return redirect()->back()->with('message','Η διαγραφή ειδοποίηση έγινε επιτυχώς!');
    }

    //διαγραφή ειδοποιήσεων για τις δραστηριότητες Προσδιορισμός θεμάτων στο αρχείο (announcements.blade.php)
    public function deletedeterminateNotification(Request $request)
    {
        $dtn_id=$request->input('id');
        DB::delete('delete from determinate_themes_notifications where id=?',[$dtn_id]);
        return redirect()->back()->with('message','Η διαγραφή ειδοποίηση έγινε επιτυχώς!');
    }

    //τρέχει μέσω script. Ελέγχει αν υπάρχουν ειδοποιήσεις για τον μαθητή ώστε να να τον ενημερώσει στο μενού του
    public function greenthebell(Request $request){
        $am=$request->input('am');
        $counterResults = $this->announcmentsCounter($am);

        $counter = $counterResults['team']+$counterResults['slot'] +$counterResults['c_theme'] +$counterResults['d_theme'];
        if($counter==0) {
            return response()->json(['message' => 'fail']);
        }
        else {
            return response()->json(['message' => 'success']);
        }
    }
}
