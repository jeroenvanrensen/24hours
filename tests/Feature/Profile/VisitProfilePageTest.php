<?php

use App\Models\User;

beforeEach(fn () => $this->withoutExceptionHandling());

test('a user can visit the profile page', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('profile.edit'))
        ->assertStatus(200)
        ->assertSeeLivewire('profile.edit')
        ->assertSeeLivewire('profile.profile-info')
        ->assertSeeLivewire('profile.password')
        ->assertSeeLivewire('profile.delete-account');
});

test('guests cannot visit the profile page', function () {
    $this->withExceptionHandling();
    $this->get(route('profile.edit'))->assertRedirect(route('login'));
});
