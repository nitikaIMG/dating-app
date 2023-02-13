<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Apicontroller;
use App\Http\Controllers\Api\UserController;
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
    Route::post('register', 'registerUser');
});

Route::middleware('jwt.verify')->group( function(){
    Route::controller(AuthController::class)->group(function () {
    });
});

Route::Resource('users', UserController::class);
// Route::get('auth/user',[Apicontroller::class,'user'])->middleware('auth:sanctum');
