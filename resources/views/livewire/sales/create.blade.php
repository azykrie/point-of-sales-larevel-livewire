<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- LEFT: SALES FORM -->
    <div class="md:col-span-2">
        <x-form wire:submit="create">
            <x-input label="Customer Name" wire:model="customer_name" placeholder="Enter customer name" />

            <x-select label="Payment Method" wire:model="payment_method" :options="[
                ['id' => 'cash', 'name' => 'Cash'],
                ['id' => 'transfer', 'name' => 'Transfer'],
                ['id' => 'qris', 'name' => 'QRIS'],
            ]" option-label="name"
                option-value="id" />

            <div class="mt-6">
                <h3 class="font-semibold mb-2">Products</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm border">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="p-2 border">Product</th>
                                <th class="p-2 border">Stock</th>
                                <th class="p-2 border">Qty</th>
                                <th class="p-2 border">Price</th>
                                <th class="p-2 border">Subtotal</th>
                                <th class="p-2 border">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $index => $item)
                                @php
                                    $product = $products->firstWhere('id', $item['product_id']);
                                @endphp
                                <tr>
                                    <td class="p-2 border">{{ $product->name ?? '-' }}</td>
                                    <td class="p-2 border text-center">{{ $product->stock ?? '-' }}</td>
                                    <td class="p-2 border text-center">{{ $item['quantity'] }}</td>
                                    <td class="p-2 border text-right">
                                        Rp. {{ number_format($item['price'] ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="p-2 border text-right">
                                        Rp. {{ number_format($item['subtotal'] ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="p-2 border text-center">
                                        <x-button label="Remove" wire:click="removeItem({{ $index }})"
                                            class="btn-error btn-xs" />
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-4 text-center text-gray-500">
                                        No products added yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 text-right">
                <p class="font-bold text-lg">
                    Total: Rp. {{ number_format($totalAmount, 0, ',', '.') }}
                </p>
            </div>

            <x-slot:actions>
                <x-button label="Save Sale" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    </div>

    <!-- RIGHT: ADD TO CART -->
    <div>
        <x-card shadow class="mb-4 max-w-sm mx-auto">
            <h3 class="font-semibold text-base mb-3">Add Product to Cart</h3>
            <x-form wire:submit="addStock" class="space-y-2">
                <x-select label="Product" wire:model="stock_product_id" :options="$products" option-label="name"
                    option-value="id" placeholder="Select Product" />

                <x-input label="Qty" type="number" wire:model="stock_quantity" min="1" />

                <x-slot:actions>
                    <x-button label="Add to Cart" class="btn-primary btn-sm w-full" type="submit" />
                </x-slot:actions>
            </x-form>
        </x-card>
    </div>
</div>
