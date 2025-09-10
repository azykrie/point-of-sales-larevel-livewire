<div>
    <!-- HEADER -->
    <x-header title="Categories" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-button label="+ Create" class="btn-primary" />
        <x-slot:actions>
            @if (auth()->user()->role === 'admin')
                <x-button icon="o-plus" label="Create" link="/admin/categories/create" class="btn-primary" />
            @else
                <x-button icon="o-plus" label="Create" link="/warehouse/categories/create" class="btn-primary" />
            @endif
        </x-slot:actions>
    </x-header>
    <!-- TABLE  -->
    <x-card shadow>
        <x-table :headers="$headers" :rows="$categories" :sort-by="$sortBy" with-pagination>
            @scope('actions', $category)
                <div class="flex items-center gap-2">
                    @if (auth()->user()->role === 'admin')
                        <x-button icon="o-pencil" link="{{ route('admin.categories.edit', $category['id']) }}"
                            class="btn-ghost btn-sm text-blue-500" />
                    @else
                        <x-button icon="o-pencil" link="{{ route('warehouse.categories.edit', $category['id']) }}"
                            class="btn-ghost btn-sm text-blue-500" />
                    @endif
                    <x-button icon="o-trash" wire:click="delete({{ $category['id'] }})" wire:confirm="Are you sure?" spinner
                        class="btn-ghost btn-sm text-error" />
                </div>
            @endscope
        </x-table>
    </x-card>
</div>
