<?php

use App\Models\User;

test('a user can logout', function () {
    $this->actingAs(User::factory()->create());
    expect(auth()->check())->toBeTrue();
    $this->post(route('logout'))->assertRedirect(route('home'));
    expect(auth()->check())->toBeFalse();
});

test('guests are redirected to the home page', function () {
    $this->post(route('logout'))->assertRedirect(route('home'));
});
