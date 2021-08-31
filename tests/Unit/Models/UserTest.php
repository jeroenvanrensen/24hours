<?php

use App\Models\Board;
use App\Models\Invitation;
use App\Models\Link;
use App\Models\Membership;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use function Pest\Faker\faker;

it('has a name', function () {
    $name = faker()->name();
    $user = User::factory()->create(['name' => $name]);
    expect($user->name)->toBe($name);
});

it('has an email', function () {
    $email = faker()->email();
    $user = User::factory()->create(['email' => $email]);
    expect($user->email)->toBe($email);
});

test('the email is unique', function () {
    $email = faker()->email();
    User::factory()->create(['email' => $email]);
    User::factory()->create(['email' => $email]); // same email
})->throws(QueryException::class);

it('has an avatar', function () {
    $avatar = faker()->imageUrl();
    $user = User::factory()->create(['avatar_path' => $avatar]);
    expect($user->avatar)->toBe($avatar);
});

it('has a default avatar', function ($email, $avatar) {
    $user = User::factory()->create(['email' => $email, 'avatar_path' => null]);
    expect($user->avatar)->toBe($avatar);
})->with([
    ['john@example.com', 'https://www.gravatar.com/avatar/d4c74594d841139328695756648b6bd6?d=https%3A%2F%2Fwww.w3schools.com%2Fw3css%2Fimg_avatar2.png&s=40'],
    ['jane@example.org', 'https://www.gravatar.com/avatar/18385ac57d9b171dc3fe83a5a92b68d9?d=https%3A%2F%2Fwww.w3schools.com%2Fw3css%2Fimg_avatar2.png&s=40']
]);

it('has a nullable email_verified_at column', function () {
    $date = today()->subWeek();
    $user = User::factory()->create(['email_verified_at' => $date]);
    expect($user->email_verified_at)->toEqual($date);

    $user = User::factory()->create(['email_verified_at' => null]);
    expect($user->email_verified_at)->toBeNull();
});

it('has a password', function () {
    $password = Hash::make($unhashed = faker()->word());
    $user = User::factory()->create(['password' => $password]);
    expect($user->password)->toBe($password);
    expect(Hash::check($unhashed, $password))->toBeTrue();
});

it('has a nullable remember_token', function () {
    $token = Str::random(16);
    $user = User::factory()->create(['remember_token' => $token]);
    expect($user->remember_token)->toBe($token);

    $user = User::factory()->create(['remember_token' => null]);
    expect($user->remember_token)->toBeNull();
});

it('has a first name', function ($name, $firstname) {
    $user = User::factory()->create(['name' => $name]);
    expect($user->first_name)->toBe($firstname);
})->with([
    ['John', 'John'],
    ['John Doe', 'John'],
    ['Sylvia G. Smith', 'Sylvia'],
    ['Jeroen van Rensen', 'Jeroen']
]);

it('has many boards', function () {
    $user = User::factory()->create();
    $board = Board::factory()->for($user)->create();

    expect($user->boards)->toHaveCount(1);
    expect($user->boards->first())->toBeInstanceOf(Board::class);
    expect($user->boards->first()->id)->toBe($board->id);
});

it('has many links', function () {
    $user = User::factory()->create();
    $board = Board::factory()->for($user)->create();
    $link = Link::factory()->for($board)->create();

    expect($user->links)->toHaveCount(1);
    expect($user->links->first())->toBeInstanceOf(Link::class);
    expect($user->links->first()->id)->toBe($link->id);
});

it('has many notes', function () {
    $user = User::factory()->create();
    $board = Board::factory()->for($user)->create();
    $note = Note::factory()->for($board)->create();

    expect($user->notes)->toHaveCount(1);
    expect($user->notes->first())->toBeInstanceOf(Note::class);
    expect($user->notes->first()->id)->toBe($note->id);
});

it('has many memberships', function () {
    $user = User::factory()->create();
    $membership = Membership::factory()->for($user)->create();

    expect($user->memberships)->toHaveCount(1);
    expect($user->memberships->first())->toBeInstanceOf(Membership::class);
    expect($user->memberships->first()->id)->toBe($membership->id);
});

it('has visible boards', function () {
    $user = User::factory()->create();

    $firstBoard = Board::factory()->for($user)->create(); // Owner - visible

    $secondBoard = Board::factory()->create(); // Member - visible
    Membership::factory()->for($user)->for($secondBoard)->create();

    $thirdBoard = Board::factory()->create(); // Invited - not visible
    Invitation::factory()->for($thirdBoard)->create(['email' => $user->email]);

    $fourthBoard = Board::factory()->create(); // No relation - not visible

    expect($user->visibleBoards())->toHaveCount(2);
    expect($user->visibleBoards()->last()->id)->toBe($firstBoard->id);
    expect($user->visibleBoards()->first()->id)->toBe($secondBoard->id);
});

it('has visible links', function () {
    $user = User::factory()->create();

    $firstBoard = Board::factory()->for($user)->create(); // Owner - visible
    $firstLink = Link::factory()->for($firstBoard)->create();

    $secondBoard = Board::factory()->create(); // Member - visible
    Membership::factory()->for($user)->for($secondBoard)->create();
    $secondLink = Link::factory()->for($secondBoard)->create();

    $thirdBoard = Board::factory()->create(); // Invited - not visible
    Invitation::factory()->for($thirdBoard)->create(['email' => $user->email]);
    $thirdLink = Link::factory()->for($thirdBoard)->create();

    $fourthBoard = Board::factory()->create(); // No relation - not visible
    $fourthLink = Link::factory()->for($fourthBoard)->create();

    expect($user->visibleLinks())->toHaveCount(2);
    expect($user->visibleLinks()->last()->id)->toBe($firstLink->id);
    expect($user->visibleLinks()->first()->id)->toBe($secondBoard->id);
});

it('has visible notes', function () {
    $user = User::factory()->create();

    $firstBoard = Board::factory()->for($user)->create(); // Owner - visible
    $firstNote = Note::factory()->for($firstBoard)->create();

    $secondBoard = Board::factory()->create(); // Member - visible
    $membership = Membership::factory()->for($user)->for($secondBoard)->create();
    $secondNote = Note::factory()->for($secondBoard)->create();

    $thirdBoard = Board::factory()->create(); // Invited - not visible
    $invitation = Invitation::factory()->for($thirdBoard)->create(['email' => $user->email]);
    $thirdNote = Note::factory()->for($thirdBoard)->create();

    $fourthBoard = Board::factory()->create(); // No relation - not visible
    $fourthNote = Note::factory()->for($fourthBoard)->create();

    expect($user->visibleNotes())->toHaveCount(2);
    expect($user->visibleNotes()->last()->id)->toBe($firstNote->id);
    expect($user->visibleNotes()->first()->id)->toBe($secondNote->id);
});
