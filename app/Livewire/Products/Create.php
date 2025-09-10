<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Models\Product;
use App\Models\Category;

#[Title('Create Product')]
class Create extends Component
{
    public $name, $brand, $purchase_price, $selling_price, $stock, $category_id;

    protected $rules = [
        'name'           => 'required|string|max:255',
        'brand'          => 'required|string|max:255',
        'purchase_price' => 'required|integer|min:0',
        'selling_price'  => 'required|integer|min:0',
        'stock'          => 'required|integer|min:0',
        'category_id'    => 'required|exists:categories,id',
    ];

    public function create()
    {
        $this->validate();

        Product::create([
            'name'           => $this->name,
            'brand'          => $this->brand,
            'purchase_price' => $this->purchase_price,
            'selling_price'  => $this->selling_price,
            'stock'          => $this->stock,
            'category_id'    => $this->category_id,
        ]);

        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
        } else {
            return redirect()->route('warehouse.products.index')->with('success', 'Product created successfully.');
        }
    }

    public function render()
    {
        return view('livewire.products.create', [
            'categories' => Category::all()
        ]);
    }
}
