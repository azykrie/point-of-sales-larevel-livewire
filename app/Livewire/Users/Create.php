<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;

#[Title("User Create")]
class Create extends Component
{
    use WithFileUploads;
    public $email, $name, $password, $password_confirmation, $avatars;

    public $roles = [
        ["name"=> "Select Role", "id" => ""],
        ["name" => "Admin", "id" => "admin"],
        ["name" => "User", "id" => "user"],
        ["name" => "Manager", "id" => "manager"],
    ];

    public function create(){
        $this->validate([
            'email' => 'required|email',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'avatars' => 'nullable|image|max:1024',
        ]);

        $avatarsPath = $this->avatars ? $this->avatars->store('avatars', 'public') : null;

        User::create([
            'email' => $this->email,
            'name' => $this->name,
            'avatars' => $avatarsPath,
            'password' => bcrypt($this->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function render()
    {
        return view('livewire.users.create');
    }
}
