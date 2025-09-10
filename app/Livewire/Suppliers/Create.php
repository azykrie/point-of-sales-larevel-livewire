<?php

namespace App\Livewire\Suppliers;

use Livewire\Component;
use App\Models\Supplier;
use Livewire\Attributes\Title;


#[Title('Create Supplier')]
class Create extends Component
{
    public $name, $address, $phone_number;

    public function rules()
    {
        return [
            'name'         => 'required|string|max:255',
            'address'      => 'nullable|string|max:500',
            'phone_number' => 'nullable|string|max:20',
        ];
    }

    public function create()
    {
        $validated = $this->validate();

        Supplier::create($validated);

        session()->flash('success', 'Supplier created successfully!');

        if (auth()->user()->role === 'admin') {
            return redirect()->to('/admin/suppliers');
        } else {
            return redirect()->to('/warehouse/suppliers');
        }
    }

    public function render()
    {
        return view('livewire.suppliers.create');
    }
}
