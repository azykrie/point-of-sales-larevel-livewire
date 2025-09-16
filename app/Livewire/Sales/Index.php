<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Sales')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $headers = [
        ['key' => 'id', 'label' => '#'],
        ['key' => 'customer_name', 'label' => 'Customer'],
        ['key' => 'payment_method', 'label' => 'Payment'],
        ['key' => 'total_amount', 'label' => 'Total'],
        ['key' => 'created_at', 'label' => 'Date'],
    ];

    public $sortBy = [
        'column' => 'id',
        'direction' => 'asc',
    ];

    public function getSalesProperty()
    {
        return Sale::query()
            ->when(
                $this->search,
                fn($q) =>
                $q->where('customer_name', 'like', "%{$this->search}%")
            )
            ->orderBy(
                $this->sortBy['column'],
                $this->sortBy['direction']
            )
            ->paginate(10)
            ->through(fn($sale) => [
                'id' => $sale->id,
                'customer_name' => $sale->customer_name,
                'payment_method' => $sale->payment_method,
                'total_amount' => $sale->total_amount,
                'created_at' => $sale->created_at->format('d M Y H:i'),
            ]);
    }

    public function render()
    {
        return view('livewire.sales.index', [
            'headers' => $this->headers,
            'sales' => $this->sales,
            'sortBy' => $this->sortBy,
        ]);
    }
}
