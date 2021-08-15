<?php

namespace Tests\Unit\Models;

use App\Models\Board;
use App\Models\Invitation;
use Illuminate\Support\Arr;
use function Pest\Faker\faker;

beforeEach(fn () => $this->withoutExceptionHandling());

it('has an email', function () {
    $email = faker()->email();
    $invitation = Invitation::factory()->create(['email' => $email]);
    expect($invitation->email)->toBe($email);
});

it('has a role', function () {
    $role = Arr::random(['viewer', 'member']);
    $invitation = Invitation::factory()->create(['role' => $role]);
    expect($invitation->role)->toBe($role);
});

it('belongs to a board', function () {
    $board = Board::factory()->create();
    $invitation = Invitation::factory()->create(['board_id' => $board->id]);

    expect($invitation->board_id)->toBe($board->id);
    expect($invitation->board)->toBeInstanceOf(Board::class);
    expect($invitation->board->id)->toBe($board->id);
});

it('has an avatar', function ($email, $avatar) {
    $invitation = Invitation::factory()->create(['email' => $email]);
    expect($invitation->avatar)->toBe($avatar);
})->with([
    ['john@example.com', 'https://www.gravatar.com/avatar/d4c74594d841139328695756648b6bd6?d=https%3A%2F%2Fwww.w3schools.com%2Fw3css%2Fimg_avatar2.png&s=40'],
    ['jane@example.org', 'https://www.gravatar.com/avatar/18385ac57d9b171dc3fe83a5a92b68d9?d=https%3A%2F%2Fwww.w3schools.com%2Fw3css%2Fimg_avatar2.png&s=40']
]);
