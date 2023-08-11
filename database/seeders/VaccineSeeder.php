<?php

namespace Database\Seeders;

use App\Models\Vaccine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class VaccineSeeder extends Seeder
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
                'name' => 'Vaccinated',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Unvaccinated',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 
                'name' => 'Prefer not to say',
                'status'=>1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        DB::table('vaccines')->insert($data);
    }
}
