<?php

namespace App\Livewire\Auth;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
class RegisterPage extends Component
{

    public $name;
    public $email;
    public $password;



    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8', // This line checks for password confirmation
        ]);

        // Create the user
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Automatically log in the user after registration
        auth()->login($user);

        return redirect()->intended('/');
    }

    public function render()
    {
        return view('livewire.auth.register-page');
    }
}
