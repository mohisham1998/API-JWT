<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name_ar' => $this -> faker->word(),
            'name_en' => $this -> faker->word(),
            'date' => $this -> faker -> date()
        ];
    }
}
