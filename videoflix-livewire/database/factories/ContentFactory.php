<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content>
 */
class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->words(4, true);

        return [
            'code' => fake()->uuid(),
            'title' => $title,
            'slug' => str($title)->slug(),
            'description' => fake()->sentence,
            'body' => fake()->paragraphs(3, true),
            'type' => 'MOVIE',
        ];
    }

    /**
     * Indicate that the content is a series.
     */
    public function series(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'SERIES',
        ]);
    }

    /**
     * Indicate that the content is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'ACTIVE',
        ]);
    }

    /**
     * Indicate that the content is deactive.
     */
    public function deactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'DEACTIVE',
        ]);
    }
}
