<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'admin',
            'email' => 'admin@gmail.com',
            
            'password' => '$2y$10$kMioMENJ2aubGxqWzB9UtOdbxed9Siuvb0dLy60Xo58KIDxG5rdT2', // 12345678
        ]);
    }
}
