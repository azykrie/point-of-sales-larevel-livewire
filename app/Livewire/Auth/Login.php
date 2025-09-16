<?php
namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Login")]
class Login extends Component
{
    public $email;
    public $password;

    public function login()
    {
        $this->validate([
            'email'    => 'required|email',
            'password' => 'required|',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $user = Auth::user();

            session()->flash('message', 'Login successful!');

            // Redirect sesuai role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard.index')->with('success', 'Login successful!');
            } elseif ($user->role === 'warehouse') {
                return redirect()->route('warehouse.dashboard.index')->with('success', 'Login successful!');
            } elseif ($user->role === 'cashier') {
                return redirect()->route('cashier.dashboard.index')->with('success', 'Login successful!');
            } elseif ($user->role === 'manager') {
                return redirect()->route('manager.dashboard.index')->with('success', 'Login successful!');
            }

            Auth::logout();
            session()->flash('error', 'Unauthorized role.');
            return redirect()->route('login');

        } else {
            session()->flash('error', 'Invalid credentials. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.auth');
    }
}
