@props(['name', 'show' => false, 'maxWidth' => '2xl', 'focusable' => false])

<div
    x-data="{ show: @js($show) }"
    x-show="show"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto px-4 py-6 sm:px-0"
    style="display: none;"
>
    <div class="fixed inset-0 bg-gray-500/75" x-on:click="show = false"></div>

    <div
        class="relative w-full max-w-{{ $maxWidth }} rounded-lg bg-white shadow-xl"
        x-on:click.stop
    >
        {{ $slot }}
    </div>
</div>
