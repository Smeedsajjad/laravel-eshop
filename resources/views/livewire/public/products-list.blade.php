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
        button.relative.inline-flex.items-center.px-2.py-2.-ml-px.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.rounded-r-md.leading-5.hover\:text-gray-400.focus\:z-10.focus\:outline-none.focus\:border-blue-300.focus\:ring.ring-blue-300.active\:bg-gray-100.active\:text-gray-500.transition.ease-in-out.duration-150.dark\:bg-gray-800.dark\:border-gray-600.dark\:active\:bg-gray-700.dark\:focus\:border-blue-800,
        [type='checkbox']:checked:hover,
        [type='checkbox']:checked:focus,
        [type='radio']:checked:hover,
        [type='radio']:checked:focus {
            background-color: #9333ea;
        }
    </style>
    <div class="breadcrumbs text-lg text-purple-600 mb-6">
        <ul>
            @if($category && ($category->slug || $category->cat_name))
            <li><a wire:navigate href="{{ route('home') }}">Home</a></li>
            <li><a wire:navigate href="{{ route('products') }}">Products</a></li>
            <li class="text-gray-500">{{ $category->cat_name}}</li>
            @else
            <li><a wire:navigate href="{{ route('home') }}">Home</a></li>
            <li><a wire:navigate href="{{ route('products') }}">Products</a></li>
            @endif
        </ul>
    </div>
    @if($category && ($category->slug || $category->cat_name))
    <h1 class="text-black text-3xl font-semibold">{{ $category->cat_name }}</h1>
    @else
    <h1 class="text-black text-3xl font-semibold">Product Listing</h1>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-8 text-black">
        <!-- FILTERS PANEL -->
        <aside class="hidden md:block lg:col-span-3 p-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-black text-2xl">Filter</h2>
                @if (($minPrice !== '' || $maxPrice !== '' || !empty($selectedFilters)))
                <button wire:click="clearFilters" class="text-sm text-purple-600 hover:text-purple-800 underline">
                    Clear All
                </button>
                @endif
            </div>

            <!-- Price Filter -->
            <fieldset class="border border-purple-500 rounded-box p-4 w-full max-w-md mb-4">
                <legend class="text-sm font-medium text-purple-600 px-2">Filter by Price</legend>

                <div class="flex flex-col sm:flex-row gap-3 mt-2">
                    <input type="number" class="input input-bordered w-full sm:w-1/2 bg-white border-purple-600"
                        placeholder="Min (${{ number_format($allMin, 0) }})" wire:model.live.debounce.500ms="minPrice"
                        min="0" max="{{ $allMax }}" />

                    <input type="number" class="input input-bordered w-full sm:w-1/2 bg-white border-purple-600"
                        placeholder="Max (${{ number_format($allMax, 0) }})" wire:model.live.debounce.500ms="maxPrice"
                        min="{{ $minPrice ?: 0 }}" max="{{ $allMax }}" />
                </div>

                <!-- Active Price Filter Display -->`
                @if ($minPrice !== '' || $maxPrice !== '')
                <div class="mt-3 p-2 bg-purple-50 rounded-lg border border-purple-200">
                    <span class="text-sm text-purple-700">
                        Range: ${{ $minPrice ?: '0' }} - ${{ $maxPrice ?: number_format($allMax, 0) }}
                    </span>
                </div>
                @endif
            </fieldset>

            <!-- Attribute Filters -->
            <div class="space-y-3">
                @foreach($filterableAttributes as $attribute)
                @if($attribute->values->count())
                <div class="border border-gray-300 rounded-lg bg-white">
                    <div class="collapse collapse-arrow">
                        <input id="collapse-{{ $attribute->id }}" type="checkbox" class="peer hidden" />

                        <label for="collapse-{{ $attribute->id }}"
                            class="collapse-title font-semibold capitalize cursor-pointer peer-checked:bg-gray-50 text-sm p-3">
                            {{ $attribute->type }}
                            @if(!empty(array_filter($selectedFilters[$attribute->id] ?? [])))
                            <span class="badge badge-sm badge-primary ml-2">
                                {{ count(array_filter($selectedFilters[$attribute->id] ?? [])) }}
                            </span>
                            @endif
                        </label>

                        <div class="collapse-content text-sm space-y-2 hidden peer-checked:block p-3 pt-0">
                            @foreach($attribute->values as $value)
                            <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-50 p-1 rounded">
                                <input type="checkbox"
                                    wire:model.live.debounce.300ms="selectedFilters.{{ $attribute->id }}"
                                    value="{{ $value->value }}" class="checkbox checkbox-sm checkbox-primary" />
                                <span>{{ $value->value }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>

            <!-- Show active attribute filters -->
            @if (!empty(array_filter(array_map('array_filter', $selectedFilters))))
            <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                <div class="text-sm text-blue-700 font-medium mb-2">Active Filters:</div>
                @foreach($selectedFilters as $attributeId => $values)
                @php $filteredValues = array_filter($values); @endphp
                @if(!empty($filteredValues))
                @php $attribute = $filterableAttributes->find($attributeId); @endphp
                <div class="mb-2">
                    <div class="text-xs font-medium text-blue-600 mb-1">{{ $attribute->type }}:</div>
                    <div class="flex flex-wrap gap-1">
                        @foreach($filteredValues as $value)
                        <span class="badge badge-xs badge-outline badge-primary">{{ $value }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            @endif
        </aside>

        <!-- PRODUCT GRID -->
        <main class="lg:col-span-9">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                <h2 class="text-black text-2xl font-semibold">
                    Products
                    <span class="text-lg text-gray-500 font-normal">({{ $products->total() }})</span>
                </h2>

                <select wire:model.live="sortBy"
                    class="select select-bordered bg-white border-2 focus:border-purple-600 border-gray-300 min-w-48">
                    <option value="">Sort by</option>
                    <option value="newest">Newest First</option>
                    <option value="price_low_high">Price: Low to High</option>
                    <option value="price_high_low">Price: High to Low</option>
                    <option value="name_az">Name: A to Z</option>
                    <option value="name_za">Name: Z to A</option>
                </select>
            </div>

            <!-- Loading Skeleton -->
            <div wire:loading.delay.longest class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @for ($i = 0; $i < 6; $i++) <div class="card bg-white rounded-lg overflow-hidden relative shadow-sm">
                    <figure class="h-48">
                        <div class="skeleton h-full w-full"></div>
                    </figure>
                    <div class="card-body py-4 px-4">
                        <div class="skeleton h-6 w-3/4 mb-2"></div>
                        <div class="skeleton h-5 w-20 mb-4"></div>
                        <div class="skeleton h-4 w-full mb-2"></div>
                        <div class="skeleton h-4 w-2/3 mb-4"></div>
                        <div class="skeleton h-8 w-full rounded-btn"></div>
                    </div>
            </div>
            @endfor
    </div>

    <!-- Products Grid -->
    <div wire:loading.remove.delay.longest class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($products as $product)
        <div
            class="card bg-white rounded-lg overflow-hidden relative group shadow-sm hover:shadow-md transition-shadow">

            <!-- Heart icon for wishlist -->
            <div class="absolute top-3 left-3 z-10">
                <x-heroicon-o-heart wire:click.stop="{{ $product->id }}"
                    class="size-8 heart-icon rounded-full p-1.5 bg-white/80 backdrop-blur cursor-pointer hover:bg-white transition-colors" />
            </div>

            <!-- Clickable area for redirect -->
            <a wire:navigate href="{{ route('product.details', $product->slug) }}" class="block">
                <figure class="h-48">
                    <img src="{{ $product->first_image_path ? Storage::url($product->first_image_path) : asset('images/no-image.webp') }}"
                        alt="{{ $product->name }}"
                        class="w-full h-full object-cover transition-transform group-hover:scale-105" />
                </figure>

                <div class="card-body py-4 px-4">
                    <h2 class="card-title text-lg font-semibold mb-2 line-clamp-2">{{ $product->name }}</h2>
                    <p class="text-purple-600 font-bold text-lg mb-2">${{ number_format($product->price, 2) }}</p>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-2">
                        {{ Str::limit($product->description, 80) }}
                    </p>
                </div>
            </a>

            <!-- Add to Cart Button -->
            <div class="card-actions px-4 pb-4">
                <button wire:click.stop="{{ $product->id }}"
                    class="subscribe-btn btn bg-purple-600 hover:bg-purple-700 text-white btn-block h-8 border-0 flex items-center justify-center z-10">
                    <span class="subscribe-text">Add in Cart</span>
                    <svg class="cart-icon h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5H21M9 19.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM20.5 19.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                    </svg>
                </button>
            </div>
        </div>

        @empty
        <div class="flex flex-col items-center justify-center text-center col-span-full py-16">
            <svg class="w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-500 mb-2">No products found</h3>
            <p class="text-gray-400 mb-4">We couldn't find any products matching your criteria.</p>
            @if (($minPrice !== '' || $maxPrice !== '' || !empty($selectedFilters)))
            <button wire:click="clearFilters" class="btn btn-outline btn-sm">
                Clear all filters
            </button>
            @endif
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div wire:loading.remove.delay.longest class="mt-8 border-t border-gray-200 pt-6">
        {{ $products->links() }}
    </div>
    @endif
    </main>
</div>
</div>
