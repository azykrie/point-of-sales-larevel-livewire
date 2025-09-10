<div>
    <x-header title="New Product" separator progress-indicator>
        <x-slot:actions>
            @if (auth()->user()->role === 'admin')
                <x-button icon="o-arrow-uturn-left" label="Discard" link="/admin/products" class="btn-ghost" />
            @else
                <x-button icon="o-arrow-uturn-left" label="Discard" link="/warehouse/products" class="btn-ghost" />
            @endif
        </x-slot:actions>
    </x-header>

    <x-form wire:submit="create">
        <x-input label="Product Name" wire:model="name" error-field="name" />
        <x-input label="Brand" wire:model="brand" error-field="brand" />
        <x-input label="Purchase Price" type="number" wire:model="purchase_price" error-field="purchase_price"
            prefix="Rp" />
        <x-input label="Selling Price" type="number" wire:model="selling_price" error-field="selling_price"
            prefix="Rp" />
        <x-input label="Stock" type="number" wire:model="stock" error-field="stock" />

        <x-select label="Category" wire:model="category_id" :options="$categories" option-label="name" option-value="id"
            error-field="category_id" placeholder="Select Category" />

        <x-slot:actions>
            <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>
</div>
