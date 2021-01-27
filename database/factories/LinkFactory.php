<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\Link;
use Illuminate\Database\Eloquent\Factories\Factory;

class LinkFactory extends Factory
{
    protected $model = Link::class;

    public function definition()
    {
        return [
            'board_id' => Board::factory(),
            'url' => $this->faker->url,
            'title' => $this->faker->sentence
        ];
    }
}
