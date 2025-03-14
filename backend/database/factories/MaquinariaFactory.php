<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Maquinaria>
 */
class MaquinariaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->word;

        return [
            'name' => $name,
            'description' => $this->faker->paragraph,
            'fichaTecnica' => $name,
            'capacidad' => $this->faker->paragraph,
            'slug' => Str::slug($name),
            'image' => $this->faker->imageUrl(),
            'categoria_id' => \App\Models\Categoria::factory(),
        ];
    }
}
