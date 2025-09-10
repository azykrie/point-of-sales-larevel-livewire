<div>
    <!-- HEADER -->
    <x-header title="Users" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Search..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass" />
        </x-slot:middle>
        <x-button label="+ Create" class="btn-primary" />
        <x-slot:actions>
            <x-button icon="o-plus" label="Create" link="/admin/users/create" class="btn-primary" />
        </x-slot:actions>
    </x-header>
    <!-- TABLE  -->
    <x-card shadow>
        <x-table :headers="$headers" :rows="$users" :sort-by="$sortBy" with-pagination>
            @scope('actions', $user)
                <div class="flex items-center gap-2">
                    <x-button icon="o-pencil" link="{{ route('admin.users.edit', $user['id']) }}"
                        class="btn-ghost btn-sm text-blue-500" />

                    <x-button icon="o-trash" wire:click="delete({{ $user['id'] }})" wire:confirm="Are you sure?" spinner
                        class="btn-ghost btn-sm text-error" />
                </div>
            @endscope
        </x-table>
    </x-card>
</div>
