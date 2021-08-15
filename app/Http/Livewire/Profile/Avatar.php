<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;

class Avatar extends Component
{
    use WithFileUploads;

    public $avatar;

    protected $rules = [
        'avatar' => ['required', 'image', 'max:1024']
    ];

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('profile.avatar');
    }

    public function upload()
    {
        $this->validate();

        $path = $this->avatar->store('public');

        auth()->user()->update([
            'avatar_path' => asset(str_replace('public/', 'storage/', $path))
        ]);

        session()->flash('success', 'Saved!');
    }

    public function remove()
    {
        auth()->user()->update([
            'avatar_path' => null
        ]);

        session()->flash('success', 'Saved!');
    }
}
