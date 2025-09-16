<div>
    <x-header title="New Stock Movement" separator progress-indicator>
        <x-slot:actions>
            @if (auth()->user()->role === 'admin')
                <x-button icon="o-arrow-uturn-left" label="Discard" link="/admin/stock-movements" class="btn-ghost" />
            @elseif (auth()->user()->role === 'warehouse')
                <x-button icon="o-arrow-uturn-left" label="Discard" link="/warehouse/stock-movements" class="btn-ghost" />
            @endif
        </x-slot:actions>
    </x-header>

    <x-form wire:submit="save">
        <x-select label="Product" wire:model="product_id" :options="$products" option-label="name" option-value="id"
            placeholder="-- Select Product --" />


        <x-select label="Type" wire:model="type" :options="[['id' => 'in', 'name' => 'Stock In'], ['id' => 'out', 'name' => 'Stock Out']]" option-label="name" option-value="id" />

        <x-input type="number" label="Quantity" wire:model="quantity" min="1" />

        <x-input label="Note" wire:model="note" />

        <x-slot:actions>
            <x-button label="Save" class="btn-primary" type="submit" />
        </x-slot:actions>
    </x-form>
</div>
