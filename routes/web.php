<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\ExploreController;
use App\Http\Controllers\admin\SubscriptionController;
use App\Http\Controllers\admin\ZodiacController;
use App\Http\Controllers\admin\EducationLevelController;
use App\Http\Controllers\admin\PersonalityTypeController;
use App\Http\Controllers\admin\CommunicationStyleController;
use App\Http\Controllers\admin\ChildrenController;
use App\Http\Controllers\admin\ReceiveLoveController;


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

    #basics 
    #zodiac 
    Route::resource('zodiac', ZodiacController::class);
    Route::delete('zodiac/delete',[ZodiacController::class, 'deleterecord'])->name('zodiac.deleterecord');

    #education 
    Route::resource('education', EducationLevelController::class);
    Route::delete('education_level/delete',[EducationLevelController::class, 'deleterecord'])->name('education.deleterecord');
    
    #personality type
    Route::resource('personality', PersonalityTypeController::class);
    Route::delete('personality_type/delete',[PersonalityTypeController::class, 'deleterecord'])->name('personality.deleterecord');

    #personality type
    Route::resource('communication', CommunicationStyleController::class);
    Route::delete('communication_style/delete',[CommunicationStyleController::class, 'deleterecord'])->name('communication.deleterecord');

    #Children want or not 
    Route::resource('children', ChildrenController::class);
    Route::delete('child/delete',[ChildrenController::class, 'deleterecord'])->name('children.deleterecord');

      #Children want or not 
      Route::resource('receivelove', ReceiveLoveController::class);
      Route::delete('receive_love/delete',[ReceiveLoveController::class, 'deleterecord'])->name('receivelove.deleterecord');
  




});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
