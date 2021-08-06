<?php

use App\Models\User;

beforeEach(fn () => $this->withoutExceptionHandling());

test('a user can visit the search page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $this->get(route('search'))
        ->assertStatus(200)
        ->assertSeeLivewire('search.search');
});

test('guests cannot visit the search page', function () {
    $this->withExceptionHandling();
    $this->get(route('search'))->assertRedirect(route('login'));
});
