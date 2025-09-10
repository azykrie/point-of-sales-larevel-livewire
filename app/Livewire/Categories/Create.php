<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;


#[Title('Create Category')]
class Create extends Component
{
    public $name;

    public function create()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create(['name' => $this->name]);

        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
        } else {
            return redirect()->route('warehouse.categories.index')->with('success', 'Category created successfully.');
        }
    }
    public function render()
    {
        return view('livewire.categories.create');
    }
}
