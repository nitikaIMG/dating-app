<?php

namespace Database\Seeders;

use App\Models\Zodiac;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZodiacSeeder extends Seeder
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
                'name' => 'Aries',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Taurus',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Gemini',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Cancer',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Leo',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Vigro',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Libra',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Scorpius',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Sagittarius',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Capricornus',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Aquarius',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Pisces',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        DB::table('zodiacs')->insert($data);
    }
}
