<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dietary;
use Illuminate\Support\Facades\DB;

class DietarySeeder extends Seeder
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
                    'name' => 'Vegan',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Vegetarian',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Pescatarian',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Kosher',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Halal',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Carnivore',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Onmivore',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Other',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ];
            DB::table('dietary_preference')->insert($data);
    }
}
