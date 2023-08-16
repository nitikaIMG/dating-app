<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RelationshipType;
use Illuminate\Support\Facades\DB;

class RelationshipTypeSeeder extends Seeder
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
                    'name' => 'Long-term partner',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Long-term, open to short',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Short-term, open to long',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Short-term fun',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'Still figuring it out',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [ 
                    'name' => 'New friends',
                    'status'=>1,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ];
            DB::table('relationship_types')->insert($data);
    }
}

