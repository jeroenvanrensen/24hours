<?php

namespace App\Http\Livewire\Notes;

use App\Models\Note;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Livewire\Component;

class Edit extends Component
{
    use AuthorizesRequests;

    public $tab = 'write';

    public Note $note;

    public $body;

    protected $queryString = [
        'tab' => ['except' => 'write']
    ];

    public function mount()
    {
        $this->authorize('view', $this->note->board);
        $this->body = $this->note->body;

        $this->note->update(['updated_at' => now()]);
    }

    public function render()
    {
        return view('notes.edit');
    }

    public function updated()
    {
        $this->authorize('manageItems', $this->note->board);

        $this->validate(['body' => ['nullable', 'string']]);

        $this->note->update([
            'title' => $this->getTitle(),
            'body' => $this->body
        ]);
    }

    protected function getTitle(): string
    {
        return Str::of($this->body) // Get the note's body
            ->pipe(fn ($title) => strtok($title, "\n\t")) // Get the first line
            ->ltrim('# ') // Remove the # for headings
            ->pipe(fn ($title) => strip_tags($title)) // Strip tags
            ->whenEmpty(fn () => Str::of('No Title')) // Add an empty message
            ->pipe(fn ($title) => explode('\n', wordwrap($title, 255, '\n'))[0]); // Get the first 255 characters
    }

    public function destroy()
    {
        $this->authorize('manageItems', $this->note->board);

        $this->note->delete();

        session()->flash('flash.success', 'The note was deleted!');

        return redirect()->route('boards.show', $this->note->board);
    }
}
