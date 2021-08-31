<?php

use App\Http\Livewire\Boards\Create;
use App\Models\Board;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use function Pest\Faker\faker;

beforeEach(fn () => Storage::fake());

test('a user can create a new board', function () {
    $this->actingAs($user = User::factory()->create());
    $name = faker()->word();
    $image = UploadedFile::fake()->image('cover.jpg');
    expect(Board::all())->toHaveCount(0);

    Livewire::test(Create::class)
        ->set('name', $name)
        ->set('image', $image)
        ->call('create')
        ->assertRedirect(route('boards.show', Board::first()));

    expect(Board::all())->toHaveCount(1);
    tap(Board::first(), function ($board) use ($user, $name) {
        expect($board->user_id)->toBe($user->id);
        expect($board->name)->toBe($name);
        expect($board->image)->not()->toBeEmpty();
        expect($board->archived)->toBeFalse();
    });
});

it('requires a name', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(Create::class)
        ->set('name', null)
        ->set('image', UploadedFile::fake()->image('cover.jpg'))
        ->call('create')
        ->assertHasErrors('name');
});

it('requires an image', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(Create::class)
        ->set('name', faker()->word())
        ->set('image', null)
        ->call('create')
        ->assertHasErrors('image');

    Livewire::test(Create::class)
        ->set('name', faker()->word())
        ->set('image', faker()->word())
        ->call('create')
        ->assertHasErrors('image');
});
