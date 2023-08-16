<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\LikeProfile;
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
        $active_users = User::where('active_device_id','1')->with('UserInfo')->paginate('2');
       
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

      

        #return 
        view()->share('total_user', $total_user);
        view()->share('total_user_male', $total_user_male);
        view()->share('total_user_female', $total_user_female);
        view()->share('total_user_other', $total_user_other);
        view()->share('total_active_users', $total_active_users);
        view()->share('active_users', $active_users);
        view()->share('new', $new);
    }
}
