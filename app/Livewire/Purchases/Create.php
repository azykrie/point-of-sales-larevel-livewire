<?php

namespace App\Livewire\Purchases;

use App\Models\Product;
use Livewire\Component;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Purchase_item;
use Livewire\Attributes\Title;

#[Title('Create Purchase')]
class Create extends Component
{
    public $supplier_id;
    public $items = [];
    public $totalAmount = 0;

    public $suppliers;
    public $products;

    public function mount()
    {
        $this->suppliers = Supplier::all(['id', 'name']);
        $this->products = Product::all(['id', 'name']);
        $this->addItem();
    }

    public function addItem()
    {
        $this->items[] = [
            'product_id' => null,
            'quantity' => 1,
            'price' => 0,
            'subtotal' => 0,
        ];
        $this->calculateTotal();
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items); // reset index
        $this->calculateTotal();
    }

    public function updatedItems($value, $key)
    {
        [$index, $field] = explode('.', $key);

        $qty = (int) ($this->items[$index]['quantity'] ?? 0);
        $price = (int) ($this->items[$index]['price'] ?? 0);

        $this->items[$index]['subtotal'] = $qty * $price;

        $this->calculateTotal();
    }


    public function calculateTotal()
    {
        $this->totalAmount = collect($this->items)->sum('subtotal');
    }

    public function create()
    {
        $this->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $purchase = Purchase::create([
            'supplier_id' => $this->supplier_id,
            'user_id' => auth()->id(),
            'total_amount' => $this->totalAmount,
        ]);

        foreach ($this->items as $item) {
            Purchase_item::create([
                'purchase_id' => $purchase->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['subtotal'],
            ]);

            $product = Product::find($item['product_id']);
            if ($product) {
                $product->stock += $item['quantity'];
                $product->purchase_price = $item['price'];
                $product->save();
            }
        }

        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.purchases.index')->with('success', 'Purchase created successfully.');
        } else {
            return redirect()->route('warehouse.purchases.index')->with('success', 'Purchase created successfully.');
        }
    }

    public function render()
    {
        return view('livewire.purchases.create');
    }
}
