<?php

namespace App\Livewire\Suppliers;

use Livewire\Component;
use App\Models\Supplier;
use Livewire\Attributes\Title;


#[Title('Edit Supplier')]
class Edit extends Component
{
    public $supplierId;
    public $name, $address, $phone_number;

    public function mount($id)
    {
        $supplier = Supplier::findOrFail($id);

        $this->supplierId = $supplier->id;
        $this->name = $supplier->name;
        $this->address = $supplier->address;
        $this->phone_number = $supplier->phone_number;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'phone_number' => 'nullable|string|max:20',
        ];
    }

    public function update()
    {
        $validated = $this->validate();

        $supplier = Supplier::findOrFail($this->supplierId);
        $supplier->update($validated);

        session()->flash('success', 'Supplier updated successfully!');

        if (auth()->user()->role === 'admin') {
            return redirect()->to('/admin/suppliers');
        } else {
            return redirect()->to('/warehouse/suppliers');
        }
    }

    public function render()
    {
        return view('livewire.suppliers.edit');
    }
}
