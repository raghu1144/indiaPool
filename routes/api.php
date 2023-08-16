<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userRegister\registrationController;
use App\Http\Controllers\Userlogin\loginController;
use App\Http\Controllers\Selectuser\alluserController;
use App\Http\Controllers\Blog\blogController;
use App\Http\Controllers\Admin\adminLoginController;
use App\Http\Controllers\Contact\contactusController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('loginadmin')->group(function(){
    Route::post('admin',[adminLoginController::class, 'adminlog']);
});

Route::prefix('newregister')->group(function(){
    Route::post('register',[registrationController::class, 'storeUser']);
    Route::post('otp',[registrationController::class, 'otpVerify']);
    Route::post('password',[registrationController::class, 'setPassword']);
});

Route::prefix('userlogin')->group(function(){
    Route::post('login',[loginController::class, 'loginUser']);
});

Route::prefix('select')->group(function(){
    Route::get('getdata', [alluserController::class, 'seletDataAll']);
});

Route::prefix('blog')->group(function(){
    Route::post('blogpost', [blogController::class, 'bologpost']);
    Route::get('blogget', [blogController::class, 'bologGet']);
    Route::get('blogoption/{blogid}', [blogController::class, 'blogoptionget']);
    Route::get('bloggetbyid/{blogid}', [blogController::class, 'blogGetById']);
});


Route::prefix('pole')->group(function(){
    Route::post('answer', [blogController::class, 'poleAnswer']);
});

Route::prefix('contactform')->group(function(){
    Route::post('contactdetails', [contactusController::class, 'contact']);
    Route::get('getcontactdetails', [contactusController::class, 'getcontact']);
});