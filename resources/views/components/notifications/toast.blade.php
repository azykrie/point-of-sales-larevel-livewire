{{-- notif realtime tanpa reload success --}}
<div x-data="{ show: false, message: '' }"
    x-on:success.window="show = true; message = $event.detail.message; setTimeout(() => show = false, 3000)"
    x-show="show" class="fixed top-4 right-4 z-50" x-transition x-cloak>
    <x-alert class="alert-success shadow-lg rounded-lg px-4 py-2 inline-flex items-center gap-2 w-auto">
        <x-icon name="o-check" class="w-5 h-5" />
        <span x-text="message"></span>
    </x-alert>
</div>

{{-- notif realtime tanpa reload error --}}
<div x-data="{ show: false, message: '' }"
    x-on:error.window="show = true; message = $event.detail.message; setTimeout(() => show = false, 3000)" x-show="show"
    class="fixed top-20 right-4 z-50" x-transition x-cloak>
    <x-alert class="alert-error shadow-lg rounded-lg px-4 py-2 inline-flex items-center gap-2 w-auto">
        <x-icon name="o-x-circle" class="w-5 h-5" />
        <span x-text="message"></span>
    </x-alert>
</div>


{{-- notif flash setelah redirect success --}}
@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="fixed top-4 right-4 z-50" x-transition
        x-cloak>
        <x-alert class="alert-success shadow-lg rounded-lg px-4 py-2 inline-flex items-center gap-2 w-auto">
            <x-icon name="o-check" class="w-5 h-5" />
            <span>{{ session('success') }}</span>
        </x-alert>
    </div>
@endif
