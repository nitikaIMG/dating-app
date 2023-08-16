<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RelationshipGoals;
use Illuminate\Support\Facades\DB;

class RelationshipGoalSeeder extends Seeder
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
                    'name' => 'Open to exploring',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Monogamy',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Polyamory',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ];
            DB::table('relationship_goals')->insert($data);
    }
}
