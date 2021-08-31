<?php

use App\Http\Livewire\Profile\Avatar;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use function Pest\Faker\faker;

test('a user can visit the avatar page', function () {
    $this->actingAs(User::factory()->create());
    $this->get(route('profile.avatar'))->assertStatus(200)->assertSeeLivewire('profile.avatar');
});

test('guests cannot visit the avatar page', function () {
    $this->withExceptionHandling();
    $this->get(route('profile.avatar'))->assertRedirect(route('login'));
});

test('a user can reset their avatar', function () {
    $user = User::factory()->create(['avatar_path' => faker()->imageUrl()]);
    $this->actingAs($user);
    expect($user->fresh()->avatar_path)->not()->toBeNull();
    Livewire::test(Avatar::class)->call('remove');
    expect($user->fresh()->avatar_path)->toBeNull();
});

test('a user can upload an avatar', function () {
    $this->actingAs($user = User::factory()->create());
    $avatar = UploadedFile::fake()->image('avatar.jpg');
    expect($user->avatar_path)->toBeNull();
    Livewire::test(Avatar::class)->set('avatar', $avatar)->call('upload')->assertHasNoErrors();
    expect($user->avatar_path)->not()->toBeNull();
});

it('requires a valid image', function () {
    $this->actingAs($user = User::factory()->create());
    Livewire::test(Avatar::class)->set('avatar', 'invalid')->call('upload')->assertHasErrors('avatar');
    expect($user->avatar_path)->toBeNull();
});
