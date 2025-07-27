<div class="relative w-full" x-data="{ open: false }">
    <label class="input rounded-full border-purple-600 border-2 w-full bg-white">
        <!-- icon -->
        <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.3-4.3"></path>
            </g>
        </svg>

        <!-- Search input -->
        <input type="search" class="grow text-black" placeholder="Search" wire:model.live.debounce.200ms="query"
            x-ref="searchInput" @keydown.window.ctrl.k.prevent="$refs.searchInput.focus()"
            @keydown.window.meta.k.prevent="$refs.searchInput.focus()" @focus="open = true"
            @blur="setTimeout(() => open = false, 150)">

        <kbd class="kbd kbd-sm bg-purple-600">⌘</kbd>
        <kbd class="kbd kbd-sm bg-purple-600">K</kbd>
    </label>
    <!-- Dropdown results -->
    @if($query && $results->isNotEmpty())
    <ul x-show="open" x-transition
        class="absolute z-20 w-full mt-1 bg-white text-gray-800 border rounded-md shadow-lg max-h-80 overflow-y-auto">
        @foreach($results as $product)
        <li>
            <a href="{{ route('product.details', $product->slug) }}"
                class="flex items-center gap-3 px-3 py-2 hover:bg-purple-50">
                <img src="{{ $product->first_image_path ? Storage::url($product->first_image_path) : asset('images/no-image.webp') }}"
                    class="w-10 h-10 object-cover rounded" onerror="this.src='{{ asset('images/no-image.webp') }}'">
                <div>
                    <p class="text-sm font-medium truncate">{{ $product->name }}</p>
                    <p class="text-xs text-gray-500">${{ number_format($product->price, 2) }}</p>
                </div>
            </a>
        </li>
        @endforeach
    </ul>
    @endif
</div>
