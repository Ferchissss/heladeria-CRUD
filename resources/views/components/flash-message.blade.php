@props(['type' => 'success'])

@php
    $colors = [
        'success' => 'bg-green-500',
        'error' => 'bg-red-500',
        'warning' => 'bg-yellow-500',
        'info' => 'bg-blue-500'
    ];
    $color = $colors[$type] ?? $colors['success'];
@endphp

<div id="flash-message-container" class="fixed top-4 right-4 z-[100] space-y-2 hidden">
    <div x-data="{ show: false, message: '', type: '' }"
         x-show="show"
         x-init="
            @this.on('flash-message', (data) => {
                message = data.message;
                type = data.type;
                show = true;
                setTimeout(() => { show = false }, 3000);
            });
            @if(session('flash'))
                show = true;
                message = '{{ session('flash.message') }}';
                type = '{{ session('flash.type', 'success') }}';
                setTimeout(() => { show = false }, 3000);
            @endif
         "
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         :class="{
             'bg-green-500': type === 'success',
             'bg-red-500': type === 'error',
             'bg-yellow-500': type === 'warning',
             'bg-blue-500': type === 'info'
         }"
         class="text-white px-4 py-2 rounded-lg shadow-lg flex items-center justify-between min-w-[300px]">
        <span x-text="message"></span>
        <button @click="show = false" class="ml-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
</div>