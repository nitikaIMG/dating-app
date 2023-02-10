<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Apicontroller;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/register',[Apicontroller::class,'register']);
Route::post('auth/login',[Apicontroller::class,'login']);
Route::post('forgotpassword',[Apicontroller::class,'forgot']);

Route::Resource('users', UserController::class);
// Route::get('auth/user',[Apicontroller::class,'user'])->middleware('auth:sanctum');
