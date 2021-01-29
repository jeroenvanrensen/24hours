<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\Note;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoteFactory extends Factory
{
    protected $model = Note::class;

    public function definition()
    {
        return [
            'board_id' => Board::factory(),
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
        ];
    }
}
