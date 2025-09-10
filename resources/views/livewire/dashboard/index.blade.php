<div>
    <!-- HEADER -->
    <x-header title="Dashboard" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-dropdown>
                <x-menu-item title="Archive" icon="o-archive-box" />
                <x-menu-item title="Remove" icon="o-trash" />
                <x-menu-item title="Restore" icon="o-arrow-path" />
            </x-dropdown>
        </x-slot:middle>
    </x-header>

    <!-- STATS -->
    <div class="flex items-center gap-2">
        <x-stat title="Gross" value="Rp. 100.000" icon="s-banknotes" tooltip="Hello" color="text-primary" />

        <x-stat title="Order" value="44" icon="s-shopping-cart" tooltip="Hello" color="text-primary" />

        <x-stat title="Users" value="13" icon="m-user-plus" tooltip="Hello" color="text-primary" />

        <x-stat title="Products" value="44" icon="s-shopping-bag" tooltip="Hello" color="text-primary" />
    </div>

    <!-- CHART -->
    <div class="my-4">
        <x-chart wire:model="myChart" />
    </div>
</div>
