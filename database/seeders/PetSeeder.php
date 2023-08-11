<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pet;
use Illuminate\Support\Facades\DB;

class PetSeeder extends Seeder
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
                'name' => 'Dog',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Cat',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Amphibian',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Reptile',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Bird',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Fish',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Don\'t have, but love',
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
            [ 
                'name' => 'Turtle',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Hamster',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Rabbit',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Pet free',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'All the pets',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],   
            [ 
                'name' => 'Want a pet',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],     [ 
                'name' => 'Allergic to pets',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        DB::table('pets')->insert($data);
    }
}
