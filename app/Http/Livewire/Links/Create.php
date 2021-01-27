<?php

namespace App\Http\Livewire\Links;

use App\Models\Board;
use App\Models\Link;
use App\Services\WebScraper\Scraper;
use Livewire\Component;

class Create extends Component
{
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
        $this->validate();

        $scraper = new Scraper();
        $response = $scraper->scrape($this->url);

        Link::create([
            'board_id' => $this->board->id,
            'url' => $this->url,
            'title' => $response->title
        ]);

        $this->emit('createdLink');
        $this->reset('url');
    }
}
