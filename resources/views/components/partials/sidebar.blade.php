<x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

    {{-- BRAND --}}
    <x-app-brand class="px-5 pt-4" />

    {{-- MENU --}}
    <x-menu activate-by-route>

        {{-- User --}}
        @if ($user = auth()->user())
            <x-menu-separator />
            <x-list-item :item="$user" value="name" sub-value="email" avatar="avatar_url" no-separator no-hover
                class="-mx-2 !-my-2 rounded">
                <x-slot:actions>
                    <x-dropdown>
                        <x-slot:trigger>
                            <x-button icon="o-cog" class="btn-circle" />
                        </x-slot:trigger>

                        {{-- Profile --}}
                        @if ($user->role === 'admin')
                            <x-menu-item title="Profile" icon="o-user"
                                link="{{ route('admin.users.profile', $user->id) }}" />
                        @elseif ($user->role === 'manager')
                            <x-menu-item title="Profile" icon="o-user"
                                link="{{ route('manager.users.profile', $user->id) }}" />
                        @elseif ($user->role === 'cashier')
                            <x-menu-item title="Profile" icon="o-user"
                                link="{{ route('cashier.users.profile', $user->id) }}" />
                        @elseif ($user->role === 'warehouse')
                            <x-menu-item title="Profile" icon="o-user"
                                link="{{ route('warehouse.users.profile', $user->id) }}" />
                        @endif


                        {{-- Logout --}}
                        <livewire:auth.logout />

                        {{-- Theme Menu --}}
                        <x-menu-item title="Theme" icon="o-swatch" @click="$dispatch('mary-toggle-theme')" />

                        {{-- Theme toggle --}}
                        <x-theme-toggle class="hidden" />

                    </x-dropdown>
                </x-slot:actions>

            </x-list-item>

            <x-menu-separator />
        @endif

        {{-- Admin Menu --}}
        @if ($user && $user->role === 'admin')
            <x-menu-item title="Dashboard" icon="o-chart-pie" link="/admin/dashboard" />
            <x-menu-item title="Users" icon="o-user" link="/admin/users" />
            <x-menu-item title="Categories" icon="o-hashtag" link="/admin/categories" />
            <x-menu-item title="Products" icon="o-cube" link="/admin/products" />
            <x-menu-item title="Suppliers" icon="o-users" link="/admin/suppliers" />
            <x-menu-item title="Purchases" icon="o-shopping-cart" link="/admin/purchases" />
            <x-menu-item title="Sales" icon="o-shopping-bag" link="/admin/sales" />
            <x-menu-item title="Stock Movement" icon="o-archive-box" link="/admin/stock-movements" />
        @endif

        {{-- Manager Menu --}}
        @if ($user && $user->role === 'manager')
            <x-menu-item title="Dashboard" icon="o-chart-pie" link="/manager/dashboard" />
            <x-menu-item title="Sales" icon="o-shopping-bag" link="/manager/sales" />
            <x-menu-item title="Stock Movement" icon="o-archive-box" link="/manager/stock-movements" />
        @endif

        {{-- Cashier Menu --}}
        @if ($user && $user->role === 'cashier')
            <x-menu-item title="Dashboard" icon="o-chart-pie" link="/cashier/dashboard" />
            <x-menu-item title="Sales" icon="o-shopping-bag" link="/cashier/sales" />
        @endif

        {{-- Warehouse Menu --}}
        @if ($user && $user->role === 'warehouse')
            <x-menu-item title="Dashboard" icon="o-chart-pie" link="/warehouse/dashboard" />
            <x-menu-item title="Categories" icon="o-hashtag" link="/warehouse/categories" />
            <x-menu-item title="Products" icon="o-cube" link="/warehouse/products" />
            <x-menu-item title="Suppliers" icon="o-users" link="/warehouse/suppliers" />
            <x-menu-item title="Purchases" icon="o-shopping-cart" link="/warehouse/purchases" />
            <x-menu-item title="Stock Movement" icon="o-archive-box" link="/warehouse/stock-movements" />
        @endif
    </x-menu>
</x-slot:sidebar>
