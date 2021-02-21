<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class MembershipFactory extends Factory
{
    protected $model = Membership::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'board_id' => Board::factory(),
            'role' => Arr::random(['member', 'viewer'])
        ];
    }
}
