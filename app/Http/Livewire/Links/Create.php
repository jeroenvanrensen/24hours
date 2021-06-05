<?php

namespace App\Http\Livewire\Links;

use App\Models\Board;
use App\Models\Link;
use App\Services\WebScraper\Scraper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Create extends Component
{
    use AuthorizesRequests;

    public Board $board;

    public $url;

    protected $rules = [
        'url' => ['required', 'url', 'max:255']
    ];

    public function render()
    {
        return view('links.create');
    }

    public function add()
    {
        $this->authorize('manageItems', $this->board);

        $this->validate();

        $scraper = new Scraper();
        $response = $scraper->scrape($this->url);

        Link::create([
            'board_id' => $this->board->id,
            'url' => $this->url,
            'title' => $response->title,
            'image' => $response->image
        ]);

        session()->flash('flash.success', 'The link was added!');

        return redirect()->route('boards.show', $this->board);
    }
}
