<div>
    <!-- HEADER -->
    <x-header title="Stock Movements" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search by product..." wire:model.live.debounce="search" clearable
                icon="o-magnifying-glass" />
        </x-slot:middle>

        <x-slot:actions>
            @if (auth()->user()->role === 'admin')
                <x-button icon="o-plus" label="Add Movement" link="{{ route('admin.stock-movements.create') }}"
                    class="btn-primary" />
            @elseif (auth()->user()->role === 'warehouse')
                <x-button icon="o-plus" label="Add Movement" link="{{ route('warehouse.stock-movements.create') }}"
                    class="btn-primary" />
            @endif
        </x-slot:actions>
    </x-header>

    <!-- TABLE -->
    <x-card shadow>
        <x-table :headers="$headers" :rows="$movements" :sort-by="$sortBy" with-pagination>
            @scope('actions', $movement)
                <div class="flex items-center gap-2">
                    @if (auth()->user()->role === 'admin')
                        <x-button icon="o-pencil" link="{{ route('admin.stock-movements.edit', $movement['id']) }}"
                            class="btn-ghost btn-sm text-blue-500" />
                    @elseif (auth()->user()->role === 'warehouse')
                        <x-button icon="o-pencil" link="{{ route('warehouse.stock-movements.edit', $movement['id']) }}"
                            class="btn-ghost btn-sm text-blue-500" />
                    @endif

                    @if (auth()->user()->role === 'admin')
                        <x-button icon="o-trash" wire:click="delete({{ $movement['id'] }})"
                            wire:confirm="Are you sure delete this record?" spinner class="btn-ghost btn-sm text-error" />
                    @elseif (auth()->user()->role === 'warehouse')
                        <x-button icon="o-trash" wire:click="delete({{ $movement['id'] }})"
                            wire:confirm="Are you sure delete this record?" spinner class="btn-ghost btn-sm text-error" />
                    @endif
                </div>
            @endscope
        </x-table>
    </x-card>
</div>
