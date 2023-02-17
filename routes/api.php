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

    Route::apiResource('users', UserController::class); //filled user_detail and show list

    Route::controller(UserController::class)->group(function () {
        Route::post('agreerules', 'agreerules'); # Rules screen
        Route::post('editProfile', 'editProfile'); # Edit Profile
        Route::get('detailofuser/{id}', 'detailofuser'); # Show all the details of user by id
    });
});

# Social Login
Route::controller(AuthController::class)->group(function () {
    Route::post('social_login', 'social_login');
});
