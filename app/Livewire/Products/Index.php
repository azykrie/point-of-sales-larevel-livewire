<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Title('Products')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $headers = [
        ['key' => 'id', 'label' => 'ID'],
        ['key' => 'name', 'label' => 'Name'],
        ['key' => 'brand', 'label' => 'Brand'],
        ['key' => 'purchase_price', 'label' => 'Purchase Price'],
        ['key' => 'selling_price', 'label' => 'Selling Price'],
        ['key' => 'stock', 'label' => 'Stock'],
        ['key' => 'category', 'label' => 'Category'],
    ];

    public $sortBy = [
        'column' => 'name',
        'direction' => 'asc',
    ];

    public function updated($property): void
    {
        if (!is_array($property) && $property != "") {
            $this->resetPage();
        }
    }

    public function delete($id) 
    {
        Product::find($id)->delete();
        $this->dispatch('success', message: 'Product deleted successfully!');
    }

    public function render()
    {
        $products = Product::query()
            ->with('category')
            ->when($this->search, function ($query) {
                $query->where('products.name', 'like', '%' . $this->search . '%')
                    ->orWhere('products.brand', 'like', '%' . $this->search . '%')
                    ->orWhereHas(
                        'category',
                        fn($q) =>
                        $q->where('name', 'like', '%' . $this->search . '%')
                    )
                    ->orWhere('products.stock', 'like', '%' . $this->search . '%')
                    ->orWhere('products.purchase_price', 'like', '%' . $this->search . '%')
                    ->orWhere('products.selling_price', 'like', '%' . $this->search . '%');
            })
            ->when($this->sortBy['column'] === 'category', function ($query) {
                $query->join('categories', 'products.category_id', '=', 'categories.id')
                    ->orderBy('categories.name', $this->sortBy['direction'])
                    ->select('products.*');
            }, function ($query) {
                $query->orderBy($this->sortBy['column'], $this->sortBy['direction']);
            })
            ->paginate(10)
            ->through(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'brand' => $product->brand,
                    'purchase_price' => 'Rp. ' . number_format($product->purchase_price, 0, ',', '.'),
                    'selling_price' => 'Rp. ' . number_format($product->selling_price, 0, ',', '.'),
                    'stock' => $product->stock,
                    'category' => $product->category?->name ?? '-',
                ];
            });

        return view('livewire.products.index', compact('products'));
    }
}
