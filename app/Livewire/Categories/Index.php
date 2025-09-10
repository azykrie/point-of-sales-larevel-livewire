<?php

namespace App\Livewire\Categories;

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;


#[Title("Categories")]
class Index extends Component
{
    use WithPagination;

    public $search = "";
    public $headers = [
        ['key' => 'id', 'label' => 'ID'],
        ['key' => 'name', 'label' => 'Category Name'],
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

    public function delete($id){
        Category::find($id)->delete();
        $this->dispatch('success', message:'Category deleted successfully!');
    }
    public function render()
    {
        $categories = Category::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate(10);

        return view('livewire.categories.index', compact('categories'));
    }
}
