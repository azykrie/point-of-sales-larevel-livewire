<div>
    <x-header title="New Purchase" separator progress-indicator>
        <x-slot:actions>
            @if (auth()->user()->role === 'admin')
                <x-button icon="o-arrow-uturn-left" label="Discard" link="/admin/purchases" class="btn-ghost" />
            @else
                <x-button icon="o-arrow-uturn-left" label="Discard" link="/warehouse/purchases" class="btn-ghost" />
            @endif
        </x-slot:actions>
    </x-header>

    <x-form wire:submit="create">
        {{-- Supplier --}}
        <x-select label="Supplier" wire:model="supplier_id" :options="$suppliers" option-label="name" option-value="id"
            error-field="supplier_id" placeholder="Select Supplier" />

        {{-- Items --}}
        <div class="mt-6">
            <h3 class="font-semibold mb-2">Items</h3>

            <table class="w-full text-sm border">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="p-2 border">Product</th>
                        <th class="p-2 border">Qty</th>
                        <th class="p-2 border">Price</th>
                        <th class="p-2 border">Subtotal</th>
                        <th class="p-2 border"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $index => $item)
                        <tr>
                            <td class="p-2 border">
                                <x-select wire:model="items.{{ $index }}.product_id" :options="$products"
                                    option-label="name" option-value="id" placeholder="Select Product" />
                            </td>
                            <td class="p-2 border">
                                <x-input type="number" wire:model.lazy="items.{{ $index }}.quantity"
                                    min="1" />
                            </td>
                            <td class="p-2 border"><x-input type="number"
                                    wire:model.lazy="items.{{ $index }}.price" min="0" prefix="Rp" />
                            </td>
                            <td class="p-2 border">
                                Rp. {{ number_format($items[$index]['subtotal'] ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="p-2 border text-center">
                                <x-button icon="o-trash" wire:click="removeItem({{ $index }})"
                                    class="btn-ghost btn-sm" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-2">
                <x-button label="Add Item" wire:click="addItem" class="btn-outline btn-sm" />
            </div>
        </div>

        {{-- Total --}}
        <div class="mt-6 text-right">
            <p class="font-bold text-lg">
                Total: Rp. {{ number_format($totalAmount, 0, ',', '.') }}
            </p>
        </div>

        {{-- Actions --}}
        <x-slot:actions>
            <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>
</div>
