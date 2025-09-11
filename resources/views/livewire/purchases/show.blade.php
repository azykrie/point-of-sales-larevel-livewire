<div>
    <x-header title="Purchase Detail #{{ $purchase->id }}" separator>
        <x-slot:actions>
            @if (auth()->user()->role === 'admin')
                <x-button icon="o-arrow-uturn-left" label="Back" link="/admin/purchases" class="btn-ghost" />
            @else
                <x-button icon="o-arrow-uturn-left" label="Back" link="/warehouse/purchases" class="btn-ghost" />
            @endif
        </x-slot:actions>
    </x-header>

    {{-- Info Utama --}}
    <div class="mt-4 space-y-2 bg-gray-900 border border-gray-700 rounded-lg p-4">
        <p><strong>Supplier:</strong> {{ $purchase->supplier?->name ?? '-' }}</p>
        <p><strong>Created By:</strong> {{ $purchase->user?->name ?? '-' }}</p>
        <p><strong>Total:</strong> Rp. {{ number_format($purchase->total_amount, 0, ',', '.') }}</p>
        <p><strong>Date:</strong> {{ $purchase->created_at->format('d M Y H:i') }}</p>
    </div>

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
                </tr>
            </thead>
            <tbody>
                @foreach ($purchase->items as $item)
                    <tr class="even:bg-gray-900">
                        <td class="p-2 border border-gray-700">
                            {{ $item->product?->name ?? '-' }}
                        </td>
                        <td class="p-2 border border-gray-700 text-center">
                            {{ $item->quantity }}
                        </td>
                        <td class="p-2 border border-gray-700 text-right">
                            Rp. {{ number_format($item->price, 0, ',', '.') }}
                        </td>
                        <td class="p-2 border border-gray-700 text-right">
                            Rp. {{ number_format($item->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4 text-right font-bold text-lg">
            Total: Rp. {{ number_format($purchase->total_amount, 0, ',', '.') }}
        </div>
    </div>
</div>
