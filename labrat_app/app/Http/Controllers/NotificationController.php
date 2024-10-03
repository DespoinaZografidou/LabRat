<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NotificationController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //δημιουργία Ανακοινώσεων
    public function create_add(Request $request)
    {

        $l_id=$request->input('l_id');
        $n_id=$request->input('not_id');
        $title=$request->input('title');
        $text=$request->input('text');

        $text=str_replace(['<br>','<em>','</em>','<span style="text-decoration: underline;">','</span>','<strong>','</strong>','<li>', '</li>'],["\n","☺","☻",'♦','♣',"♥","♠",'• ',''],$text);
        $text=strip_tags($text,['☺','♦','♣',"♥","♠",'☻','• ',"\n"]);

        date_default_timezone_set('Europe/Athens');
        $currentTimestamp = time();
        $date=date('Y-m-d H:i:s', $currentTimestamp);

        if($request->input('action')=='add'){
            DB::insert('insert into notifications (l_id,title,text,created_at) values (?,?,?,?)',[$l_id,$title,$text,$date]);
            return redirect()->back()->with('message','Τα δεδομένα προσθέθηκαν επιτυχώς!');
        }
        if($request->input('action')=='update'){
            DB::update('update notifications set l_id=?,title=?,text=?,created_at=? where id=?',[$l_id,$title,$text,$date,$n_id]);
            return redirect()->back()->with('message','Η ανανέωση πληροφοριών έγινε επιτυχώς!');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //ενημέρωση Ανακοινώσεων
    public function update(Request $request)
    {
        $n_id=$request->input('n_id');
        $l_id=$request->input('l_id');
        $title=$request->input('title');
        $text=$request->input('text');

        date_default_timezone_set('Europe/Athens');
        $currentTimestamp = time();
        $date=date('Y-m-d H:i:s', $currentTimestamp);;

        DB::update('update notification set l_id=?,title=?,text=?,created_at=? where id=?',[$l_id,$title,$text,$date,$n_id]);
        return redirect()->back()->with('message','Η ανανέωση πληροφοριών έγινε επιτυχώς!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Διαγραφή Ανακοινώσεων μαθημάτων (admin + teacher)
    public function destroy(Request $request)
    {
       $id=$request->input('n_id');
        DB::delete('delete from notifications where id=?',[$id]);
        return redirect()->back()->with('message','Η διαγραφή της ανακοίνωσης έγινε επιτυχώς!');
    }
}
