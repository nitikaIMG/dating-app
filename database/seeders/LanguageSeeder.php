<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
Use App\Models\Language;
use Illuminate\Support\Facades\DB;
 


class LanguageSeeder extends Seeder
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
                'name' => 'Hindi',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'English',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Arabic',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Panjabi',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Gujrati',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Rajsthani',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Marati',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Tamil',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        DB::table('languages')->insert($data);
    }
}
