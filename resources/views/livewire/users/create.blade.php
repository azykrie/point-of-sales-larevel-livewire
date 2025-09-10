<div>
    <x-header title="New User" separator progress-indicator>
        <x-slot:actions>
            <x-button icon="o-arrow-uturn-left" label="Discard" link="/admin/users" class="btn-ghost" />
        </x-slot:actions>
    </x-header>

    <x-form wire:submit="create">
        <x-input label="Full name" wire:model="name" error-field="name" />
        <x-input label="Email" wire:model="email" error-field="email" />
        <x-select label="Role" :options="$roles" wire:model="role" error-field="role" />
        <x-file label="Image" wire:model="avatars" accept="image/png, image/jpeg, image/jpg" />
        @if ($avatars && method_exists($avatars, 'temporaryUrl'))
            <div class="mt-4">
                <p>Image Preview:</p>
                <img src="{{ $avatars->temporaryUrl() }}" class="w-32 h-32 object-cover rounded">
            </div>
        @endif
        <x-input label="Password" type="password" wire:model="password" error-field="password" />
        <x-input label="Password Confirmation" type="password" wire:model="password_confirmation"
            error-field="password_confirmation" />

        <x-slot:actions>
            <x-button label="Save" class="btn-primary" type="submit" spinner="save5" />
        </x-slot:actions>
    </x-form>
</div>
