<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Sale_item;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

#[Title('Create Sale')]
class Create extends Component
{
    public $customer_name;
    public $payment_method = 'cash';
    public $items = [];
    public $products;
    public $totalAmount = 0;
    public $stock_product_id;
    public $stock_quantity = 1;

    public function mount()
    {
        $this->loadProducts();
        $this->items = [];
    }

    private function loadProducts()
    {
        $this->products = Product::select('id', 'name', 'selling_price', 'stock')->get();
    }

    public function addStock()
    {
        $this->validate([
            'stock_product_id' => 'required|exists:products,id',
            'stock_quantity' => 'required|integer|min:1',
        ]);

        $product = $this->products->firstWhere('id', $this->stock_product_id);

        if (!$product) {
            $this->dispatch('error', message: 'Product not found!');
            return;
        }

        if ($product->stock <= 0) {
            $this->dispatch('error', message: "Stock for {$product->name} sold, please choose another product!");
            return;
        }

        if ($this->stock_quantity > $product->stock) {
            $this->dispatch('error', message: "Stok for {$product->name} only {$product->stock} item!");
            return;
        }

        $index = collect($this->items)->search(fn($item) => $item['product_id'] == $product->id);

        if ($index !== false) {
            $newQty = $this->items[$index]['quantity'] + $this->stock_quantity;

            if ($newQty > $product->stock) {
                $this->dispatch('error', message: "Stok for {$product->name} only {$product->stock} item!");
                return;
            }

            $this->items[$index]['quantity'] = $newQty;
            $this->items[$index]['subtotal'] = $this->items[$index]['quantity'] * $this->items[$index]['price'];
        } else {
            $this->items[] = [
                'product_id' => $product->id,
                'quantity' => $this->stock_quantity,
                'price' => $product->selling_price,
                'subtotal' => $product->selling_price * $this->stock_quantity,
            ];
        }

        $this->calculateTotal();
        $this->reset(['stock_product_id', 'stock_quantity']);
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateTotal();
    }

    private function calculateTotal()
    {
        $this->totalAmount = collect($this->items)->sum('subtotal');
    }

    public function create()
    {
        $this->validate([
            'customer_name' => 'required|string|max:255',
            'payment_method' => 'required|string',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () {
            $sale = Sale::create([
                'user_id' => auth()->id(),
                'customer_name' => $this->customer_name,
                'payment_method' => $this->payment_method,
                'total_amount' => $this->totalAmount,
            ]);

            foreach ($this->items as $item) {
                $product = Product::find($item['product_id']);
                if (!$product)
                    continue;

                if ($item['quantity'] > $product->stock) {
                    throw new \Exception("Stock untuk {$product->name} tidak cukup!");
                }

                Sale_item::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);

                $product->decrement('stock', $item['quantity']);
            }
        });

        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.sales.index')->with('success', 'Sale created successfully.');
        } else {
            return redirect()->route('cashier.sales.index')->with('success', 'Sale created successfully.');
        }
    }

    public function render()
    {
        return view('livewire.sales.create');
    }
}
