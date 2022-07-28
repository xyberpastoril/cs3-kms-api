<?php

namespace Database\Factories\Core;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Core\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = fake()->dateTimeBetween('2021-01-01', '2021-12-31');

        return [
            'content' => fake()->sentence(),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
