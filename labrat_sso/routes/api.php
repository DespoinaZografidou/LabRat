<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api', 'scope:view-user')->get('/user', function (Request $request) {
    return $request->user();
});


// routes/web.php or routes/api.php
Route::middleware('auth:api')->get('/deleteuser/{email}',function (Request $request,$email){
    $user=DB::table('users')->where('email','=',$email)->first();
    if($user){
        DB::table('users')->where('email', $email)->delete();
        return response()->json([
            'message' => 'The user was deleted successfully'
        ]);
    }
    else{
        return response()->json([
            'message' => 'The user was not deleted successfully',
             'status'=>404
        ]);
    }



});



Route::middleware('auth:api')->get('/logmeout', function (Request $request) {
    $user = $request->user();
    $accessToken = $user->token();
    DB::table('oauth_refresh_tokens')
    ->where("access_token_id", $accessToken->id)
    ->delete();
    $user->token()->delete();
    return response()->json([
        'message' => 'Revoked'
    ]);
});
