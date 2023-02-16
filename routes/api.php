<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;

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

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'registerUser'); //registration
    Route::post('resendOtp', 'resendOtp'); //resendotp
    Route::post('verifyotp', 'verifyOtp');
    Route::post('loginviamobile', 'loginviamobile'); //login phone no
    Route::post('forgot_password', 'forgot_password'); //Forget Password
    Route::post('change_password', 'change_password'); //Change Password
    Route::post('emailverification', 'emailverification'); //Verify Email
    // Route::apiResource('users', UserController::class);


});

Route::middleware('jwt.verify')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout'); //logout
    });
    Route::apiResource('users', UserController::class);
});

//  Social Login
Route::controller(AuthController::class)->group(function () {
    Route::post('social_login', 'social_login');
});
