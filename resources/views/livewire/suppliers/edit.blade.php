<div>
    <x-header title="Edit Supplier" separator progress-indicator>
        <x-slot:actions>
            @if (auth()->user()->role === 'admin')
                <x-button icon="o-arrow-uturn-left" label="Back" link="/admin/suppliers" class="btn-ghost" />
            @else
                <x-button icon="o-arrow-uturn-left" label="Back" link="/warehouse/suppliers" class="btn-ghost" />
            @endif
        </x-slot:actions>
    </x-header>

    <x-form wire:submit="update">
        <x-input label="Supplier Name" wire:model="name" error-field="name" />
        <x-input label="Address" wire:model="address" error-field="address" />
        <x-input label="Phone Number" wire:model="phone_number" error-field="phone_number" />

        <x-slot:actions>
            <x-button label="Update" class="btn-primary" type="submit" spinner="update" />
        </x-slot:actions>
    </x-form>
</div>
