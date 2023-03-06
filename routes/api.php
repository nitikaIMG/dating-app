<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RuleController;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\FilterController;
use App\Http\Controllers\Api\RequestApiController;
use App\Http\Controllers\Api\FavouritesProfileApiController;
use App\Http\Controllers\Api\LikeProfileController;
use App\Http\Controllers\Api\MatchController;
use App\Http\Controllers\Api\ProfileControlController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SettingController;

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
    // Route::post('register', 'registerUser'); # registration
    Route::post('registeruser', 'registerUserViaMobile'); # registration with mobile no
    Route::post('resendOtp', 'resendOtp'); # resendotp
    Route::post('verifyotp', 'verifyOtp'); # verifyotp
    Route::post('loginviamobile', 'loginviamobile'); # login phone no
    Route::post('forgot_password', 'forgot_password'); # Forget Password
    Route::post('change_password', 'change_password'); # Change Password
    Route::post('emailverification', 'emailverification'); # Verify Email


});

Route::middleware('jwt.verify')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout'); # logout
    });
    Route::controller(FilterController::class)->group(function () {
        Route::post('filterProfilePrivacy', 'filterProfilePrivacybyGender'); # filter Profile Privacy by Gender
        Route::post('filterviaage', 'filterProfilePrivacybyage'); # filter Profile Privacy by age
        Route::post('nearbyusers', 'filterProfilenearbyusers'); # filter Profile Privacy near by users
        Route::post('addLocation', 'addLocation'); # addLocation
        Route::get('activeusers', 'activeusers'); # recent active users 
    });

    Route::controller(SettingController::class)->group(function () {
        Route::post('accountsetting', 'accountsetting'); # account setting show and update phone no. 
        Route::post('globaluser', 'globaluser'); # global (if enable then user can see nearby and around the world users list)
        Route::post('blockcontact', 'blockcontact'); # block the users
        Route::get('blockcontactlist', 'blockcontactlist'); # Showing the list of block users
        Route::get('profilecompletnesper', 'profilecompletnesper'); # profile completnes percentage
        Route::post('showsubscription', 'showsubscription'); # show subscription plans
    });

    Route::get('showAllRequest', [RequestApiController::class, 'showAllRequest']); #show all request (all matched and not matched request on the basis of auth user)



    Route::apiResource('users', UserController::class); # filled user_detail and show list
    Route::apiResource('rules', RuleController::class); # Rules Controller
    Route::apiResource('userprofile', UserProfileController::class); # User Profile Controller 
    Route::apiResource('media', MediaController::class); # User Media Controller
    Route::apiResource('requestapprove', RequestApiController::class);
    Route::apiResource('postunfavourites', FavouritesProfileApiController::class);
    Route::apiResource('likeunlikeuser', LikeProfileController::class);
    Route::apiResource('profile', ProfileController::class); # Profile Controller for other use
    Route::apiResource('profilecontrol', ProfileControlController::class); # profile control api
    Route::apiResource('match', MatchController::class); # match found list
});

# Social Login
Route::controller(AuthController::class)->group(function () {
    Route::post('social_login', 'social_login');
});
