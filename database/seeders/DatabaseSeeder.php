<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(ZodiacSeeder::class);
        $this->call(EducationSeeder::class);
        $this->call(PersonalitySeeder::class);
        $this->call(CommunicationSeeder::class);
        $this->call(ChildernquestionSeeder::class);
        $this->call(LoveSeeder::class);
        $this->call(VaccineSeeder::class);
        $this->call(WorkoutSeeder::class);
        $this->call(DrinkSeeder::class);
        $this->call(DietarySeeder::class);
        $this->call(SmokeSeeder::class);
        $this->call(SleepingSeeder::class);
        $this->call(PetSeeder::class);
        $this->call(SexualOrientationSeeder::class);
        $this->call(RelationshipGoalSeeder::class);
        $this->call(RelationshipTypeSeeder::class);
        $this->call(LanguageSeederSeeder::class);
        $this->call(PassionSeederSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
