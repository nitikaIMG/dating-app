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
use App\Http\Controllers\admin\VaccineController;
use App\Http\Controllers\admin\PetsController;
use App\Http\Controllers\admin\DrinkController;
use App\Http\Controllers\admin\WorkoutController;
use App\Http\Controllers\admin\SmokeController;
use App\Http\Controllers\admin\SleepingHabitController;
use App\Http\Controllers\admin\DietaryController;
use App\Http\Controllers\admin\SexualOrientationController;


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


// Route::get('/',[HomeController::class, 'index'])->name('dashboard');
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
    Route::post('explore/activeORdeactive',[ExploreController::class, 'ExploreActivedeactive'])->name('explore.activedeactive');
    ;
    
    #subscription
    Route::resource('subscription', SubscriptionController::class);
    Route::post('subscription/status/update',[SubscriptionController::class, 'subscripptionstatus'])->name('subscripptionstatus');

    #basics 
    #zodiac 
    Route::resource('zodiac', ZodiacController::class);
    Route::delete('zodiacs/delete',[ZodiacController::class, 'deleterecord'])->name('zodiac.deleterecord');
    Route::post('zodiac/status/update',[ZodiacController::class, 'updateuserstatus'])->name('zodiacupdate');

    #education 
    Route::resource('education', EducationLevelController::class);
    Route::delete('education_level/delete',[EducationLevelController::class, 'deleterecord'])->name('education.deleterecord');
    Route::post('education/status/update',[EducationLevelController::class, 'updateuserstatus'])->name('educationstatus');
    
    #personality type
    Route::resource('personality', PersonalityTypeController::class);
    Route::delete('personality_type/delete',[PersonalityTypeController::class, 'deleterecord'])->name('personality.deleterecord');
    Route::post('personality/updateuserstatus',[PersonalityTypeController::class, 'updateuserstatus'])->name('personalitystatus');

    #personality type
    Route::resource('communication', CommunicationStyleController::class);
    Route::delete('communication_style/delete',[CommunicationStyleController::class, 'deleterecord'])->name('communication.deleterecord');
    Route::post('communication/updateuserstatus',[CommunicationStyleController::class, 'updateuserstatus'])->name('communicationstatus');

    #Children want or not 
    Route::resource('children', ChildrenController::class);
    Route::delete('child/delete',[ChildrenController::class, 'deleterecord'])->name('children.deleterecord');
    Route::post('children/updateuserstatus',[ChildrenController::class, 'updateuserstatus'])->name('childrenstatus');

    #receivelove 
    Route::resource('receivelove', ReceiveLoveController::class);
    Route::delete('receive_love/delete',[ReceiveLoveController::class, 'deleterecord'])->name('receivelove.deleterecord');
    Route::post('receivelove/updateuserstatus',[ReceiveLoveController::class, 'updateuserstatus'])->name('receivelovestatus');

     #vaccines 
     Route::resource('vaccine', VaccineController::class);
     Route::delete('vaccin/delete',[VaccineController::class, 'deleterecord'])->name('vaccine.deleterecord');
     Route::post('vaccine/updateuserstatus',[VaccineController::class, 'updateuserstatus'])->name('vaccinestatus');

    #pets 
    Route::resource('pet', PetsController::class);
    Route::delete('pets/delete',[PetsController::class, 'deleterecord'])->name('pet.deleterecord');
    Route::post('pet/updateuserstatus',[PetsController::class, 'updateuserstatus'])->name('petstatus');
    
    #drinking 
    Route::resource('drinking', DrinkController::class);
    Route::delete('drink/delete',[DrinkController::class, 'deleterecord'])->name('drinking.deleterecord');
    Route::post('drinking/updateuserstatus',[DrinkController::class, 'updateuserstatus'])->name('drinkingstatus');

    #workout 
    Route::resource('workout', WorkoutController::class);
    Route::delete('workouts/delete',[WorkoutController::class, 'deleterecord'])->name('workout.deleterecord');
    Route::post('workout/updateuserstatus',[WorkoutController::class, 'updateuserstatus'])->name('workoutstatus');

    #sleepinghabits 
    Route::resource('sleepinghabit', SleepingHabitController::class);
    Route::delete('sleeping/delete',[SleepingHabitController::class, 'deleterecord'])->name('sleepinghabit.deleterecord');
    Route::post('sleepinghabit/updateuserstatus',[SleepingHabitController::class, 'updateuserstatus'])->name('sleepinghabitstatus');

    #smoke 
    Route::resource('smoke', SmokeController::class);
    Route::delete('smokes/delete',[SmokeController::class, 'deleterecord'])->name('smoke.deleterecord');
    Route::post('smoke/updateuserstatus',[SmokeController::class, 'updateuserstatus'])->name('smokestatus');

    #dietary 
    Route::resource('dietary', DietaryController::class);
    Route::delete('diet/delete',[DietaryController::class, 'deleterecord'])->name('dietary.deleterecord');
    Route::post('dietary/updateuserstatus',[DietaryController::class, 'updateuserstatus'])->name('dietarystatus');

    #dietary 
    Route::resource('sexualorientation', SexualOrientationController::class);
    Route::delete('sexualorientations/delete',[SexualOrientationController::class, 'deleterecord'])->name('sexualorientation.deleterecord');
    Route::post('sexualorientation/update/status',[SexualOrientationController::class, 'updateuserstatus'])->name('sexualorientationstatus');
 
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
