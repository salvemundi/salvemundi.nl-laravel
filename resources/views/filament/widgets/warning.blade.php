<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex flex-row justify-between items-center"  style="color: yellow" role="alert">
            <svg class="w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.29 3.86L1.82 18a1 1 0 00.86 1.5h18.64a1 1 0 00.86-1.5L13.71 3.86a1 1 0 00-1.72 0zM12 9v4m0 4h.01"></path>
            </svg>
            <div class="text-center" style="white-space: pre-line">
                <p class="font-bold">Warning: </p>
                <p>{{ $warningText }}</p>
            </div>
            <div></div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
