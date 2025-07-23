<div>
    <style>
        .card :where(figure:first-child) {
            border-start-start-radius: unset;
            border-start-end-radius: unset;
        }

        .subscribe-btn {
            position: relative;
            overflow: hidden;
        }

        .subscribe-text {
            transition: transform 0.2s ease-in-out;
            transform: translateY(0);
        }

        .cart-icon {
            position: absolute;
            left: 50%;
            transform: translateX(-50%) translateY(130%);
            transition: transform 0.2s ease-in-out;
        }

        .subscribe-btn:hover .subscribe-text {
            transform: translateY(-100%);
        }

        .subscribe-btn:hover .cart-icon {
            transform: translateX(-50%) translateY(0);
        }

        span.relative.inline-flex.items-center.px-2.py-2.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.cursor-default.rounded-l-md.leading-5.dark\:bg-gray-800.dark\:border-gray-600,
        span.relative.inline-flex.items-center.px-4.py-2.-ml-px.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.cursor-default.leading-5.dark\:bg-gray-800.dark\:border-gray-600,
        button.relative.inline-flex.items-center.px-2.py-2.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.rounded-l-md.leading-5.hover\:text-gray-400.focus\:z-10.focus\:outline-none.focus\:border-blue-300.focus\:ring.ring-blue-300.active\:bg-gray-100.active\:text-gray-500.transition.ease-in-out.duration-150.dark\:bg-gray-800.dark\:border-gray-600.dark\:active\:bg-gray-700.dark\:focus\:border-blue-800,
        span.relative.inline-flex.items-center.px-2.py-2.-ml-px.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.cursor-default.rounded-r-md.leading-5.dark\:bg-gray-800.dark\:border-gray-600 {
            background-color: rgb(119, 32, 182);
        }

        button.relative.inline-flex.items-center.px-4.py-2.-ml-px.text-sm.font-medium.text-gray-700.bg-white.border.border-gray-300.leading-5.hover\:text-gray-500.focus\:z-10.focus\:outline-none.focus\:border-blue-300.focus\:ring.ring-blue-300.active\:bg-gray-100.active\:text-gray-700.transition.ease-in-out.duration-150.dark\:bg-gray-800.dark\:border-gray-600.dark\:text-gray-400.dark\:hover\:text-gray-300.dark\:active\:bg-gray-700.dark\:focus\:border-blue-800,
        button.relative.inline-flex.items-center.px-2.py-2.-ml-px.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.rounded-r-md.leading-5.hover\:text-gray-400.focus\:z-10.focus\:outline-none.focus\:border-blue-300.focus\:ring.ring-blue-300.active\:bg-gray-100.active\:text-gray-500.transition.ease-in-out.duration-150.dark\:bg-gray-800.dark\:border-gray-600.dark\:active\:bg-gray-700.dark\:focus\:border-blue-800 {
            background-color: #9333ea;
        }
    </style>
    <h1 class="text-black text-3xl font-semibold">Product Listing</h1>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-8 text-black">
        <!-- FILTERS PANEL -->
        <aside class="hidden md:block lg:col-span-3 p-4">
            <h2 class="text-black text-2xl mb-4">Filter</h2>

            <fieldset class="border border-purple-500 rounded-box p-4 w-full max-w-md">
                <legend class="text-sm font-medium text-purple-600 px-2">Filter by Price</legend>

                <div class="flex flex-col sm:flex-row gap-3 mt-2">
                    <input type="number" class="input input-bordered w-full sm:w-1/2 bg-white border-purple-600"
                        placeholder="Min (${{ number_format($allMin, 0) }})" wire:model.defer="minPrice" min="0"
                        max="{{ $allMax }}" />

                    <input type="number" class="input input-bordered w-full sm:w-1/2 bg-white border-purple-600"
                        placeholder="Max (${{ number_format($allMax, 0) }})" wire:model.defer="maxPrice"
                        min="{{ $minPrice ?: 0 }}" max="{{ $allMax }}" />
                </div>

                {{-- Filter Button --}}
                <button wire:click="filter"
                    class="mt-3 w-full btn bg-purple-600 hover:bg-purple-700 border-0 text-white text-sm">
                    Apply Filter
                </button>

                <!-- Show current filter status -->
                @if ($applyFilter && ($minPrice !== '' || $maxPrice !== ''))
                <div class="mt-3 p-2 bg-purple-50 rounded-lg border border-purple-200">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-purple-700">
                            Active: ${{ $minPrice ?: '0' }} - ${{ $maxPrice ?: number_format($allMax, 0) }}
                        </span>
                        <button wire:click="clearFilters"
                            class="text-xs text-purple-600 hover:text-purple-800 underline">
                            Clear
                        </button>
                    </div>
                </div>
                @endif

                <!-- Price range indicator -->
                <div class="mt-3 text-xs text-gray-500">
                    Price range: ${{ number_format($allMin, 0) }} - ${{ number_format($allMax, 0) }}
                </div>

                @error('minPrice')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
                @error('maxPrice')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </fieldset>
        </aside>

        <!-- PRODUCTS LIST -->
        <main class="lg:col-span-9">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-black text-2xl font-semibold">Products</h2>
                <select class="select bg-white border-2 focus:border-purple-600 border-black">
                    <option disabled selected>Sort by</option>
                    <option>Price: Low to High</option>
                    <option>Price: High to Low</option>
                    <option>Newest First</option>
                    <option>Name A-Z</option>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Skeleton Loading State -->
                @for ($i = 0; $i < 6; $i++) <div wire:loading.delay.longest
                    class="card bg-white rounded-lg overflow-hidden relative">
                    <!-- Heart icon skeleton -->
                    <div class="absolute top-3 left-3 z-10">
                        <div class="skeleton w-9 h-9 rounded-full"></div>
                    </div>

                    <!-- Image skeleton -->
                    <figure class="h-48">
                        <div class="skeleton h-full w-full rounded-lg"></div>
                    </figure>

                    <!-- Body skeleton -->
                    <div class="card-body py-4 px-0">
                        <!-- Title skeleton -->
                        <div class="skeleton h-6 w-3/4 mb-2"></div>

                        <!-- Price skeleton -->
                        <div class="skeleton h-5 w-20 mb-4"></div>

                        <!-- Description skeleton -->
                        <div class="skeleton h-4 w-full mb-2"></div>
                        <div class="skeleton h-4 w-2/3 mb-4"></div>

                        <!-- Button skeleton -->
                        <div class="skeleton h-8 w-full rounded-btn"></div>
                    </div>
            </div>
            @endfor

            <!-- Actual Product Cards (hidden during loading) -->
            @foreach ($products as $product)
            <div wire:loading.remove.delay.longest class="card bg-white rounded-lg overflow-hidden relative group">
                <!-- Heart icon -->
                <div class="">
                    <x-heroicon-o-heart
                        class="size-9 heart-icon absolute top-3 left-3 z-10 rounded-full p-2 bg-white cursor-pointer" />
                </div>

                <!-- Image -->
                <figure class="h-48">
                    @php
                    $firstImagePath = null;
                    $decodedImages = json_decode($product->images, true);
                    if (is_array($decodedImages) && count($decodedImages) > 0) {
                    $firstImageObject = $decodedImages[0];
                    if (isset($firstImageObject['image_path'])) {
                    $imagePathsArray = json_decode($firstImageObject['image_path'], true);
                    if (is_array($imagePathsArray) && count($imagePathsArray) > 0) {
                    $firstImagePath = $imagePathsArray[0];
                    }
                    }
                    }
                    @endphp
                    {{-- The image tag --}}
                    <img src="{{ $firstImagePath ? Storage::url($firstImagePath) : asset('images/no-image.webp') }}"
                        alt="{{ $product->name }}" class="w-full h-full object-cover rounded-lg shadow-md" />
                </figure>

                <!-- Body -->
                <div class="card-body py-4 px-0">
                    <h2 class="card-title text-lg font-semibold mb-2">{{ $product->name }}</h2>
                    <p class="text-gray-600 mb-4">${{ number_format($product->price, 2) }}</p>
                    <p class="text-sm text-gray-500 mb-2">
                        {{ Str::limit($product->description, 60) }}
                    </p>
                    <div class="card-actions">
                        <button
                            class="subscribe-btn btn bg-purple-600 hover:bg-purple-700 text-white btn-block h-8 border-0 flex items-center justify-center">
                            <span class="subscribe-text">Subscribe</span>
                            <svg class="cart-icon h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5H21M9 19.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM20.5 19.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
    </div>

    {{-- Pagination (hidden during loading) --}}
    <div class="p-4 border-t border-base-content/5" wire:loading.remove.delay.longest>
        {{ $products->links() }}
    </div>
    </main>
</div>
</div>
