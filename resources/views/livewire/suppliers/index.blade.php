<div>
    <!-- HEADER -->
    <x-header title="Suppliers" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-button label="+ Create" class="btn-primary" />
        <x-slot:actions>
            @if (auth()->user()->role === 'admin')
                <x-button icon="o-plus" label="Create" link="/admin/suppliers/create" class="btn-primary" />
            @else
                <x-button icon="o-plus" label="Create" link="/warehouse/suppliers/create" class="btn-primary" />
            @endif
        </x-slot:actions>
    </x-header>
    <!-- TABLE  -->
    <x-card shadow>
        <x-table :headers="$headers" :rows="$suppliers" :sort-by="$sortBy" with-pagination>
            @scope('actions', $supplier)
                <div class="flex items-center gap-2">
                    @if (auth()->user()->role === 'admin')
                        <x-button icon="o-pencil" link="{{ route('admin.suppliers.edit', $supplier['id']) }}"
                            class="btn-ghost btn-sm text-blue-500" />
                    @else
                        <x-button icon="o-pencil" link="{{ route('warehouse.suppliers.edit', $supplier['id']) }}"
                            class="btn-ghost btn-sm text-blue-500" />
                    @endif
                    <x-button icon="o-trash" wire:click="delete({{ $supplier['id'] }})" wire:confirm="Are you sure?" spinner
                        class="btn-ghost btn-sm text-error" />
                </div>
            @endscope
        </x-table>
    </x-card>
</div>
