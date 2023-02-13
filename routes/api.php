<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\apicontroller;
use App\Http\Controllers\API\AuthController;

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
    Route::post('verifyotp', 'verifyotp');
    Route::post('loginwithmobile', 'loginwithmobile'); //login phone no
    
});

Route::middleware('jwt.verify')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        // Route::post('login', 'loginUser'); //login email password
        
        // Route::post('verifymobile', 'verifymobile');
        Route::post('logout', 'logout'); //logout

    });
});
