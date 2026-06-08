<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SheikhFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name('ar_SA'),
            'image_url' => null,
            'description' => fake()->realText(100),
        ];
    }
}
