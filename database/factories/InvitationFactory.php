<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\Invitation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class InvitationFactory extends Factory
{
    protected $model = Invitation::class;

    public function definition()
    {
        return [
            'board_id' => Board::factory(),
            'email' => $this->faker->email(),
            'role' => Arr::random(['member', 'viewer'])
        ];
    }
}
