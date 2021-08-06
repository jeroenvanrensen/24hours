<?php

use App\Http\Livewire\Profile\Edit;
use App\Models\User;
use Livewire\Livewire;

beforeEach(fn () => $this->withoutExceptionHandling());

test('a user can logout', function () {
    $this->actingAs(User::factory()->create());
    expect(auth()->check())->toBeTrue();

    Livewire::test(Edit::class)->call('logout')->assertRedirect(route('login'));
    expect(auth()->check())->toBeFalse();
});
