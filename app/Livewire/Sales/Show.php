<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Show Sale')]
class Show extends Component
{
    public $sale;

    public function mount($id)
    {
        // eager load items + product + user
        $this->sale = Sale::with(['items.product', 'user'])
            ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.sales.show');
    }
}
