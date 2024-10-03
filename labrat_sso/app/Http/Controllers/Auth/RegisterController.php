<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Mail\MyMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('checkRole');

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
//            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $password=Str::random(10);
        $success=event(new Registered($user = $this->create($request->all(),$password)));


        if ($success) {
        $receiver= $user->email;
//        $receiver='icsd16041@icsd.aegean.gr';
        $data='<p>Γειά σας κ.<strong>'. $user->name.'</strong>, </p>'.
            '<p>Η εγγραφή σας στο σύστημα <strong>LabRat</strong> εγίνε επιτυχώς.<br>'.
            'Μπορείτε να συνδεθείτε στο προφίλ σας με τα παρακάτω στοιχεία.</p>'.
            '<div style="border: 5px double black;width: auto;padding-left: 25%;padding-right: 25%;padding-top:15px;padding-bottom: 15px;"><p><strong>email</strong>: '.$user->email.'<br><strong>password</strong>: '.$password.'</p></div><br>'.
            '<p>Κατά την προσβασή σας στο Labrat έχετε τη δυνατότητα να αλλάξετε το κωδικό σας. </p>'.
            '<p>Πατήστε για σύνδεση στο LabRat: <a href="http://localhost:8080">Εδώ</a></p>';

        Mail::send(new MyMail($data,$receiver));
            return redirect()->back()->with(['message'=>'Η εγγραφή του χρήστη έγινε επιτυχώς!']);
        }else{
            return redirect()->back()->with(['warning'=>'Η εγγραφή του χρήστη απέτυχε!']);
        }

    }



    protected function create(array $data,$password)
    {

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($password),
            'role'=> $data['role'],
            'am'=> $data['am'],
        ]);
    }


    public function import(Request $request){
        $file=$request->file('file');
        $users=Excel::toArray([],$file)[0];
        array_shift($users); // remove the first row
        $notindb=[];
        $validator1 = Validator::make($request->all(), [
            'file' => 'required|mimes:xls,xlsx'
        ]);
        if($validator1->fails())
        {
            return redirect()->back()->with('warning','Το αρχείο απαιτείται να είναι της μορφής .xls ή .xlsx');
        }

        foreach($users as $row){
            $validator = Validator::make($row, [

                0 => ['required', function ($attribute, $value,$fail){
                    $value = (string) $value;
                    $count = DB::table('users')->where('am', $value)->count();
                    if ($count>=1 ) {
                        $fail("The users' am '{$value}' has already been taken.");
                    }
                }],
                1 =>['required'],
                2 => ['required', Rule::in(['Καθηγητής', 'Μαθητής', 'Διαχειριστής'])],
                3 =>['required'],
            ]);
            if($validator->fails())
            {
                array_push($notindb,$row[0]);
            }
            if($validator->passes()) {
                $password=str::random(10);
                User::create([
                    'name' => $row[1],
                    'email' => $row[3],
                    'password' => Hash::make($password),
                    'role'=> $row[2],
                    'am'=> $row[0],
                ]);
                $receiver=$row[3];
                $receiver='icsd16041@icsd.aegean.gr';
                $data='<p>Γειά σας κ.<strong>'.$row[1].'</strong>, </p>'.
                            '<p>Η εγγραφή σας στο σύστημα <strong>LabRat</strong> εγίνε επιτυχώς.<br>'.
                            'Μπορείτε να συνδεθείτε στο προφίλ σας με τα παρακάτω στοιχεία.</p>'.
                            '<div style="border: 5px double black;width: auto;padding-left: 25%;padding-right: 25%;padding-top:15px;padding-bottom: 15px;"><p><strong>email</strong>: '.$row[3].'<br><strong>password</strong>: '.$password.'</p></div><br>'.
                            '<p>Κατά την προσβασή σας στο Labrat έχετε τη δυνατότητα να αλλάξετε το κωδικό σας.</p>';

                Mail::send(new MyMail($data,$receiver));
            }

        }
        return redirect()->back()->with([
            'message' =>(count($notindb)==0 || count($notindb)<count($users))? 'Οι εγγραφές των χρηστών έγινε επιτυχώς!':null,
            'warning' => count($notindb)>0 ? 'Οι εγγραφές των χρηστών '.json_encode($notindb).' απέτυχαν . Παρακαλώ ελέξτε ξανά το τύπο και το κωδικό του μαθήματος' : null,
        ]);

    }
}
