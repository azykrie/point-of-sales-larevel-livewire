<?php

namespace App\Livewire\Purchases;

use App\Models\Purchase;
use Livewire\Component;

class Show extends Component
{
    public $purchase;

    public function mount($id)
    {
        $this->purchase = Purchase::with(['supplier', 'user', 'items.product'])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.purchases.show');
    }
}
