<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Passion;
 

class PassionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = 
        [
            [ 
                'name' => '90s Kid',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Harry Potter',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'SoundCloud',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Spa',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Self Care',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Heavy Metal',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Ludo',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Maggi',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Hot Yoga',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Love',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Friendship',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        DB::table('passions')->insert($data);
    }
}
