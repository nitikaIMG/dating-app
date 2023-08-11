<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SexualOrientation;
use Illuminate\Support\Facades\DB;

class SexualOrientationSeeder extends Seeder
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
                    'name' => 'Straight',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Gay',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Lesbian',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Bisexuale',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Asexuale',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Demisexuale',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Pansexuale',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Queer',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Bicurious',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Aromantic',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ];
            DB::table('sexual_orientations')->insert($data);
    }
}
