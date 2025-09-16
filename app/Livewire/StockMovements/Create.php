<?php
namespace App\Livewire\StockMovements;

use App\Models\Product;
use App\Models\Stock_movement;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Create Stock Movement")]
class Create extends Component
{
    public $product_id = null;
    public $type       = 'in';
    public $quantity;
    public $note;

    public $products = [];

    public function mount()
    {
        $this->products = Product::all(['id', 'name']);

        if ($this->products->isNotEmpty()) {
            $this->product_id = $this->products->first()->id;
        }
    }

    public function save()
    {
        $this->validate([
            'product_id' => 'required|exists:products,id',
            'type'       => 'required|in:in,out',
            'quantity'   => 'required|integer|min:1',
            'note'       => 'nullable|string|max:255',
        ]);

        Stock_movement::create([
            'product_id' => $this->product_id,
            'type'       => $this->type,
            'quantity'   => $this->quantity,
            'note'       => $this->note,
            'user_id'    => auth()->id(),
        ]);

        return redirect()->route(auth()->user()->role . '.stock-movements.index')->with('success', 'Stock movement created successfully!');
    }

    public function render()
    {
        return view('livewire.stock-movements.create');
    }
}
