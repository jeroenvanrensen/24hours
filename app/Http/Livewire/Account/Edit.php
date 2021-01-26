<?php

namespace App\Http\Livewire\Account;

use Livewire\Component;

class Edit extends Component
{
    public function render()
    {
        return view('account.edit')
            ->layout('layouts.app', ['title' => 'My Account']);
    }
}
