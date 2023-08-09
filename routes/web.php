<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\ExploreController;
use App\Http\Controllers\admin\SubscriptionController;


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


Route::get('/',[HomeController::class, 'index'])->name('dashboard');
Route::get('back/button',[HomeController::class, 'back'])->name('backbtn');

// Route::any('resetpassword',[apicontroller::class,'resetpassword']);


Route:: group(['middleware'=>'auth'],function(){
    #user controller
    Route::resource('users',UserController::class);
    Route::post('user/activeORdeactive',[UserController::class, 'UserActivedeactive'])->name('active.deactive');
    Route::post('user/updateuserstatus',[UserController::class, 'updateuserstatus'])->name('updateuserstatus');
    #explore
    Route::resource('explore',ExploreController::class);
    Route::post('explore/status',[ExploreController::class, 'updateexplorestatus'])->name('updateexplorestatus');
    Route::post('explore/activeORdeactive',[UserController::class, 'ExploreActivedeactive'])->name('active.deactive');
    
    #subscription
    Route::resource('subscription', SubscriptionController::class);
    Route::post('subscription/status/update',[SubscriptionController::class, 'subscripptionstatus'])->name('subscripptionstatus');


});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
