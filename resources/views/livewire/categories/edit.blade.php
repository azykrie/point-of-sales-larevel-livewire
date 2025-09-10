<div>
    <x-header title="New Category" separator progress-indicator>
        <x-slot:actions>
            @if (auth()->user()->role === 'admin')
                <x-button icon="o-arrow-uturn-left" label="Discard" link="/admin/categories" class="btn-ghost" />
            @else
                <x-button icon="o-arrow-uturn-left" label="Discard" link="/warehouse/categories" class="btn-ghost" />
            @endif
        </x-slot:actions>
    </x-header>

    <x-form wire:submit="update">
        <x-input label="Category Name" wire:model="name" error-field="name" />
        <x-slot:actions>
            <x-button label="Save" class="btn-primary" type="submit" spinner="save5" />
        </x-slot:actions>
    </x-form>
</div>
