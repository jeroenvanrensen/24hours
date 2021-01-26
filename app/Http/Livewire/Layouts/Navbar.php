<?php

namespace App\Http\Livewire\Layouts;

use Livewire\Component;

class Navbar extends Component
{
    /**
     * Render the component.
     *
     * @return  \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('layouts.navbar');
    }

    /**
     * Log the user out.
     *
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        auth()->logout();

        return redirect()->to('/');
    }
}
