<div>
    <div>
        <!-- Header -->
        <div class="flex flex-col sm:flex-row w-full items-start sm:items-center justify-between mb-6">
            <h1 class="text-gray-300 text-2xl lg:text-3xl mb-4 sm:mb-0">Product Details</h1>

            <nav class="text-sm">
                <ol class="flex flex-wrap items-center space-x-2">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        <a href="#" class="text-gray-400 hover:text-gray-300">Home</a>
                    </li>
                    <li class="text-gray-400">/</li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                        </svg>
                        <a href="#" class="text-gray-400 hover:text-gray-300">Products</a>
                    </li>
                    <li class="text-gray-400">/</li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                            <path fill-rule="evenodd"
                                d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 2V6a1 1 0 112 0v1a1 1 0 11-2 0zm3 0V6a1 1 0 112 0v1a1 1 0 11-2 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-gray-300">Product Details</span>
                    </li>
                </ol>
            </nav>
        </div>

        <hr class="my-6 lg:my-10 border-gray-700">

        <div class="container mx-auto">
            <!-- Back Button and Actions -->
            <div class="flex flex-col sm:flex-row w-full items-start sm:items-center justify-between mb-6">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-ghost btn-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                        Back to Products
                    </a>
                    <div class="text-sm text-gray-400">
                        Product ID: <span class="font-mono text-gray-300">#{{ $product->id }}</span>
                    </div>
                </div>

                <div class="flex gap-3 mt-4 sm:mt-0">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary btn-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Edit Product
                    </a>

                    <div class="dropdown dropdown-end">
                        <div tabindex="0" class="btn btn-ghost btn-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                </path>
                            </svg>
                        </div>
                        <ul tabindex="0"
                            class="dropdown-content menu bg-base-100 rounded-box z-20 w-52 p-2 shadow-lg border border-base-content/10">
                            <li>
                                <a href="#" class="cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Duplicate Product
                                </a>
                            </li>
                            <li>
                                <a href="#" class="cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Export Data
                                </a>
                            </li>
                            <li>
                                <hr class="my-1">
                            </li>
                            <li>
                                <a href="#" class="cursor-pointer text-red-400 hover:text-red-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                    Delete Product
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Product Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Product Images -->
                {{-- <div class="lg:col-span-2">
                    <div class="bg-base-100 p-6 rounded-lg shadow-lg">
                        <h2 class="text-lg font-semibold text-gray-300 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            Product Images
                        </h2>

                        @if ($product->images && count($product->images) > 0)
                            <div class="space-y-4">
                                <!-- Main Image -->
                                <div class="aspect-w-16 aspect-h-12 bg-gray-800 rounded-lg overflow-hidden">
                                    <img src="{{ asset('storage/' . $product->images[0]) }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-full object-cover cursor-pointer hover:scale-105 transition-transform duration-300"
                                        onclick="openImageModal(0)">
                                </div>

                                <!-- Thumbnail Images -->
                                @if (count($product->images) > 1)
                                    <div class="grid grid-cols-4 gap-2">
                                        @foreach ($product->images as $index => $image)
                                            @if ($index > 0)
                                                <div class="aspect-w-1 aspect-h-1 bg-gray-800 rounded-lg overflow-hidden cursor-pointer hover:ring-2 hover:ring-blue-500 transition-all"
                                                    onclick="openImageModal({{ $index }})">
                                                    <img src="{{ asset('storage/' . $image) }}"
                                                        alt="{{ $product->name }}" class="w-full h-full object-cover">
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif

                                <div class="text-sm text-gray-400 text-center">
                                    {{ count($product->images) }} image(s) • Click to enlarge
                                </div>
                            </div>
                        @else
                            <div
                                class="aspect-w-16 aspect-h-12 bg-gray-800 rounded-lg flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-gray-500 mx-auto mb-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <p class="text-gray-500">No images available</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div> --}}

                <div class="lg:col-span-2">
                    <div class="bg-base-100 p-6 mb-6 rounded-lg shadow-lg">
                        <h2 class="text-lg font-semibold text-gray-300 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            Product Images
                        </h2>

                        @if (!empty($images))
                            <div class="carousel w-full rounded-lg overflow-hidden">
                                @foreach ($images as $index => $image)
                                    <div id="slide{{ $index }}" class="carousel-item relative w-full">
                                        <img src="{{ asset('storage/' . $image) }}"
                                            alt="{{ $product->name }} image {{ $index + 1 }}"
                                            class="w-full h-96 object-cover" loading="lazy">
                                        <div
                                            class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                                            <a href="#slide{{ $index - 1 >= 0 ? $index - 1 : count($images) - 1 }}"
                                                class="btn btn-circle btn-sm bg-black bg-opacity-50 hover:bg-opacity-75 text-white"
                                                aria-label="Previous image">
                                                ❮
                                            </a>
                                            <a href="#slide{{ $index + 1 < count($images) ? $index + 1 : 0 }}"
                                                class="btn btn-circle btn-sm bg-black bg-opacity-50 hover:bg-opacity-75 text-white"
                                                aria-label="Next image">
                                                ❯
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="text-sm text-gray-400 text-center mt-4">
                                {{ count($images) }} image(s)
                            </div>
                        @else
                            <div
                                class="aspect-w-16 aspect-h-12 bg-gray-800 rounded-lg flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-gray-500 mx-auto mb-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <p class="text-gray-500">No images available</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if ($product->description)
                        <div class="bg-base-100 p-6 mt-4 rounded-lg shadow-lg">
                            <h2 class="text-lg font-semibold text-gray-300 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Description
                            </h2>
                            <div class="prose prose-sm max-w-none text-gray-300">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        </div>
                    @endif

                </div>

                <!-- Product Info -->
                <div class="space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-base-100 p-6 rounded-lg shadow-lg">
                        <h2 class="text-lg font-semibold text-gray-300 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Basic Information
                        </h2>

                        <div class="space-y-4">
                            <div>
                                <label class="text-sm text-gray-400">Product Name</label>
                                <p class="text-lg font-semibold text-gray-300">{{ $product->name }}</p>
                            </div>

                            <div>
                                <label class="text-sm text-gray-400">Category</label>
                                <div class="mt-1">
                                    <span
                                        class="badge badge-outline">{{ $product->category->cat_name ?? 'N/A' }}</span>
                                </div>
                            </div>

                            <div>
                                <label class="text-sm text-gray-400">Price</label>
                                <p class="text-2xl font-bold text-green-400">
                                    {{ $this->formatPrice($product->price) }}
                                </p>
                            </div>

                            <div>
                                <label class="text-sm text-gray-400">Stock Status</label>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xl font-bold">{{ $product->stock }}</span>
                                    @php
                                        $stockStatus = $this->getStockStatus($product->stock);
                                    @endphp
                                    <span
                                        class="badge {{ $stockStatus['class'] }}">{{ $stockStatus['status'] }}</span>
                                </div>
                            </div>

                            <div>
                                <label class="text-sm text-gray-400">Status</label>
                                <div class="mt-1">
                                    <span class="badge {{ $product->is_active ? 'badge-success' : 'badge-error' }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Specifications -->
                    <div class="bg-base-100 p-6 rounded-lg shadow-lg">
                        <h2 class="text-lg font-semibold text-gray-300 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            Specifications
                        </h2>
                        @if ($product->attributeValues->isNotEmpty())
                            <div class="space-y-2">
                                @foreach ($product->attributeValues as $attributeValue)
                                    @if ($attributeValue->attribute)
                                        <div class="flex justify-between">
                                            <span
                                                class="text-sm text-gray-400">{{ $attributeValue->attribute->type }}</span>
                                            <span
                                                class="text-sm text-gray-300">{{ $attributeValue->value ?? 'N/A' }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No specifications available.</p>
                        @endif
                    </div>

                    <!-- Metadata -->
                    <div class="bg-base-100 p-6 rounded-lg shadow-lg">
                        <h2 class="text-lg font-semibold text-gray-300 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Metadata
                        </h2>

                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-400">Created</span>
                                <span
                                    class="text-sm text-gray-300">{{ $product->created_at->format('M d, Y h:i A') }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-sm text-gray-400">Last Updated</span>
                                <span
                                    class="text-sm text-gray-300">{{ $product->updated_at->format('M d, Y h:i A') }}</span>
                            </div>

                            @if ($product->sku)
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-400">SKU</span>
                                    <span class="text-sm text-gray-300 font-mono">{{ $product->sku }}</span>
                                </div>
                            @endif

                            @if ($product->weight)
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-400">Weight</span>
                                    <span class="text-sm text-gray-300">{{ $product->weight }} kg</span>
                                </div>
                            @endif

                            @if ($product->dimensions)
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-400">Dimensions</span>
                                    <span class="text-sm text-gray-300">{{ $product->dimensions }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-base-100 p-6 rounded-lg shadow-lg">
                        <h2 class="text-lg font-semibold text-gray-300 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            Specifications
                        </h2>
                        @if ($product->attributeValues->isNotEmpty())
                            <div class="space-y-2">
                                @foreach ($product->attributeValues as $attributeValue)
                                    @if ($attributeValue->attribute)
                                        <div class="flex justify-between">
                                            <span
                                                class="text-sm text-gray-400">{{ $attributeValue->attribute->type }}</span>
                                            <span
                                                class="text-sm text-gray-300">{{ $attributeValue->value ?? 'N/A' }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No specifications available.</p>
                        @endif
                    </div>

                </div>
            </div>

            <!-- Additional Product Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                <!-- Product Analytics -->
                <div class="bg-base-100 p-6 rounded-lg shadow-lg">
                    <h2 class="text-lg font-semibold text-gray-300 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                        Analytics
                    </h2>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-4 bg-blue-500/10 rounded-lg">
                            <div class="text-2xl font-bold text-blue-400">{{ $product->views ?? 0 }}</div>
                            <div class="text-sm text-gray-400">Views</div>
                        </div>

                        <div class="text-center p-4 bg-green-500/10 rounded-lg">
                            <div class="text-2xl font-bold text-green-400">{{ $product->sales ?? 0 }}</div>
                            <div class="text-sm text-gray-400">Sales</div>
                        </div>

                        <div class="text-center p-4 bg-yellow-500/10 rounded-lg">
                            <div class="text-2xl font-bold text-yellow-400">{{ $product->favorites ?? 0 }}</div>
                            <div class="text-sm text-gray-400">Favorites</div>
                        </div>

                        <div class="text-center p-4 bg-purple-500/10 rounded-lg">
                            <div class="text-2xl font-bold text-purple-400">{{ $product->rating ?? 0 }}</div>
                            <div class="text-sm text-gray-400">Rating</div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-base-100 p-6 rounded-lg shadow-lg">
                    <h2 class="text-lg font-semibold text-gray-300 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Recent Activity
                    </h2>

                    <div class="space-y-3">
                        <div class="flex items-center gap-3 p-3 bg-green-500/10 rounded-lg">
                            <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                            <div class="flex-1">
                                <div class="text-sm text-gray-300">Product created</div>
                                <div class="text-xs text-gray-400">{{ $product->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>

                        @if ($product->updated_at != $product->created_at)
                            <div class="flex items-center gap-3 p-3 bg-blue-500/10 rounded-lg">
                                <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                                <div class="flex-1">
                                    <div class="text-sm text-gray-300">Product updated</div>
                                    <div class="text-xs text-gray-400">{{ $product->updated_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center gap-3 p-3 bg-gray-500/10 rounded-lg">
                            <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                            <div class="flex-1">
                                <div class="text-sm text-gray-300">Stock level: {{ $product->stock }}</div>
                                <div class="text-xs text-gray-400">Current inventory</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
