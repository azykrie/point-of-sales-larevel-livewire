<?php

namespace App\Livewire\Products;

use App\Models\Product;
use App\Models\Category;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Edit Product')]

class Edit extends Component
{
    public $productId;
    public $name, $brand, $purchase_price, $selling_price, $stock, $category_id;
    public $categories = [];

    public function mount($id)
    {
        $product = Product::findOrFail($id);

        $this->productId = $product->id;
        $this->name = $product->name;
        $this->brand = $product->brand;
        $this->purchase_price = $product->purchase_price;
        $this->selling_price = $product->selling_price;
        $this->stock = $product->stock;
        $this->category_id = $product->category_id;

        $this->categories = Category::all();
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    public function update()
    {
        $validated = $this->validate();

        $product = Product::findOrFail($this->productId);
        $product->update($validated);

        session()->flash('success', 'Product updated successfully!');

        if (auth()->user()->role === 'admin') {
            return redirect()->to('/admin/products');
        } else {
            return redirect()->to('/warehouse/products');
        }
    }

    public function render()
    {
        return view('livewire.products.edit');
    }
}
