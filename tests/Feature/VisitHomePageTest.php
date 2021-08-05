<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses()->beforeEach(fn () => $this->withoutExceptionHandling());

test('a user can visit the home page', function () {
    $this->get(route('home'))
        ->assertStatus(200)
        ->assertSeeLivewire('home');
});

test('authenticated users get redirected when they visit the home page', function () {
    $this->actingAs(User::factory()->create());
    $this->get(route('home'))->assertRedirect(route('boards.index'));
});
