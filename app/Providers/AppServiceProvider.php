<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\LikeProfile;
use App\Models\{Drink, Pet, Passion, RelationshipGoals, RelationshipType, Dietary, Smoke, SleepingHabit, SexualOrientation
, ReceiveLove, PersonalityType, Zodiac, Language, Children, Vaccine, Workout, EducationLevel};
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        #queries
        #get total users
        $total_user = User::where('id', '!=', '1')->get();
        $total_user_male = User::where('gender', '0')->get();
        $total_user_female = User::where('gender','1')->get();
        $total_user_other = User::where('gender','2')->get();
        $total_active_users = User::where('active_device_id','1')->get();
        $active_users = User::where('active_device_id','1')->with('UserInfo')->paginate('3');
        # Top Rated Profiles basis of likes
        $mainArray = [];
        $new = [];
        $getusers = LikeProfile::where('like_status','1')->get();
        
        if (!$getusers->isEmpty()) {
            $groupedUsers = $getusers->groupBy('liked_user_id');
            foreach ($groupedUsers as $likedUserId => $users) {
                $new[] = User::find($likedUserId);
            }
        }
        #basic user info
        $getAllpet = Pet::where('status',1)->get(); 
        $getAlleducation = EducationLevel::where('status',1)->get(); 
        $getAlldrinks = Drink::where('status',1)->get(); 
        $getAllsmoke = Smoke::where('status',1)->get(); 
        $getAlldietary = Dietary::where('status',1)->get(); 
        $getAlllang = Language::where('status',1)->get(); 
        $getAllrelation_type = RelationshipType::where('status',1)->get(); 
        $getAllrelation_goal = RelationshipGoals::where('status',1)->get(); 
        $getAllsleeping_habits = SleepingHabit::where('status',1)->get(); 
        $getAllrecive_love = ReceiveLove::where('status',1)->get(); 
        $getAllpersonality_type = PersonalityType::where('status',1)->get(); 
        $getAllsexual = SexualOrientation::where('status',1)->get(); 
        $getAllpassion = Passion::where('status',1)->get(); 
        $getAllvaccine = Vaccine::where('status',1)->get(); 
        $getAllzodiac = Zodiac::where('status',1)->get(); 
        $getAllworkout = Workout::where('status',1)->get(); 
        $getAllchildren = Children::where('status',1)->get();


        #return 
        view()->share('total_user', $total_user);
        view()->share('total_user_male', $total_user_male);
        view()->share('total_user_female', $total_user_female);
        view()->share('total_user_other', $total_user_other);
        view()->share('total_active_users', $total_active_users);
        view()->share('active_users', $active_users);
        view()->share('new', $new);

        #user basic info return 
        view()->share('all_pet', $getAllpet);
        view()->share('all_drinks', $getAlldrinks);
        view()->share('all_smoke', $getAllsmoke);
        view()->share('all_dietry', $getAlldietary);
        view()->share('all_relationship_type', $getAllrelation_type);
        view()->share('all_sleeping_habits', $getAllsleeping_habits);
        view()->share('all_receive_love', $getAllrecive_love);
        view()->share('all_personality_type', $getAllpersonality_type);
        view()->share('all_sexual_orientation', $getAllsexual);
        view()->share('all_passion', $getAllpassion);
        view()->share('all_vaccine', $getAllvaccine);
        view()->share('all_zodiac', $getAllzodiac);
        view()->share('all_workout', $getAllworkout);
        view()->share('all_children', $getAllchildren);
        view()->share('all_relationship_goal', $getAllrelation_goal);
        view()->share('all_education', $getAlleducation);
        view()->share('all_language', $getAlllang);
    }
}
