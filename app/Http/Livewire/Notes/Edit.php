<?php

namespace App\Http\Livewire\Notes;

use App\Models\Note;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Edit extends Component
{
    use AuthorizesRequests;

    public Note $note;

    /** @var string|null */
    public $body;

    public function mount()
    {
        $this->authorize('editNote', $this->note->board);
        $this->body = $this->note->body;
    }

    public function render()
    {
        return view('notes.edit')
            ->layout('layouts.app', ['showNavbar' => false]);
    }

    public function updated()
    {
        $this->validate(['body' => ['nullable', 'string']]);

        $this->note->update([
            'title' => $this->getTitle(),
            'body' => $this->body
        ]);
    }

    protected function getTitle(): string
    {
        return $this->body == '' ? 'No Title' : $this->body;
    }
}
