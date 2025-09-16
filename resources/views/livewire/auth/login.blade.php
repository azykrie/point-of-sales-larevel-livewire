<div>
    <div class="md:w-96 mx-auto mt-50">
        <div class="mb-10">
            <x-app-brand />
        </div>

        {{-- Pesan error --}}
        @if (session('error'))
            <div class="mb-4 text-red-600 bg-red-100 p-2 rounded">
                {{ session('error') }}
            </div>
        @endif

        {{-- Pesan sukses --}}
        @if (session('message'))
            <div class="mb-4 text-green-600 bg-green-100 p-2 rounded">
                {{ session('message') }}
            </div>
        @endif

        <x-form wire:submit="login">
            <x-input placeholder="E-mail" wire:model="email" icon="o-envelope" />
            <x-input placeholder="Password" wire:model="password" type="password" icon="o-key" />

            <x-slot:actions>
                <x-button label="Login" type="submit" icon="o-paper-airplane" class="btn-primary" spinner="login" />
            </x-slot:actions>
        </x-form>
    </div>
</div>
