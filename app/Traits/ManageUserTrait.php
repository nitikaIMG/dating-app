<?php
namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Str;

trait ManageUserTrait
{
    public function getReferralCode($name){
        $subPart = substr($name,0,4).$this->randStr(4);

        if(User::where('refer_code','LIKE','%'.$subPart.'%')->exists()){
            $subPart =  $this->getReferralCode($name);
        }
        return strtoupper($subPart);
    }

    // This function will return a random
    // string of specified length
    public function randStr($no_of_char)
    {
    
        // String of all alphanumeric character
        $str = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    
        // Shuffle the $str_result and returns substring
        // of specified length
        return substr(str_shuffle($str), 
                        0, $no_of_char);
    }
    public function getUserByRefercode($refercode){
        $user = User::where('refer_code',$refercode)->first();
        if($user){
            return $user->id;
        }else{
            return 0;
        }
    }

    public function generateOTP(){
        return '123456';
    }

    
}