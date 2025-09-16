<?php

namespace App\Livewire\StockMovements;

use App\Models\Stock_movement;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title("Stock Movements")]
class Index extends Component
{
    use WithPagination;

    public $search = "";

    public $headers = [
        ['key' => 'id', 'label' => 'ID'],
        ['key' => 'product.name', 'label' => 'Product'],
        ['key' => 'type', 'label' => 'Type'],
        ['key' => 'quantity', 'label' => 'Quantity'],
        ['key' => 'note', 'label' => 'Note'],
        ['key' => 'user.name', 'label' => 'User'],
        ['key' => 'created_at', 'label' => 'Date'],
    ];

    public $sortBy = [
        'column' => 'created_at',
        'direction' => 'desc',
    ];

    public function updated($property): void
    {
        if (!is_array($property) && $property != "") {
            $this->resetPage();
        }
    }

    public function delete($id)
    {
        Stock_movement::find($id)?->delete();
        $this->dispatch('success', message: 'Movement deleted successfully!');
    }

    public function render()
    {
        $movements = Stock_movement::with(['product', 'user'])
            ->when($this->search, function ($query) {
                $query->whereHas('product', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('note', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(10);

        return view('livewire.stock-movements.index', compact('movements'));
    }
}
