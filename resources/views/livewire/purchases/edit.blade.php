<div>
    <x-header title="Edit Purchase" separator progress-indicator>
        <x-slot:actions>
            <x-button icon="o-arrow-uturn-left" 
                label="Back" 
                link="{{ auth()->user()->role === 'admin' ? '/admin/purchases' : '/warehouse/purchases' }}" 
                class="btn-ghost" />
        </x-slot:actions>
    </x-header>

    <x-form wire:submit="update">
        {{-- Supplier --}}
        <x-select label="Supplier" 
            wire:model="supplier_id" 
            :options="$suppliers"
            option-label="name" option-value="id"
            placeholder="Select Supplier" 
            error-field="supplier_id" />

        {{-- Items --}}
        <div class="mt-6">
            <h3 class="font-semibold mb-2">Items</h3>

            <table class="w-full text-sm border border-gray-700 rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-gray-200">
                    <tr>
                        <th class="p-2 border border-gray-700">Product</th>
                        <th class="p-2 border border-gray-700">Qty</th>
                        <th class="p-2 border border-gray-700">Price</th>
                        <th class="p-2 border border-gray-700">Subtotal</th>
                        <th class="p-2 border border-gray-700"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $index => $item)
                        <tr class="even:bg-gray-900">
                            <td class="p-2 border border-gray-700">
                                <x-select wire:model="items.{{ $index }}.product_id"
                                    :options="$products"
                                    option-label="name" option-value="id"
                                    placeholder="Select Product" />
                            </td>
                            <td class="p-2 border border-gray-700">
                                <x-input type="number" min="1"
                                    wire:model.lazy="items.{{ $index }}.quantity" />
                            </td>
                            <td class="p-2 border border-gray-700">
                                <x-input type="number" min="0" prefix="Rp"
                                    wire:model.lazy="items.{{ $index }}.price" />
                            </td>
                            <td class="p-2 border border-gray-700">
                                Rp. {{ number_format($items[$index]['subtotal'] ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="p-2 border border-gray-700 text-center">
                                <x-button icon="o-trash"
                                    wire:click="removeItem({{ $index }})"
                                    class="btn-ghost btn-sm text-red-400 hover:text-red-600" />
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
            <x-button label="Update" type="submit" class="btn-primary" spinner="update" />
        </x-slot:actions>
    </x-form>
</div>
