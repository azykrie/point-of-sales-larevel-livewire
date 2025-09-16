<div>
    <!-- HEADER -->
    <x-header title="Sales History" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search by customer..." wire:model.live.debounce="search" clearable
                icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-button label="+ Create" class="btn-primary" />
        <x-slot:actions>
            @if (auth()->user()->role === 'admin')
                <x-button icon="o-plus" label="Create" link="/admin/sales/create" class="btn-primary" />
            @elseif (auth()->user()->role === 'cashier')
                <x-button icon="o-plus" label="Create" link="/cashier/sales/create" class="btn-primary" />
            @endif
        </x-slot:actions>
    </x-header>

    <!-- TABLE -->
    <x-card shadow>
        <x-table :headers="$headers" :rows="$sales" :sort-by="$sortBy" with-pagination>
            @scope('cell_customer_name', $sale)
                {{ $sale['customer_name'] ?? '-' }}
            @endscope

            @scope('cell_payment_method', $sale)
                <span
                    class="px-2 py-1 rounded text-xs font-medium
                    {{ $sale['payment_method'] === 'cash' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                    {{ ucfirst($sale['payment_method']) }}
                </span>
            @endscope

            @scope('cell_total_amount', $sale)
                Rp. {{ number_format($sale['total_amount'], 0, ',', '.') }}
            @endscope

            @scope('actions', $sale)
                <div class="flex items-center gap-2">
                    @if (auth()->user()->role === 'admin')
                        <x-button icon="o-eye" link="{{ route('admin.sales.show', $sale['id']) }}"
                            class="btn-ghost btn-sm text-blue-500" />
                    @elseif (auth()->user()->role === 'cashier')
                        <x-button icon="o-eye" link="{{ route('cashier.sales.show', $sale['id']) }}"
                            class="btn-ghost btn-sm text-blue-500" />
                    @elseif (auth()->user()->role === 'manager')
                        <x-button icon="o-eye" link="{{ route('manager.sales.show', $sale['id']) }}"
                            class="btn-ghost btn-sm text-blue-500" />
                    @endif
                </div>
            @endscope
        </x-table>
    </x-card>
</div>
