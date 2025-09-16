<?php

namespace App\Livewire\Suppliers;

use Livewire\Component;
use App\Models\Supplier;
use Livewire\Attributes\Title;

#[Title("Suppliers")]
class Index extends Component
{
    public $search = '';

    public $headers = [
        ['key' => 'id', 'label' => 'ID'],
        ['key' => 'name', 'label' => 'Name'],
        ['key'=> 'address', 'label'=> 'Address'],
        ['key'=> 'phone_number', 'label'=> 'Phone Number'],
    ];

    public $sortBy = [
        'column' => 'name',
        'direction' => 'asc',
    ];

    public function delete($id){

        Supplier::findOrFail($id)->delete();

        $this->dispatch('success', message: 'Supplier deleted successfully!');
    }
    public function render()
    {
        $suppliers = Supplier::query()
        ->when($this->search, function ($query) {
            $query->where('name','like','%'. $this->search .'%')
            ->orWhere('address','like','%'. $this->search .'%')
            ->orWhere('phone_number','like','%'. $this->search .'%');
        })
        ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
        ->paginate(10);
        
        return view('livewire.suppliers.index' , compact('suppliers'));
    }
}
