<?php

namespace App\Livewire\Purchases;

use App\Models\Purchase;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Purchases')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

    public $headers = [
        ['key' => 'id', 'label' => 'ID'],
        ['key' => 'supplier', 'label' => 'Supplier'],
        ['key' => 'user', 'label' => 'Created By'],
        ['key' => 'total_amount', 'label' => 'Total'],
    ];

    public $sortBy = [
        'column' => 'id',
        'direction' => 'asc',
    ];

    public function updated($property): void
    {
        if (!is_array($property) && $property !== '') {
            $this->resetPage();
        }
    }

    public function delete($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->delete();
        $this->dispatch('success', message: 'Purchase deleted successfully!');
    }

    public function render()
    {
        $purchases = Purchase::with(['supplier', 'user'])
            ->when($this->search, function ($query) {
                $search = '%' . $this->search . '%';

                $query->where(function ($q) use ($search) {
                    $q->whereHas('supplier', fn($q) => $q->where('name', 'like', $search))
                        ->orWhereHas('user', fn($q) => $q->where('name', 'like', $search))
                        ->orWhere('total_amount', 'like', $search);
                });
            })
            ->when($this->sortBy['column'] === 'supplier', function ($query) {
                $query->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
                    ->orderBy('suppliers.name', $this->sortBy['direction'])
                    ->select('purchases.*');
            })
            ->when($this->sortBy['column'] === 'user', function ($query) {
                $query->join('users', 'purchases.user_id', '=', 'users.id')
                    ->orderBy('users.name', $this->sortBy['direction'])
                    ->select('purchases.*');
            }, function ($query) {
                $query->orderBy($this->sortBy['column'], $this->sortBy['direction']);
            })
            ->paginate(10)
            ->through(function ($purchase) {
                return [
                    'id' => $purchase->id,
                    'supplier' => $purchase->supplier?->name ?? '-',
                    'user' => $purchase->user?->name ?? '-',
                    'total_amount' => 'Rp. ' . number_format($purchase->total_amount, 0, ',', '.'),
                ];
            });

        return view('livewire.purchases.index', compact('purchases'));
    }
}
