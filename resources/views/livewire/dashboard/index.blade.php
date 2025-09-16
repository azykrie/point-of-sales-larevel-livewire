<div>
    <x-header title="Dashboard" separator progress-indicator>
    </x-header>

    @if (auth()->user()->role === 'admin')
        <div class="flex items-center gap-2">
            <x-stat title="Gross" value="Rp. {{ number_format($profit) }}" icon="s-banknotes" tooltip="Hello"
                color="text-primary" />

            <x-stat title="Order" value="{{ $order }}" icon="s-shopping-cart" tooltip="Hello"
                color="text-primary" />

            <x-stat title="Users" value="{{ $user }}" icon="m-user-plus" tooltip="Hello"
                color="text-primary" />

            <x-stat title="Products" value="{{ $product }}" icon="s-shopping-bag" tooltip="Hello"
                color="text-primary" />
        </div>

        <div class="grid grid-cols-5 grid-rows-5 gap-4 mt-4">
            <div class="col-span-4 row-span-5"><x-chart wire:model="dailyIncomeChart" /></div>
            <div class="row-span-2 col-start-5"><x-chart wire:model="bestSellerChart" /></div>
        </div>
    @elseif (auth()->user()->role === 'manager')
        <div class="flex items-center gap-2">
            <x-stat title="Gross" value="Rp. {{ number_format($profit) }}" icon="s-banknotes" tooltip="Hello"
                color="text-primary" />

            <x-stat title="Order" value="{{ $order }}" icon="s-shopping-cart" tooltip="Hello"
                color="text-primary" />

            <x-stat title="Users" value="{{ $user }}" icon="m-user-plus" tooltip="Hello"
                color="text-primary" />

            <x-stat title="Products" value="{{ $product }}" icon="s-shopping-bag" tooltip="Hello"
                color="text-primary" />
        </div>

        <div class="grid grid-cols-5 grid-rows-5 gap-4 mt-4">
            <div class="col-span-4 row-span-5"><x-chart wire:model="dailyIncomeChart" /></div>
            <div class="row-span-2 col-start-5"><x-chart wire:model="bestSellerChart" /></div>
        </div>
    @elseif (auth()->user()->role === 'cashier')
        <div class="flex items-center gap-2">
            <x-stat title="Order" value="{{ $order }}" icon="s-shopping-cart" tooltip="Hello"
                color="text-primary" />
            <x-stat title="Products" value="{{ $product }}" icon="s-shopping-bag" tooltip="Hello"
                color="text-primary" />
        </div>
    @elseif (auth()->user()->role === 'warehouse')
        <div class="flex items-center gap-2">
            <x-stat title="Categories" value="{{ $category }}" icon="s-shopping-cart" tooltip="Hello"
                color="text-primary" />

            <x-stat title="Suppliers" value="{{ $supplier }}" icon="m-user-plus" tooltip="Hello"
                color="text-primary" />

            <x-stat title="Products" value="{{ $product }}" icon="s-shopping-bag" tooltip="Hello"
                color="text-primary" />
        </div>
    @endif


</div>
