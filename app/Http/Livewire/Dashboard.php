<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    /**
     * Render the page.
     *
     * @return  \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('dashboard')
            ->layout('layouts.app', ['title' => 'Dashboard']);
    }
}
