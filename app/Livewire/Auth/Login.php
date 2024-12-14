<?php

namespace App\Livewire\Auth;
use App\Livewire\Auth\Request;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{

    public $email;
    public $password;



    public function save() {

        // Validate user input
        $this->validate([
            'email' => 'required|email|max:255|exists:users,email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate the user
        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->flash('error', __('Invalid credentials')); // Translates "Invalid credentials" based on the current locale
            return;
        }

        // Redirect to intended URL or home
        return redirect()->intended('/');
    }
    public function render()
    {
        return view('livewire.auth.login');
    }


}
