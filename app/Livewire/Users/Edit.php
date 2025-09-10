<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $userId, $name , $email, $password, $password_confirmation, $avatars = null, $oldAvatar;


    public function mount($id)
    {
        $user = User::findOrFail($id);

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;

        $this->oldAvatar = $user->avatars;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'avatars' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user = User::findOrFail($this->userId);

        $user->name = $this->name;
        $user->email = $this->email;

        if ($this->avatars) {
            $path = $this->avatars->store('avatars', 'public');
            $user->avatars = $path;
        }

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        session()->flash('success', 'User updated successfully!');
        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        return view('livewire.users.edit');
    }
}

