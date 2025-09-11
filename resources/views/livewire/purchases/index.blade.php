<div>
    <!-- HEADER -->
    <x-header title="Suppliers" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-button label="+ Create" class="btn-primary" />
        <x-slot:actions>
            @if (auth()->user()->role === 'admin')
                <x-button icon="o-plus" label="Create" link="/admin/purchases/create" class="btn-primary" />
            @else
                <x-button icon="o-plus" label="Create" link="/warehouse/purchases/create" class="btn-primary" />
            @endif
        </x-slot:actions>
    </x-header>
    <!-- TABLE  -->
    <x-card shadow>
        <x-table :headers="$headers" :rows="$purchases" :sort-by="$sortBy" with-pagination>
            @scope('actions', $purchase)
                <div class="flex items-center gap-2">
                    @if (auth()->user()->role === 'admin')
                        <x-button icon="o-eye" link="{{ route('admin.purchases.show', $purchase['id']) }}"
                            class="btn-ghost btn-sm text-green-500" />
                        <x-button icon="o-pencil" link="{{ route('admin.purchases.edit', $purchase['id']) }}"
                            class="btn-ghost btn-sm text-blue-500" />
                    @else
                        <x-button icon="o-eye" link="{{ route('warehouse.purchases.show', $purchase['id']) }}"
                            class="btn-ghost btn-sm text-green-500" />
                        <x-button icon="o-pencil" link="{{ route('warehouse.purchases.edit', $purchase['id']) }}"
                            class="btn-ghost btn-sm text-blue-500" />
                    @endif
                    <x-button icon="o-trash" wire:click="delete({{ $purchase['id'] }})" wire:confirm="Are you sure?" spinner
                        class="btn-ghost btn-sm text-error" />
                </div>
            @endscope
        </x-table>
    </x-card>
</div>
