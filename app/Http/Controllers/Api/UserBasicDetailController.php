<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Drink, Pet, Passion, RelationshipGoals, RelationshipType, Dietary, Smoke, SleepingHabit, SexualOrientation
    , ReceiveLove, PersonalityType, Zodiac, Language, Children, Vaccine, Workout, EducationLevel};
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth as JWTAuth;
use App\Api\ApiResponse;
use Auth;
use DB;
use App\Providers\AppServiceProvider;


class UserBasicDetailController extends Controller
{
    #drinks
    public function drink(Request $request)
    {
        try {
            DB::beginTransaction();
                $all_drinks =  Drink::where('status',1)->get(); 
                return ApiResponse::ok(
                    'List Of Drinks',
                    $all_drinks
                );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error(
                'No Drink',
            );
        }
    }

    #pet
    public function pet(Request $request)
    {
        try {
            DB::beginTransaction();
                $all_pets =  Pet::where('status',1)->get(); 
                return ApiResponse::ok(
                    'List Of Pet',
                    $all_pets
                );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error(
                'No Drink',
            );
        }
    }


    #smoke
    public function smoke(Request $request)
    {
        try {
            DB::beginTransaction();
                $all_smokes =  Smoke::where('status',1)->get(); 
                return ApiResponse::ok(
                    'List Of smoke',
                    $all_smoke
                );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error(
                'No Smoke',
            );
        }
    }

    #education
    public function education(Request $request)
    {
        try {
            DB::beginTransaction();
                $all_educations =  EducationLevel::where('status',1)->get(); 
                return ApiResponse::ok(
                    'List Of education',
                    $all_educations
                );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error(
                'No education',
            );
        }
    }

    #dietary
    public function dietary(Request $request)
    {
        try {
            DB::beginTransaction();
                $all_dietaries =  Dietary::where('status',1)->get(); 
                return ApiResponse::ok(
                    'List Of dietary',
                    $all_dietaries
                );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error(
                'No dietary',
            );
        }
    }

    #language
    public function language(Request $request)
    {
        try {
            DB::beginTransaction();
                $all_language =  Language::where('status',1)->get(); 
                return ApiResponse::ok(
                    'List Of Language',
                    $all_language
                );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error(
                'No Language',
            );
        }
    }

    
    #relation_type
    public function relation_type(Request $request)
    {
        try {
            DB::beginTransaction();
                $all_type =  Language::where('status',1)->get(); 
                return ApiResponse::ok(
                    'List Of Relationship Type',
                    $all_type
                );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error(
                'No  Relationship Type',
            );
        }
    }

    # Relationship goal
    public function relation_goal(Request $request)
    {
        try {
            DB::beginTransaction();
                $all_relation_goal =  RelationshipGoals::where('status',1)->get(); 
                return ApiResponse::ok(
                    'List Of  Relationship Goal',
                    $all_relation_goal
                );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error(
                'No  Relationship Goal',
            );
        }
    }

    #SleepingHabit
    public function SleepingHabit(Request $request)
    {
        try {
            DB::beginTransaction();
                $all_SleepingHabit =  SleepingHabit::where('status',1)->get(); 
                return ApiResponse::ok(
                    'List Of  SleepingHabit',
                    $all_SleepingHabit
                );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error(
                'No  Sleeping Habit',
            );
        }
    }

    #ReceiveLove
    public function ReceiveLove(Request $request)
    {
        try {
            DB::beginTransaction();
                $all_ReceiveLove =  ReceiveLove::where('status',1)->get(); 
                return ApiResponse::ok(
                    'List Of  Receive Love',
                    $all_ReceiveLove
                );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error(
                'No  Sleeping Habit',
            );
        }
    }

    #all_personality_type
    public function personality_type(Request $request)
    {
        try {
            DB::beginTransaction();
                $all_personality_type =  PersonalityType::where('status',1)->get(); 
                return ApiResponse::ok(
                    'List Of  Personality Type',
                    $all_personality_type
                );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error(
                'No Personality Type',
            );
        }
    }

    #all_sexual_orientation
    public function all_sexual_orientation(Request $request)
    {
        try {
            DB::beginTransaction();
                $all_sexual_orientation =  SexualOrientation::where('status',1)->get(); 
                return ApiResponse::ok(
                    'List Of  SexualOrientation',
                    $all_sexual_orientation
                );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error(
                'No SexualOrientation',
            );
        }
    }

    #passion
    public function passion(Request $request)
    {
        try {
            DB::beginTransaction();
                $all_passion =  Passion::where('status',1)->get(); 
                return ApiResponse::ok(
                    'List Of  Passion',
                    $all_passion
                );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error(
                'No Passion',
            );
        }
    }

    #workout
    public function workout(Request $request)
    {
        try {
            DB::beginTransaction();
                $all_workout =  Workout::where('status',1)->get(); 
                return ApiResponse::ok(
                    'List Of  Workouts',
                    $all_workout
                );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error(
                'No Workouts',
            );
        }
    }

    #vaccine
    public function vaccine(Request $request)
    {
        try {
            DB::beginTransaction();
                $all_vaccine =  Vaccine::where('status',1)->get(); 
                return ApiResponse::ok(
                    'List Of  Vaccine',
                    $all_vaccine
                );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error(
                'No Vaccine',
            );
        }
    }

    #zodiac
    public function zodiac(Request $request)
    {
        try {
            DB::beginTransaction();
                $all_zodiac =  Zodiac::where('status',1)->get(); 
                return ApiResponse::ok(
                    'List Of  Zodiac',
                    $all_zodiac
                );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error(
                'No Zodiac',
            );
        }
    }

    #children
    public function children(Request $request)
    {
        try {
            DB::beginTransaction();
                $all_children =  Children::where('status',1)->get(); 
                return ApiResponse::ok(
                    'List Of  children',
                    $all_children
                );
        } catch (\Exception $e) {
            DB::rollBack();
            return ApiResponse::error(
                'No children',
            );
        }
    }
}
