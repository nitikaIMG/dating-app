<?php
use App\Models\User;
use App\Models\LikeProfile;

if(!function_exists('total_user')){
    function total_user(){
        $users = User::all();
        $total  = Count($users);
        return $total;
    }
}
if(!function_exists('total_user_male')){
    function total_user_male(){
        $users = User::where('gender','0')->get();
        $total  = Count($users);
        return $total;
    }
}
if(!function_exists('total_user_female')){
    function total_user_female(){
        $users = User::where('gender','1')->get();
        $total  = Count($users);
        return $total;
    }
}
if(!function_exists('total_user_other')){
    function total_user_other(){
        $users = User::where('gender','2')->get();
        $total  = Count($users);
        return $total;
    }
}
if(!function_exists('active_total_users')){
    function active_total_users(){
        $users = User::where('active_device_id','1')->get();
        $total  = Count($users);
        return $total;
    }
}
if(!function_exists('active_users')){
    function active_users(){
        $users = User::where('active_device_id','1')->with('UserInfo')->get();
        return $users;
    }
}
if(!function_exists('top_rated_profile')){
    function top_rated_profile(){
            $mainArray = [];
            $new = [];
            $getusers = LikeProfile::where('like_status','1')->get();
            
            if (!$getusers->isEmpty()) {
                $groupedUsers = $getusers->groupBy('liked_user_id');
                foreach ($groupedUsers as $likedUserId => $users) {
                    $new[] = User::find($likedUserId);
                }
            }
            return $new;
    }
}
?>