<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Auth;
use Livewire\Component;

class Edit extends Component
{
    public $category_id, $name;

    public function mount($id)
    {
        $category = Category::find($id);

        $this->category_id = $category->id;
        $this->name = $category->name;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $this->category_id,
        ]);

        $category = Category::find($this->category_id);
        $category->update(['name' => $this->name]);

        $role = Auth::user()->role;

        $redirectRoute = match ($role) {
            'admin' => 'admin.categories.index',
            'warehouse' => 'warehouse.categories.index',
            default => 'login',
        };

        return redirect()->route($redirectRoute)
            ->with('success', 'Category updated successfully.');
    }

    public function render()
    {
        return view('livewire.categories.edit');
    }
}
