<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Workout;
use Illuminate\Support\Facades\DB;

class WorkoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data =[
            [ 
                    'name' => 'Every day',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Often',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Sometimes',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Never',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ];
            DB::table('workouts')->insert($data);
    }
}
