<?php

use App\Http\Controllers\SSO\SSOController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ParticipationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ActivityTeamController;
use App\Http\Controllers\ActivitySlotController;
use App\Http\Controllers\ActivityChooseThemeController;
use App\Http\Controllers\ActivityDeterminateThemesController;
use App\Http\Controllers\ActivityVotingController;
use App\Http\Controllers\ActivityQuizController;
use App\Http\Controllers\AnouncementController;
use App\Http\Controllers\QuizTriesController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes(['register' => false, 'reset' => false ]);

Route::get("/sso/login",[SSOController::class, 'getLogin'])->name("sso.login");
Route::get("/callback",[SSOController::class, 'getCallback'])->name("sso.callback");
Route::get("/sso/connect",[SSOController::class, 'connectUser'])->name("sso.connect");
Route::get('/sso/register',[SSOController::class,'registerUsersOnSSO'])->name("sso");

Route::get('/myhome', [HomeController::class, 'index'])->name('myhome');
Route::get('/home/{type}/{am}',[HomeController::class,'StudentsHome'])->name('homepage');
Route::get('/homepage/{type}/{am}',[HomeController::class,'TeacherHome'])->name('thehome');

Route::get('/home', function(){
    if(!Auth::user()){
        return redirect()->route('myhome');
    }
    else {
        if (Auth::user()->role === 'Μαθητής') {
            return  redirect()->route("homepage",['type' =>'Προπτυχιακό' ,'am' => Auth::user()->am] );
        }
        if (Auth::user()->role === 'Καθηγητής') {
            return  redirect()->route("thehome",['type' =>'Προπτυχιακό' ,'am' => Auth::user()->id] );
        }
        if (Auth::user()->role === 'Διαχειριστής'){
            return redirect()->route('myhome');
        }
    }
})->name('home');
//
Route::get('/',function (){
    if(!Auth::user()){
        return redirect()->route('myhome');
    }
    else{
        if (Auth::user()->role === 'Μαθητής') {
            return  redirect()->route("homepage",['type' =>'Προπτυχιακό' ,'am' => Auth::user()->am] );
        }
        if (Auth::user()->role === 'Καθηγητής') {
            return  redirect()->route("thehome",['type' =>'Προπτυχιακό' ,'am' => Auth::user()->id] );
        }
        if (Auth::user()->role === 'Διαχειριστής'){
            return redirect()->route('myhome');
        }
    }

})->name('index');





Route::middleware('auth')->group(function(){

    Route::get('/profile/{id}/{column}',[UsersController::class, 'updateType']);
    Route::get('/updateprofile',[UsersController::class, 'updateInfo']);

//ADMIN SIDE OF THE APP - Admin's action to manage the users of this system
    Route::get('/users/{role}',[UsersController::class, 'showUsers'] )->name("users");
    Route::get('/filterUsers/{type}',[UsersController::class, 'filterUsers']);
    Route::get('/searchUser/{type}',[UsersController::class, 'searchUsers']);
    Route::get('/updateUser/{id}/{column}',[UsersController::class, 'updateType']);
    Route::get('/deleteUser',[UsersController::class, 'destroy']);

//ADMIN SIDE OF THE APP - Admin's action to manage the lessons
    Route::get('/lessons/{type}',[LessonController::class,'showLessons'])->name('lessons');
    Route::get('/updateAddLessons',[LessonController::class,'updateAddLessons'])->name('updateAddLessons');
    Route::get('/searchLesson/{type}',[LessonController::class,'searchLesson']);
    Route::get('/filterLessons/{type}', function ($type) {
        if (Auth::user()->role !== 'Μαθητής') {
            return app()->call([app(LessonController::class), 'filterLessons'], ['type' => $type]);
        } else {
            return app()->call([app(ParticipationController::class), 'filterLessons'], ['type' => $type, 'am' => Auth::user()->am]);
        }
    });

    Route::get('/deleteLesson',[LessonController::class,'destroy']);
    Route::get('/addLessons',[LessonController::class,'addLessonsByFile']);
    Route::get('/lessonArea/{l_id}',[LessonController::class,'LessonArea']);

    //PROFESSOR SIDE OF THE APP - Professor action to manage the lessons
    Route::get('/mylessons/{type}/{id}' ,[LessonController::class,'showLessonProfessor' ])->name('mylessons');

    //STUDENTS SIDE OF THE APP - Students action to manage the lessons
    Route::get('/allthelessons/{type}/{am}',[ParticipationController::class,'Participations'])->name('allthelessons');
    Route::get('/joinlesson',[ParticipationController::class,'join']);
    Route::get('/leavelesson',[ParticipationController::class,'leave']);

    Route::get('/participants/{l_id}/{title}/{name}',[ParticipationController::class,'Participants'])->name('Participants');
    Route::get('/updatedescription',[LessonController::class,'updateDescription']);
    Route::get('/exportparticipants',[ParticipationController::class,'ExrportParticipants']);
    Route::get('/importparticipants',[ParticipationController::class,'ImportParticipants']);
    Route::get('/searchparticipation/{l_id}/{title}/{name}',[ParticipationController::class,'searchparticipants']);

    Route::get('/searchforparticipation/{type}/{am}',[ParticipationController::class,'SearchForParticipation']);


    Route::get('/deleteNotification',[NotificationController::class, 'destroy']);
    Route::get('/createNotification',[NotificationController::class,'create_add']);
    Route::get('/ActivityTeams/{l_id}/{title}/{name}',[ActivityTeamController::class,'showTeamActivities'])->name('activityteams');
//Route::get('/ActivityTeam/{l_id}/{title}/{name}',[ActivityTeamController::class,'showTeamActivitiesforstudents'])->name('activityteam');

    Route::get('/createAddActivityTeam',[ActivityTeamController::class,'create_update']);
    Route::get('/deleteActivityTeam',[ActivityTeamController::class,'destroy']);

    Route::get('/showTheTeams/{l_id}/{title}/{name}/{at_id}',[ActivityTeamController::class,'showTheActivityTeam'])->name('showTheTeams');
    Route::get('/confirmteam',[ActivityTeamController::class,'confirmTheTeam']);
    Route::get('/rejectteam',[ActivityTeamController::class,'rejectTheTeam']);
    Route::get('/createteam',[ActivityTeamController::class,'createAteam']);
    Route::get('/deletemyteam',[ActivityTeamController::class,'deleteMyTeam']);
    Route::get('/exportteams',[ActivityTeamController::class,'ExrportTeams']);

    Route::get('/announcementsteams/{am}/{activity}',[AnouncementController::class,'announcmentsTeams'])->name('announcementsteams');
    Route::get('/deleteannouncement',[AnouncementController::class,'deletethereject']);
    Route::get('/finaliseteams',[ActivityTeamController::class,'theFinalTeams']);

    Route::get('/slotactivities/{l_id}/{title}/{name}',[ActivitySlotController::class,'showtheActivitiesSlots'])->name('slotactivities');
    Route::get('/createupdateslot',[ActivitySlotController::class,'create_update']);
    Route::get('/deleteslot',[ActivitySlotController::class,'destroy']);



// Example route that passes the $request and route parameters to the controller method
    Route::get('/showTheSlots/{l_id}/{title}/{name}/{as_id}/{date}', function ($l_id, $title, $name, $as_id,$date) {

        $requestData = ['role' => Auth::user()->role,'am'=>Auth::user()->am];
        $request = Request::create("/showTheSlots/$l_id/$title/$name/$as_id/$date", 'GET', $requestData);

        return app()->call(ActivitySlotController::class.'@showTheActivitySlot', ['request' => $request, 'l_id' => $l_id, 'title' => $title, 'name' => $name, 'as_id' => $as_id, 'date'=>$date]);
    })->name('showTheSlots');

    Route::get('/createslots',[ActivitySlotController::class,'createslots']);
    Route::get('/leavetheslot',[ActivitySlotController::class, 'deleteInTheSlot']);
    Route::get('/deletetheslot',[ActivitySlotController::class, 'deleteTheSlot']);
    Route::get('/importslots',[ActivitySlotController::class,'importslots']);
    Route::get('/exportslots',[ActivitySlotController::class,'exportslots']);
    Route::get('/jointoslot',[ActivitySlotController::class,'JoinInTheSlot']);
    Route::get('/announcementslots/{am}/{activity}',[AnouncementController::class,'announcmentsSlots'])->name('announcementslots');
    Route::get('/deletetheslotification',[AnouncementController::class,'deleteSlotNotification']);

    Route::get('/choosethemeactivities/{l_id}/{title}/{name}',[ActivityChooseThemeController::class,'index'])->name('choosethemeactivities');
    Route::get('/createupdatechoosetheme',[ActivityChooseThemeController::class,'create_update']);
    Route::get('/deletechoosetheme',[ActivityChooseThemeController::class,'destroy']);

    // Example route that passes the $request and route parameters to the controller method
    Route::get('/showTheThemes/{l_id}/{title}/{name}/{ct_id}', function ($l_id, $title, $name, $ct_id) {
        $requestData = ['role' => Auth::user()->role,'am'=>Auth::user()->am];
        $request = Request::create("/showTheThemes/$l_id/$title/$name/$ct_id", 'GET', $requestData);

        return app()->call(ActivityChooseThemeController::class.'@showTheActivityThemes', ['request' => $request, 'l_id' => $l_id, 'title' => $title, 'name' => $name, 'ct_id' => $ct_id]);
    })->name('showTheThemes');

    Route::get('/createupdatetheme',[ActivityChooseThemeController::class,'create_update_theme']);
    Route::get('/downloaddescription/{file}',[ActivityChooseThemeController::class,'downloadthemedescription']);
    Route::get('/deletetheme',[ActivityChooseThemeController::class,'deleteTheme']);
    Route::get('/jointheme',[ActivityChooseThemeController::class,'JoinTheTheme']);
    Route::get('/importthemes',[ActivityChooseThemeController::class,'importThemes']);
    Route::get('/exportthemes',[ActivityChooseThemeController::class,'exportThemes']);
    Route::get('/announcementc_themes/{am}/{activity}',[AnouncementController::class,'announcmentsChooseThemes'])->name('announcementc_themes');
    Route::get('/deletechooseannounsements',[AnouncementController::class,'deleteChooseNotification']);


    Route::get('/determinatethemeactivities/{l_id}/{title}/{name}',[ActivityDeterminateThemesController::class,'index'])->name('determinatethemeactivities');
    Route::get('/createupdatedeterminatetheme',[ActivityDeterminateThemesController::class,'create_update']);
    Route::get('/deletedeterminatetheme',[ActivityDeterminateThemesController::class,'destroy']);
    // Example route that passes the $request and route parameters to the controller method
    Route::get('/showTheJournals/{l_id}/{title}/{name}/{dt_id}', function ($l_id, $title, $name, $dt_id) {
        $requestData = ['role' => Auth::user()->role,'am'=>Auth::user()->am];
        $request = Request::create("/showTheJournals/$l_id/$title/$name/$dt_id", 'GET', $requestData);

        return app()->call(ActivityDeterminateThemesController::class.'@showTheActivityDetermination', ['request' => $request, 'l_id' => $l_id, 'title' => $title, 'name' => $name, 'dt_id' => $dt_id]);
    })->name('showTheJournals');
    Route::get('/createupdatejournal',[ActivityDeterminateThemesController::class,'create_update_journal']);
    Route::get('/deletejournal',[ActivityDeterminateThemesController::class,'deleteJournals']);
    Route::get('/addpaper',[ActivityDeterminateThemesController::class,'add_paper']);
    Route::get('/joinpaper',[ActivityDeterminateThemesController::class,'jointhepaper']);
    Route::get('/deletepaper',[ActivityDeterminateThemesController::class,'deletepaper']);
    Route::get('jointhejournal',[ActivityDeterminateThemesController::class,'jointheJournal']);
    Route::get('/confirm',[ActivityDeterminateThemesController::class,'Confirm']);
    Route::get('/reject',[ActivityDeterminateThemesController::class,'Reject']);
    Route::get('/exportjournals',[ActivityDeterminateThemesController::class,'exportJournals']);
    Route::get('/importjournals',[ActivityDeterminateThemesController::class,'importJournals']);
    Route::get('/announcementd_themes/{am}/{activity}',[AnouncementController::class,'announcmentsDeterminateThemes'])->name('announcementd_themes');
    Route::get('/delete_determinate',[AnouncementController::class,'deletedeterminateNotification']);

    Route::get('/votingactivities/{l_id}/{title}/{name}',[ActivityVotingController::class,'index'])->name('votingactivities');
    Route::get('/createupdatevoting',[ActivityVotingController::class,'create_update']);
    Route::get('/deletevoting',[ActivityVotingController::class,'destroy']);
    Route::get('/showTheVoting/{l_id}/{title}/{name}/{act_id}', function ($l_id, $title, $name, $act_id) {
        $requestData = ['role' => Auth::user()->role,'am'=>Auth::user()->am];
        $request = Request::create("/showTheVoting/$l_id/$title/$name/$act_id", 'GET', $requestData);

        return app()->call(ActivityVotingController::class.'@ShowtheVoting', ['request' => $request, 'l_id' => $l_id, 'title' => $title, 'name' => $name, 'act_id' => $act_id]);
    })->name('showTheVoting');
    Route::get('/createupdatequestion',[ActivityVotingController::class,'create_update_questions']);
    Route::get('/deletequestion',[ActivityVotingController::class,'deleteQuestion']);
    Route::get('/deleteanswer',[ActivityVotingController::class,'DeleteAnswer']);
    Route::get('/addanswers',[ActivityVotingController::class,'addAnswers']);
    Route::get('/vote',[ActivityVotingController::class,'vote']);
    Route::get('/exportvotes',[ActivityVotingController::class,'exportVotes']);



    Route::get('/quizactivities/{l_id}/{title}/{name}', function ($l_id, $title, $name) {
        $requestData = ['role' => Auth::user()->role,'am'=>Auth::user()->am];
        $request = Request::create("/quizactivities/$l_id/$title/$name", 'GET', $requestData);

        return app()->call(ActivityQuizController::class.'@index', ['request' => $request, 'l_id' => $l_id, 'title' => $title, 'name' => $name]);
    })->name('quizactivities');
//    Route::get('/quizactivities/{l_id}/{title}/{name}',[ActivityQuizController::class,'index'])->name('quizactivities');
    Route::get('/createupdatequiz',[ActivityQuizController::class,'create_update']);
    Route::get('/deletequiz',[ActivityQuizController::class,'destroy']);
    Route::get('/showTheQuiz/{l_id}/{title}/{name}/{act_id}', function ($l_id, $title, $name, $act_id,Request $request) {
        $requestData = ['role' => Auth::user()->role,'am'=>Auth::user()->am];
        if ($request->has('continue')) {
            $requestData['continue'] = $request->input('continue');
        }
        if ($request->has('tryid')) {
            $requestData['tryid'] = $request->input('tryid');
        }
        $request = Request::create("/showTheQuiz/$l_id/$title/$name/$act_id", 'GET', $requestData);

        return app()->call(ActivityQuizController::class.'@showTheQuiz', ['request' => $request, 'l_id' => $l_id, 'title' => $title, 'name' => $name, 'act_id' => $act_id]);
    })->name('showTheQuiz');

//    Route::get('/getthequiztry/{l_id}/{title}/{name}/{act_id}/{try_id}',[ActivityQuizController::class,'showAtry']);

    Route::get('/createupdatequizquestions',[ActivityQuizController::class,'create_update_questions']);
    Route::get('/deleteqquestion',[ActivityQuizController::class,'deleteQuestion']);
    Route::get('/deleteqanswer',[ActivityQuizController::class,'DeleteAnswer']);
    Route::get('/getqanswers',[ActivityQuizController::class,'addAnswers']);
    Route::get('/deliveranswers',[ActivityQuizController::class,'answerOfTheQuiz']);
    Route::get('/autosave',[ActivityQuizController::class,'AutoSaveTest']);
    Route::get('/quizparticipation/{act_id}/{l_id}/{title}/{name}',[QuizTriesController::class,'QuizParticipation'])->name('quizparticipation');
    Route::get('/choises',[QuizTriesController::class,'studentQuiz']);

    Route::get('/gradequiz',[QuizTriesController::class,'gradeQuiz']);
    Route::get('/exportquiz',[QuizTriesController::class,'exportResults']);
    Route::get('/searchquizparticipation/{act_id}/{l_id}/{title}/{name}',[QuizTriesController::class,'searchQuizParticipation']);

    Route::get('/participationCheck',[ParticipationController::class,'participationCheck']);
    Route::get('/greenthebell',[AnouncementController::class,'greenthebell']);
});


