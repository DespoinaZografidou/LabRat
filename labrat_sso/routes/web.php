<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
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

Route::get('/import',[RegisterController::class, 'import'])->name('import');

Route::get('/',[PagesController::class, 'index'])->name('index');
Route::get('/register',[RegisterController::class,'register']);
Route::get('/resetcode/{token}/{mail}',[ForgotPasswordController::class,'showTheResetForm']);


Auth::routes();


Route::get('/home', [PagesController::class, 'index'])->name('home');
Route::post('/different-account', [App\Http\Controllers\HomeController::class, 'getDifferentAccount'])->name('different-account');
