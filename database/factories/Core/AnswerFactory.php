<?php

namespace Database\Factories\Core;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Core\Answer>
 */
class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = fake()->dateTimeBetween('2022-01-01', now());

        return [
            'content' => fake()->text(),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
