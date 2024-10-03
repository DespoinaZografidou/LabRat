<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\MyMail;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function showTheResetForm($token,$email)
    {
        return view('auth\passwords\reset',['token'=>$token],['email'=>$email]);
    }
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

         $user=User::where('email', $request->input('email'))->first();

         if($user){
             $token = Password::createToken($user);

             $receiver=$request->input('email');
//             $receiver='icsd16041@icsd.aegean.gr';
             $data='<p>Γειά σας κ.<strong>'.$user->name.'</strong>, </p>'.
                 '<p>Ξεχάσατε το κωδικό σας ή θέλετε να αλλάξετε το κωδικό σας;<br> Έδω είναι το αίτημά σας για την αλλάγή του κωδικού σας.<br>'.
                 'Αν το αίτημα δεν το κάνατε εσείς, παρακάλω αγνοείστε το.<br>'.
                 'Διαφορετικά, το λινκ για την αλλαγή κωδικού σας είναι παρακάτω.</p>'.
                 '<p> Πατήστε για αλλαγή κωδικού: <a href="http://localhost:8000/resetcode/' . $token . '/' .$user->email. '">Εδώ</a></p>';


             Mail::send(new MyMail($data,$receiver));

             return redirect()->back()->with(['message'=>'Έχει σταλεί το λινκ αλλαγής κωδικού στα mail σας.']);
         }
         else{
             return redirect()->back()->with(['warning'=>'Δεν υπάρχει χρήστης με αυτό το mail.']);
         }

    }

    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }




}
