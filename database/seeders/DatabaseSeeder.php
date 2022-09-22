<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
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
        // \App\Models\User::factory(10)->create();
        // \App\Models\Core\Question::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@test.dev',
        ]);

        \App\Models\User::factory()->count(10)->create();

        for($i = 0; $i < 100; $i++)
        {
            \App\Models\Core\Question::factory()
                ->has(\App\Models\Core\Waitlister::factory()
                    ->count(random_int(1, 10))
                )
                ->has(\App\Models\Core\Answer::factory()
                    ->count(random_int(0, 1))
                    ->state(new Sequence(
                        fn ($sequence) => ['user_id' => User::all()->random()->id],
                    ))
                )
                ->create();
        }
    }
}
