<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserProfile extends Component
{
    public $name;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function mount()
    {
        $this->name = Auth::user()->name;
    }

    public function updateProfile()
    {
        $user = Auth::user();

        $this->validate([
            'name' => 'required|string|max:255',
            'current_password' => 'nullable|required_with:new_password|min:8',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        if ($this->current_password) {
            if (!Hash::check($this->current_password, $user->password)) {
                $this->addError('current_password', 'The current password is incorrect.');
                return;
            }

            $user->password = Hash::make($this->new_password);
        }

        $user->name = $this->name;
        $user->save();

        session()->flash('success', 'Profile updated successfully!');
    }

    public function render()
    {
        return view('livewire.auth.user-profile');
    }
}
