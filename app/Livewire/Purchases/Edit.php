<?php

namespace App\Livewire\Purchases;

use App\Models\Product;
use Livewire\Component;
use App\Models\Purchase;
use App\Models\Supplier;
use Livewire\Attributes\Title;

#[Title('Edit Purchase')]
class Edit extends Component
{
    public $purchaseId;
    public $supplier_id;
    public $items = [];
    public $totalAmount = 0;

    public $suppliers;
    public $products;

    public function mount($id)
    {
        $this->suppliers = Supplier::all();
        $this->products = Product::all();

        $purchase = Purchase::with('items')->findOrFail($id);

        $this->purchaseId = $purchase->id;
        $this->supplier_id = $purchase->supplier_id;

        // Isi items lama
        $this->items = $purchase->items->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'subtotal' => $item->quantity * $item->price,
            ];
        })->toArray();

        $this->calculateTotal();
    }

    public function addItem()
    {
        $this->items[] = [
            'product_id' => null,
            'quantity' => 1,
            'price' => 0,
            'subtotal' => 0,
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
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

    private function calculateTotal()
    {
        $this->totalAmount = collect($this->items)->sum('subtotal');
    }

    public function update()
    {
        $this->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $purchase = Purchase::with('items')->findOrFail($this->purchaseId);

        foreach ($purchase->items as $oldItem) {
            $product = Product::find($oldItem->product_id);
            if ($product) {
                $product->stock -= $oldItem->quantity;
                $product->save();
            }
        }

        // hapus item lama
        $purchase->items()->delete();

        // update purchase
        $purchase->update([
            'supplier_id' => $this->supplier_id,
            'user_id' => auth()->id(),
            'total_amount' => $this->totalAmount,
        ]);

        // simpan ulang & update stok baru
        foreach ($this->items as $item) {
            $purchase->items()->create([
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
        return view('livewire.purchases.edit');
    }
}
