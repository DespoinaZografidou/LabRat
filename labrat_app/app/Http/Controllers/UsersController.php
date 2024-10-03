<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // Show all the users to the page users.blade.php for the Admin
    public function showUsers($role)
    {
        //show all the users of a specific role
         $data=DB::table('users')->select('users.*')->where('role','=',$role)->orderby('am','desc')->paginate(16);
         $key='';
         return view('users',['users'=>$data,'title'=>$role,'key'=>$key]);


    }

    //show all the users who have all the criteria of the filters
    public function filterUsers($role,Request $request)
    {

        $conditions=[['role','=',$role]];
        $register_year= $request->input('register_year');
        $system_status=$request->input('status');
        $type=$request->input('type');
        $qualification=$request->input('qualification');

        if($register_year!=null)
        {
            $year=(int)$register_year;
            $p=['register_year','=',$year];
            array_push($conditions,$p);
        }
        if($system_status!=null)
        {
            $status=(int)$system_status;
            $p=['system_status','=',$status];
            array_push($conditions,$p);
        }
        if($type!=null)
        {
            $p=['type','=',$type];
            array_push($conditions,$p);
        }
        if($qualification!=null)
        {
            $p=['qualification','=',$qualification];
            array_push($conditions,$p);
        }
        $data=DB::table('users')->select('users.*')->where($conditions)->orderby('am','desc')->paginate(16);
        return view('users',['users'=>$data,'title'=>$role]);
    }

    // Αναζήτηση χρηστών με βάση το όνομα ή το am
    public function searchUsers($role,Request $request)
    {
        $conditions=[['role','=',$role]];
        $orcondition=[];
        $key= $request->input('key');

        if($key!='')
        {
            $p=['name','LIKE','%'.$key.'%'];
            array_push($conditions,$p);
            $p=['am','LIKE','%'.$key.'%'];
            array_push($orcondition,$p);
        }

        $data=DB::table('users')->select('users.*')->where($conditions)->orWhere($orcondition)->orderby('am','desc')->paginate(16);
        return view('users',['users'=>$data,'title'=>$role,'key'=>$key]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


   //Update the personal information of the user from the profile.blade.php
    public function updateType(Request $request,$id,$column)
    {
        $data=$request->input('newdata');
        DB::update('update users set '.$column.'=? where id=?',[$data,$id]);
        return redirect()->back()->with('message','Η ανανέωση πληροφοριών έγινε επιτυχώς!');
    }

    // ενημέρωση πληροφοριών ενός χρήστη
    public function updateInfo(Request $request)
    {


        $qualification=null;
        if($request->input('role')=='Καθηγητής'){
            $qualification=$request->input('qualification');
        }

        $register_year=$request->input('register_year');
        $type=$request->input('type');
        $system_status=$request->input('system_status');
        $id=$request->input('id');

        if($request->file('image')!=null){
            $image = $request->file('image');
            $filename = time() . '_' .$image->getClientOriginalName();

            // Move the uploaded file to a desired directory
            $image->move(public_path('users_images'), $filename);
            DB::update('update users set register_year=?,type=?,system_status=?,image=?,qualification=? where id=?',[$register_year,$type,$system_status, $filename ,$qualification,$id]);
            return redirect()->back()->with('message', 'Η ανανέωση πληροφοριών έγινε επιτυχώς!');
        }

       DB::update('update users set register_year=?,type=?,system_status=?,qualification=? where id=?',[$register_year,$type,$system_status,$qualification,$id]);
        return redirect()->back()->with('message', 'Η ανανέωση πληροφοριών έγινε επιτυχώς!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //διαγραφή ενός χρήστη
    public function destroy(Request $request)
    {
        $id=$request->input('id');
        $userEmail = DB::table('users')->where('id', $id)->value('email');


        if($userEmail){
            DB::delete('delete from users where id=?',[$id]);
            $access_token = session()->get("access_token");
            $response = Http::withHeaders([
                "Accept"=>"application/json",
                "Authorization"=>"Bearer " . $access_token,
            ])->get(config("auth.sso_host") .  "/api/deleteuser/".$userEmail);

            // Check the response from the source project
            if ($response->successful()) {
                $error = $response->json();
                return redirect()->back()->with('message','Η διαγραφή του χρήστη έγινε επιτυχώς!');
            } else {
                // Handle error
                $error = $response->json();
                return redirect()->back()->with('warning','Η διαγραφή του χρήστη έγινε ανεπιτυχώς!');
            }
        }
        else{
            return redirect()->back()->with('warning','ο χρήστης ήδη έχει διαγραφεί');
        }


    }



}
