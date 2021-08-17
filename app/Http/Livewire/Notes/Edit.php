<?php

namespace App\Http\Livewire\Notes;

use App\Models\Note;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
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
        $title = strtok(strip_tags(str_replace('</', "\n</", $this->body)), "\n\t");

        return $title == '' ? 'No Title' : explode('\n', wordwrap($title, 255, '\n'))[0];
    }

    public function destroy()
    {
        $this->authorize('manageItems', $this->note->board);

        $this->note->delete();

        session()->flash('flash.success', 'The note was deleted!');

        return redirect()->route('boards.show', $this->note->board);
    }
}
