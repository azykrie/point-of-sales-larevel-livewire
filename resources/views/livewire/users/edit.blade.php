<div>
    <x-header title="Edit User" separator progress-indicator>
        <x-slot:actions>
            <x-button icon="o-arrow-uturn-left" label="Back" link="/admin/users" class="btn-ghost" />
        </x-slot:actions>
    </x-header>

    <x-form wire:submit="update">
        <x-input label="Full name" wire:model="name" error-field="name" />
        <x-input label="Email" wire:model="email" error-field="email" />
        <x-select label="Role" :options="$roles" wire:model="role" error-field="role" />
        <x-file label="Image" wire:model="avatars" accept="image/png, image/jpeg, image/jpg" />

        @if ($avatars && method_exists($avatars, 'temporaryUrl'))
            <div class="mt-4">
                <p>Image Preview:</p>
                <img src="{{ $avatars->temporaryUrl() }}" class="w-32 h-32 object-cover rounded">
            </div>
        @elseif($oldAvatar)
            <div class="mt-4">
                <p>Current Image:</p>
                <img src="{{ Storage::url($oldAvatar) }}" class="w-32 h-32 object-cover rounded">
            </div>
        @endif


        <x-input label="Password (leave blank if not changing)" type="password" wire:model="password"
            error-field="password" />
        <x-input label="Password Confirmation" type="password" wire:model="password_confirmation"
            error-field="password_confirmation" />

        <x-slot:actions>
            <x-button label="Update" class="btn-primary" type="submit" spinner="update" />
        </x-slot:actions>
    </x-form>
</div>
