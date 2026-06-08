<?php

namespace Database\Factories;

use App\Models\Sheikh;
use Illuminate\Database\Eloquent\Factories\Factory;

class TelaawahFactory extends Factory
{
    public function definition(): array
    {
        return [
            'sheikh_id' => Sheikh::factory(),
            'name' => fake()->words(3, true),
            'audio_url' => 'https://example.com/audio/' . fake()->uuid() . '.mp3',
            'description' => fake()->realText(80),
        ];
    }
}
