<?php
namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title("Profile")]
class Profile extends Component
{
    use WithFileUploads;

    public $userId, $name, $email, $password, $password_confirmation;
    public $avatars = null, $oldAvatar;

    public function mount()
    {
        $user = Auth::user();

        $this->userId    = $user->id;
        $this->name      = $user->name;
        $this->email     = $user->email;
        $this->oldAvatar = $user->avatars;
    }

    public function update()
    {
        $this->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $this->userId,
            'avatars'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user = User::findOrFail($this->userId);

        $user->name  = $this->name;
        $user->email = $this->email;

        // Upload avatar baru
        if ($this->avatars) {
            // Hapus avatar lama jika ada
            if ($this->oldAvatar && Storage::disk('public')->exists($this->oldAvatar)) {
                Storage::disk('public')->delete($this->oldAvatar);
            }
            $path          = $this->avatars->store('avatars', 'public');
            $user->avatars = $path;
        }

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard.index')->with('success', 'Profile updated successfully!');
        } elseif (auth()->user()->role === 'manager') {
            return redirect()->route('cashier.dashboard.index')->with('success', 'Profile updated successfully!');
        } elseif (auth()->user()->role === 'cashier') {
            return redirect()->route('cashier.dashboard.index')->with('success', 'Profile updated successfully!');
        } elseif (auth()->user()->role === 'warehouse') {
            return redirect()->route('warehouse.dashboard.index')->with('success', 'Profile updated successfully!');
        }

    }

    public function render()
    {
        return view('livewire.users.profile');
    }
}
