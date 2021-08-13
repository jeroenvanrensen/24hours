<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BoardFactory extends Factory
{
    protected $model = Board::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->word(),
            'image' => $this->faker->imageUrl(),
            'archived' => false
        ];
    }

    public function archived()
    {
        return $this->state(fn () => ['archived' => true]);
    }
}
