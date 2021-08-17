<?php

use App\Http\Livewire\Notes\Edit;
use App\Models\Board;
use App\Models\Membership;
use App\Models\Note;
use App\Models\User;
use Livewire\Livewire;

beforeEach(fn () => $this->withoutExceptionHandling());

test('the board owner can visit the notes page', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    $note = Note::factory()->for($board)->create();

    $this->get(route('notes.edit', $note))->assertStatus(200)->assertSeeLivewire('notes.edit');
});

test('members can visit the notes page', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->member()->create();
    $note = Note::factory()->for($board)->create();

    $this->get(route('notes.edit', $note))->assertStatus(200)->assertSeeLivewire('notes.edit');
});

test('viewers can visit the notes page', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->viewer()->create();
    $note = Note::factory()->for($board)->create();

    $this->get(route('notes.edit', $note))->assertStatus(200)->assertSeeLivewire('notes.edit');
});

test('guests cannot visit the notes page', function () {
    $this->withExceptionHandling();
    $note = Note::factory()->create();
    $this->get(route('notes.edit', $note))->assertRedirect(route('login'));
});

test('other users cannot visit the notes page', function () {
    $this->withExceptionHandling();
    $this->actingAs(User::factory()->create());
    $board = Board::factory()->create(); // other user
    $note = Note::factory()->for($board)->create();

    $this->get(route('notes.edit', $note))->assertStatus(403);
});

test('a user can still visit the notes page when the board is archived', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->archived()->create();
    $note = Note::factory()->for($board)->create();

    $this->get(route('notes.edit', $note))->assertStatus(200)->assertSeeLivewire('notes.edit');
});

test('the updated_at column is updated after editing a note', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    $note = Note::factory()->for($board)->create(['updated_at' => now()->subWeek()]);

    // Assert that the note was last updated longer than 60 seconds ago
    expect($note->fresh()->updated_at->diffInSeconds())->toBeGreaterThan(60);

    $this->get(route('notes.edit', $note))->assertStatus(200)->assertSeeLivewire('notes.edit');

    // Assert that the note was last updated between now and 60 seconds ago
    expect($note->fresh()->updated_at->diffInSeconds())->toBeLessThan(60);
});

test('the board owner can edit a note', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    $note = Note::factory()->for($board)->create();

    expect($note->fresh()->body)->not()->toBe('My Note');
    Livewire::test(Edit::class, ['note' => $note])->set('body', 'My Note');
    expect($note->fresh()->body)->toBe('My Note');
});

test('members can edit a note', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->member()->create();
    $note = Note::factory()->for($board)->create();

    expect($note->fresh()->body)->not()->toBe('My Note');
    Livewire::test(Edit::class, ['note' => $note])->set('body', 'My Note');
    expect($note->fresh()->body)->toBe('My Note');
});

test('viewers cannot edit a note', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->viewer()->create();
    $note = Note::factory()->for($board)->create();

    Livewire::test(Edit::class, ['note' => $note])->set('body', 'My Note')->assertStatus(403);
    expect($note->fresh()->body)->not()->toBe('My Note');
});

test('a user cannot edit the note when the board is archived', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create(['archived' => true]);
    $note = Note::factory()->for($board)->create();

    Livewire::test(Edit::class, ['note' => $note])->set('body', 'My Note')->assertStatus(403);
    expect($note->fresh()->body)->not()->toBe('My Note');
});

test('the title is automatically updated', function ($body, $title) {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    $note = Note::factory()->for($board)->create();

    expect($note->fresh()->title)->not()->toBe($title);
    Livewire::test(Edit::class, ['note' => $note])->set('body', $body);
    expect($note->fresh()->title)->toBe($title);
})->with([
    ['My Note', 'My Note'],
    [null, 'No Title'],
    ['', 'No Title'],
    ['# My Note', 'My Note'],
    ['<p></p>', 'No Title'],
    ['<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis optio laudantium deserunt ipsa quod explicabo nam soluta, perferendis recusandae aliquid eos illum eum, minima rem aspernatur nemo repellendus quisquam reiciendis dolorem accusamus dolor dicta saepe, eveniet voluptates? Repellendus aperiam amet enim commodi minima cumque temporibus expedita autem ipsa eaque illo esse, nisi aliquid officiis ullam voluptatem laborum quos earum placeat mollitia nobis! Autem fuga repellat ut quae quasi eum reprehenderit soluta expedita, et eaque debitis odit totam porro accusamus saepe ex dignissimos aut laboriosam aliquam amet quis. Nisi beatae aspernatur qui adipisci suscipit eligendi architecto aut atque incidunt natus, facere alias ad eaque dicta quidem placeat! Perferendis obcaecati recusandae officia veniam optio asperiores numquam sequi earum deleniti nemo mollitia voluptate pariatur et qui quisquam exercitationem fugiat, provident esse quo aspernatur, ad porro! Reprehenderit voluptatibus possimus nostrum? Nesciunt iusto a voluptatum optio nihil. Quibusdam, saepe ad fugiat aliquam quod iure quae doloremque placeat velit, dolores possimus quo nulla mollitia sapiente ducimus. Unde magni numquam saepe corporis, vitae eos accusantium, nisi fuga labore reprehenderit animi, recusandae vel enim impedit! Eligendi, veniam voluptates? Quo laudantium qui rerum molestias, placeat tempora natus, soluta itaque expedita eligendi doloremque dolor velit ratione voluptate at laborum reprehenderit odio libero earum quasi dolores blanditiis. Dolor amet cupiditate, odio perspiciatis nostrum fugiat fuga accusamus obcaecati quibusdam, ipsa sint illum odit accusantium officiis quod saepe velit explicabo nisi illo officia. Architecto quibusdam voluptate eligendi molestias? Quidem beatae rerum, quas saepe maiores rem porro deserunt incidunt. Sapiente rerum aperiam assumenda est porro labore numquam, nisi iusto doloremque accusamus, odit reprehenderit deserunt? Nihil velit quia at blanditiis ipsam amet aspernatur dolorem debitis et reiciendis illo magni possimus, unde asperiores impedit. Doloribus, omnis vero. Officiis quo voluptatem asperiores temporibus qui odio consequuntur accusantium pariatur est nihil. Veritatis ipsum saepe doloremque ipsa iusto. Libero.</p>', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis optio laudantium deserunt ipsa quod explicabo nam soluta, perferendis recusandae aliquid eos illum eum, minima rem aspernatur nemo repellendus quisquam reiciendis dolorem accusamus dolor'],
    ['# My Note
    Note Content', 'My Note']
]);
