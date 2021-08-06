<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class DeleteAccount extends Component
{
    public string $email = '';

    public string $password = '';

    public function render()
    {
        return view('profile.delete-account');
    }

    public function destroy()
    {
        $user = auth()->user();

        if (!$this->credentialsAreCorrect($user)) {
            $this->reset('password');
            return $this->addError('email', 'These credentials do not match our records.');
        }

        $user->links()->delete();
        $user->notes()->delete();
        $user->boards()->delete();
        $user->delete();

        return redirect()->route('home');
    }

    protected function credentialsAreCorrect(User $user): bool
    {
        return Hash::check($this->password, $user->password) && $user->email == $this->email;
    }
}
