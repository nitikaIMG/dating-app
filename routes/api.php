<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RuleController;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\MediaController;

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
    Route::post('verifyotp', 'verifyOtp'); //verifyotp
    Route::post('loginviamobile', 'loginviamobile'); //login phone no
    Route::post('forgot_password', 'forgot_password'); //Forget Password
    Route::post('change_password', 'change_password'); //Change Password
    Route::post('emailverification', 'emailverification'); //Verify Email


});

Route::middleware('jwt.verify')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout'); //logout
    });


    // Route::controller(UserController::class)->group(function () {
        // Route::post('detailofuser/{id}', 'detailofuser'); # Show all the details of user by id
    // });

    Route::apiResource('users', UserController::class); # filled user_detail and show list
    Route::apiResource('rules', RuleController::class); # Rules Controller
    Route::apiResource('userprofile', UserProfileController::class); # User Profile Controller 
    Route::apiResource('media', MediaController::class); # User Media Controller 
});

# Social Login
Route::controller(AuthController::class)->group(function () {
    Route::post('social_login', 'social_login');
});
