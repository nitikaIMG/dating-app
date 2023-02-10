<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\apicontroller;

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

Route::post('auth/register',[apicontroller::class,'register']);
Route::post('auth/login',[apicontroller::class,'login']);
Route::post('forgotpassword',[apicontroller::class,'forgot']);
Route::post('resetpassword',[apicontroller::class,'resetpassword']);
// Route::get('logout',[apicontroller::class,'logout']);


// Route::get('auth/user',[apicontroller::class,'user'])->middleware('auth:sanctum');

