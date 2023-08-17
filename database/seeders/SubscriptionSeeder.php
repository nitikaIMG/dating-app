<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\DB;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=[
            [ 
                'plan_name' => 'Basic Plan',
                'price' => '450',
                'unlimited_likes'=>1,
                'unlimited_rewinds'=>1,
                'see_who_likes_you'=>1,
                'priority_likes'=>0,
                'free_boost_per_month_1'=>0,
                'free_super_likes_per_week_5'=>0,
                'message_before_matching'=>0,
                'passport'=>1,
                'top_pics'=>0,
                'control_your_profile'=>1,
                'control_who_sees_you'=>1,
                'control_who_you_see'=>1,
                'hide_ads'=>1,
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'plan_name' => 'Gold Plan',
                'price' => '650',
                'unlimited_likes'=>1,
                'unlimited_rewinds'=>1,
                'see_who_likes_you'=>1,
                'priority_likes'=>0,
                'free_boost_per_month_1'=>1,
                'free_super_likes_per_week_5'=>1,
                'message_before_matching'=>1,
                'passport'=>1,
                'top_pics'=>1,
                'control_your_profile'=>1,
                'control_who_sees_you'=>1,
                'control_who_you_see'=>1,
                'hide_ads'=>1,
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'plan_name' => 'Platinum Plan',
                'price' => '1050',
                'unlimited_likes'=>1,
                'unlimited_rewinds'=>1,
                'see_who_likes_you'=>1,
                'priority_likes'=>1,
                'free_boost_per_month_1'=>1,
                'free_super_likes_per_week_5'=>1,
                'message_before_matching'=>1,
                'passport'=>1,
                'top_pics'=>1,
                'control_your_profile'=>1,
                'control_who_sees_you'=>1,
                'control_who_you_see'=>1,
                'hide_ads'=>1,
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        DB::table('subscription_plans')->insert($data);
    }
}
