<div>
    <x-header title="New Supplier" separator progress-indicator>
        <x-slot:actions>
            @if (auth()->user()->role === 'admin')
                <x-button icon="o-arrow-uturn-left" label="Discard" link="/admin/suppliers" class="btn-ghost" />
            @else
                <x-button icon="o-arrow-uturn-left" label="Discard" link="/warehouse/suppliers" class="btn-ghost" />
            @endif
        </x-slot:actions>
    </x-header>

    <x-form wire:submit="create">
        <x-input label="Supplier Name" wire:model="name" error-field="name" />
        <x-input label="Address" wire:model="address" error-field="address" />
        <x-input label="Phone Number" wire:model="phone_number" error-field="phone_number" />

        <x-slot:actions>
            <x-button label="Save" class="btn-primary" type="submit" spinner="create" />
        </x-slot:actions>
    </x-form>
</div>
