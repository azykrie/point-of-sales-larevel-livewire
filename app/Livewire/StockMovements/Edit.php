<?php
namespace App\Livewire\StockMovements;

use App\Models\Product;
use App\Models\Stock_movement;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Edit Stock Movement")]
class Edit extends Component
{
    public $movement_id;
    public $product_id;
    public $product_name;
    public $type;
    public $quantity;
    public $note;

    public function mount($id)
    {
        $movement = Stock_movement::with('product')->findOrFail($id);

        $this->movement_id  = $movement->id;
        $this->product_id   = $movement->product_id;
        $this->product_name = $movement->product->name ?? '';
        $this->type         = $movement->type;
        $this->quantity     = $movement->quantity;
        $this->note         = $movement->note;
    }

    public function update()
    {
        $this->validate([
            'type'     => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'note'     => 'nullable|string|max:255',
        ]);

        $movement = Stock_movement::findOrFail($this->movement_id);

        $movement->update([
            'type'     => $this->type,
            'quantity' => $this->quantity,
            'note'     => $this->note,
        ]);

        return redirect()->route(auth()->user()->role . '.stock-movements.index')->with('success', 'Stock movement updated successfully!');
    }

    public function render()
    {
        return view('livewire.stock-movements.edit');
    }
}
