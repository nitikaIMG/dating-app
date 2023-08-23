<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Explore;
use Illuminate\Support\Facades\DB;

class ExploreSeeder extends Seeder
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
                'name' => 'Looking for love',
                'status'=>1,
                'thumbnail' => 'image not added by admin',

                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Free tonight ',
                'status'=>1,
                'thumbnail' => 'image not added by admin',

                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Let\'s be friends',
                'status'=>1,
                'thumbnail' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Coffee date ',
                'status'=>1,
                'thumbnail' => 'image not added by admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Date night ',
                'status'=>1,
                'thumbnail' => 'image not added by admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            
            
        ];
        DB::table('explores')->insert($data);
    }
}
