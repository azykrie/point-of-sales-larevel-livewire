<div class="max-w-2xl mx-auto">
    <x-header title="My Profile" separator>
        <x-slot:actions>
            @if (auth()->user()->role === 'admin')
                <x-button icon="o-arrow-uturn-left" label="Back to dashboard" link="/admin/dashboard" class="btn-ghost" />
            @elseif (auth()->user()->role === 'manager')
                <x-button icon="o-arrow-uturn-left" label="Back to dashboard" link="/manager/dashboard" class="btn-ghost" />
            @elseif (auth()->user()->role === 'cashier')
                <x-button icon="o-arrow-uturn-left" label="Back to dashboard" link="/cashier/dashboard/" class="btn-ghost" />
            @elseif (auth()->user()->role === 'warehouse')
                <x-button icon="o-arrow-uturn-left" label="Back to dashboard" link="/warehouse/dashboard" class="btn-ghost" />
            @endif
        </x-slot:actions>
    </x-header>

    <x-form wire:submit="update" class="card shadow-lg p-6 space-y-6">
        <!-- Avatar Section -->
        <div class="flex flex-col items-center space-y-4">
            @if ($avatars && method_exists($avatars, 'temporaryUrl'))
                <img src="{{ $avatars->temporaryUrl() }}"
                    class="w-32 h-32 rounded-full object-cover shadow-md border" />
            @elseif($oldAvatar)
                <img src="{{ Storage::url($oldAvatar) }}"
                    class="w-32 h-32 rounded-full object-cover shadow-md border" />
            @else
                <div class="w-32 h-32 flex items-center justify-center rounded-full bg-gray-200 shadow-md">
                    <x-icon name="o-user" class="w-12 h-12 text-gray-500" />
                </div>
            @endif

            <x-file label="Change Avatar" wire:model="avatars" accept="image/png, image/jpeg, image/jpg" />
            @error('avatars')
                <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <!-- Profile Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input label="Full Name" wire:model="name" error-field="name" />
            <x-input label="Email Address" wire:model="email" error-field="email" />
        </div>

        <!-- Password Update -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input label="New Password" type="password" wire:model="password" error-field="password" />
            <x-input label="Confirm Password" type="password" wire:model="password_confirmation" />
        </div>

        <!-- Submit -->
        <div class="flex justify-end">
            <x-button label="Save Changes" class="btn-primary" type="submit" spinner="update" />
        </div>
    </x-form>
</div>
