<div>
    <!-- Header -->
    <div class="flex flex-col sm:flex-row w-full items-start sm:items-center justify-between mb-6">
        <h1 class="text-gray-300 text-2xl lg:text-3xl mb-4 sm:mb-0"></h1>

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
                    <x-heroicon-s-document-duplicate class="h-4 w-4 mr-1" />
                    <span class="text-gray-300">Manage</span>
                </li>
            </ol>
        </nav>
    </div>

    <hr class="my-6 lg:my-10 border-gray-700">


    <div>
        <style>
            .image-thumbnail {
                transition: all 0.3s ease;
            }

            .image-thumbnail:hover {
                transform: scale(1.05);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            }

            .preview-overlay {
                backdrop-filter: blur(10px);
                background: rgba(0, 0, 0, 0.8);
            }

            .preview-frame {
                max-width: 90vw;
                max-height: 90vh;
                box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
            }
        </style>

        <div class="container mx-auto">
            <!-- Enhanced Alert System -->
            <div id="alert-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

            <!-- Header -->
            <div class="flex flex-col sm:flex-row w-full items-start sm:items-center justify-between mb-6">
                <div>
                    <h1 class="text-gray-300 text-2xl lg:text-3xl mb-2">Products Management</h1>
                    <p class="text-gray-400 text-sm">Manage your product inventory and details</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 mt-4 sm:mt-0">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary flex items-center gap-2">
                        <x-heroicon-o-plus class="size-4" />
                        Add New Product
                    </a>

                    <button wire:click="clearFilters" class="btn btn-outline">
                        <x-heroicon-o-funnel class="size-4 mr-2" />
                        Clear Filters
                    </button>
                </div>
            </div>

            <hr class="my-6 lg:my-10 border-gray-700">

            <!-- Filters and Search -->
            <div class="bg-base-100 p-4 lg:p-6 shadow-lg rounded-lg mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Per Page Select -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Per Page</label>
                        <select wire:model.live="perPage" class="select select-bordered w-full">
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>

                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Search</label>
                        <input wire:model.live.debounce.300ms="search" type="text"
                            class="input input-bordered w-full" placeholder="Search products, categories..." />
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Category</label>
                        <select wire:model.live="filterCategory" class="select select-bordered w-full">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->cat_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                        <select wire:model.live="filterStatus" class="select select-bordered w-full">
                            <option value="">All Status</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <!-- Stock Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Stock</label>
                        <select wire:model.live="filterStock" class="select select-bordered w-full">
                            <option value="">All Stock</option>
                            <option value="in_stock">In Stock</option>
                            <option value="low_stock">Low Stock (≤10)</option>
                            <option value="out_of_stock">Out of Stock</option>
                        </select>
                    </div>
                </div>

                <!-- Refresh Button -->
                <div class="flex justify-end mt-4">
                    <button wire:click="$refresh" class="btn btn-circle btn-sm" title="Refresh Table">
                        <x-heroicon-o-arrow-path class="h-5 w-5" />
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div wire:ignore.self wire:loading.class="opacity-50"
                wire:target="search,perPage,sortBy,filterCategory,filterStatus,filterStock,updateProduct,confirmDelete,toggleStatus"
                class="relative bg-base-100 shadow-lg rounded-lg overflow-hidden">

                <div wire:loading class="spinner-overlay">
                    <div class="loader"></div>
                </div>

                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full">
                        <thead>
                            <tr class="bg-base-200">
                                <th class="min-w-[60px]">
                                    <a wire:click.prevent="sortBy('id')" role="button"
                                        class="cursor-pointer flex items-center gap-1">
                                        #
                                        @if ($sortBy === 'id')
                                            @if ($sortDirection === 'asc')
                                                <x-heroicon-o-chevron-up class="size-4" />
                                            @else
                                                <x-heroicon-o-chevron-down class="size-4" />
                                            @endif
                                        @else
                                            <x-heroicon-o-chevron-up-down class="size-4 opacity-50" />
                                        @endif
                                    </a>
                                </th>
                                <th class="min-w-[80px]">Image</th>
                                <th class="min-w-[150px]">
                                    <a wire:click.prevent="sortBy('name')" role="button"
                                        class="cursor-pointer flex items-center gap-1">
                                        Name
                                        @if ($sortBy === 'name')
                                            @if ($sortDirection === 'asc')
                                                <x-heroicon-o-chevron-up class="size-4" />
                                            @else
                                                <x-heroicon-o-chevron-down class="size-4" />
                                            @endif
                                        @else
                                            <x-heroicon-o-chevron-up-down class="size-4 opacity-50" />
                                        @endif
                                    </a>
                                </th>
                                <th class="min-w-[120px]">Category</th>
                                <th class="min-w-[80px]">
                                    <a wire:click.prevent="sortBy('price')" role="button"
                                        class="cursor-pointer flex items-center gap-1">
                                        Price
                                        @if ($sortBy === 'price')
                                            @if ($sortDirection === 'asc')
                                                <x-heroicon-o-chevron-up class="size-4" />
                                            @else
                                                <x-heroicon-o-chevron-down class="size-4" />
                                            @endif
                                        @else
                                            <x-heroicon-o-chevron-up-down class="size-4 opacity-50" />
                                        @endif
                                    </a>
                                </th>
                                <th class="min-w-[80px]">
                                    <a wire:click.prevent="sortBy('stock')" role="button"
                                        class="cursor-pointer flex items-center gap-1">
                                        Stock
                                        @if ($sortBy === 'stock')
                                            @if ($sortDirection === 'asc')
                                                <x-heroicon-o-chevron-up class="size-4" />
                                            @else
                                                <x-heroicon-o-chevron-down class="size-4" />
                                            @endif
                                        @else
                                            <x-heroicon-o-chevron-up-down class="size-4 opacity-50" />
                                        @endif
                                    </a>
                                </th>
                                <th class="min-w-[100px]">Status</th>
                                <th class="min-w-[120px]">
                                    <a wire:click.prevent="sortBy('created_at')" role="button"
                                        class="cursor-pointer flex items-center gap-1">
                                        Created
                                        @if ($sortBy === 'created_at')
                                            @if ($sortDirection === 'asc')
                                                <x-heroicon-o-chevron-up class="size-4" />
                                            @else
                                                <x-heroicon-o-chevron-down class="size-4" />
                                            @endif
                                        @else
                                            <x-heroicon-o-chevron-up-down class="size-4 opacity-50" />
                                        @endif
                                    </a>
                                </th>
                                <th class="min-w-[100px]">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr class="hover:bg-base-200">
                                    <td class="font-mono">{{ $product->id }}</td>

                                    <!-- Product Image -->
                                    <!-- Product Image Column in your table -->
                                    <td>
                                        @php
                                            $firstImage = $this->getFirstImage($product->images);
                                            $imageCount = $this->getImageCount($product);
                                        @endphp
                                        @if ($firstImage)
                                            <div class="relative group">
                                                <img src="{{ asset('storage/' . $firstImage) }}"
                                                    class="w-12 h-12 rounded object-cover cursor-pointer hover:scale-105 transition-transform image-thumbnail"
                                                    alt="{{ $product->name }}" loading="lazy"
                                                    wire:click="openImageGallery({{ $product->id }})">

                                                @if ($imageCount > 1)
                                                    <div
                                                        class="absolute -top-1 -right-1 bg-blue-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center text-[10px] font-bold">
                                                        {{ $imageCount }}
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <div
                                                class="w-12 h-12 bg-gray-300 rounded flex items-center justify-center">
                                                <x-heroicon-o-photo class="w-6 h-6 text-gray-500" />
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Image Gallery Modal (place this at the bottom of your view, after the table) -->
                                    @if ($showImageModal && $currentProduct)
                                        <div class="fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4"
                                            wire:click="closeImageGallery" x-data="{
                                                handleKeydown(event) {
                                                    if (event.key === 'ArrowLeft' || event.key === 'ArrowUp') {
                                                        event.preventDefault();
                                                        $wire.call('previousImage');
                                                    } else if (event.key === 'ArrowRight' || event.key === 'ArrowDown') {
                                                        event.preventDefault();
                                                        $wire.call('nextImage');
                                                    } else if (event.key === 'Escape') {
                                                        event.preventDefault();
                                                        $wire.call('closeImageGallery');
                                                    }
                                                }
                                            }"
                                            x-init="$el.focus()" @keydown.window="handleKeydown($event)"
                                            tabindex="0">
                                            <div class="relative max-w-4xl max-h-full w-full h-full flex flex-col"
                                                wire:click.stop>

                                                <!-- Modal Header -->
                                                <div class="flex justify-between items-center mb-4 text-white">
                                                    <div>
                                                        <h3 class="text-lg font-semibold">{{ $currentProduct->name }}
                                                        </h3>
                                                        <p class="text-sm text-gray-300">
                                                            Image {{ $currentImageIndex + 1 }} of
                                                            {{ count($currentImages) }}
                                                        </p>
                                                    </div>
                                                    <button wire:click="closeImageGallery"
                                                        class="text-white hover:text-gray-300 transition-colors">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>

                                                <!-- Main Image Container -->
                                                <div
                                                    class="flex-1 flex items-center justify-center relative bg-gray-900 rounded-lg overflow-hidden">
                                                    @if ($this->getCurrentImage())
                                                        <img src="{{ asset('storage/' . $this->getCurrentImage()) }}"
                                                            alt="{{ $currentProduct->name }}"
                                                            class="max-w-full max-h-full object-contain"
                                                            loading="lazy">
                                                    @endif

                                                    <!-- Navigation Arrows -->
                                                    @if (count($currentImages) > 1)
                                                        <!-- Previous Button -->
                                                        <button wire:click="previousImage"
                                                            class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 hover:bg-opacity-75 text-white rounded-full p-3 transition-all focus:outline-none focus:ring-2 focus:ring-white">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                                            </svg>
                                                        </button>

                                                        <!-- Next Button -->
                                                        <button wire:click="nextImage"
                                                            class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 hover:bg-opacity-75 text-white rounded-full p-3 transition-all focus:outline-none focus:ring-2 focus:ring-white">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </div>

                                                <!-- Thumbnail Pagination -->
                                                @if (count($currentImages) > 1)
                                                    <div class="mt-4 flex justify-center">
                                                        <div class="flex space-x-2 overflow-x-auto max-w-full pb-2">
                                                            @foreach ($currentImages as $index => $image)
                                                                <button wire:click="goToImage({{ $index }})"
                                                                    class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden border-2 transition-all focus:outline-none focus:ring-2 focus:ring-blue-400
                                           {{ $index === $currentImageIndex ? 'border-blue-500' : 'border-gray-600 hover:border-gray-400' }}">
                                                                    <img src="{{ asset('storage/' . $image) }}"
                                                                        alt="Thumbnail {{ $index + 1 }}"
                                                                        class="w-full h-full object-cover"
                                                                        loading="lazy">
                                                                </button>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    <!-- Dots Indicator (alternative to thumbnails for many images) -->
                                                    @if (count($currentImages) > 8)
                                                        <div class="mt-2 flex justify-center space-x-1">
                                                            @foreach ($currentImages as $index => $image)
                                                                <button wire:click="goToImage({{ $index }})"
                                                                    class="w-2 h-2 rounded-full transition-all focus:outline-none focus:ring-1 focus:ring-blue-400
                                           {{ $index === $currentImageIndex ? 'bg-blue-500' : 'bg-gray-600 hover:bg-gray-400' }}">
                                                                </button>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                @endif

                                                <!-- Keyboard Navigation Instructions -->
                                                @if (count($currentImages) > 1)
                                                    <div class="mt-2 text-center text-gray-400 text-xs">
                                                        Use arrow keys to navigate or click thumbnails
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Product Name -->
                                    <td class="font-medium">
                                        <div class="truncate max-w-[200px]" title="{{ $product->name }}">
                                            {{ $product->name }}
                                        </div>
                                        @if ($product->description)
                                            <div class="text-xs text-gray-400 truncate max-w-[200px] mt-1"
                                                title="{{ $product->description }}">
                                                {{ Str::limit($product->description, 50) }}
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Category -->
                                    <td>
                                        <span
                                            class="badge badge-outline">{{ $product->category->cat_name ?? 'N/A' }}</span>
                                    </td>

                                    <!-- Price -->
                                    <td class="font-semibold text-green-400">
                                        {{ $this->formatPrice($product->price) }}
                                    </td>

                                    <!-- Stock -->
                                    <td>
                                        @php
                                            $stockStatus = $this->getStockStatus($product->stock);
                                        @endphp
                                        <div class="text-center">
                                            <div class="font-bold">{{ $product->stock }}</div>
                                            <div class="text-xs {{ $stockStatus['class'] }}">
                                                {{ $stockStatus['status'] }}</div>
                                        </div>
                                    </td>

                                    <!-- Status Toggle -->
                                    <td>
                                        <input type="checkbox"
                                            class="toggle {{ $product->is_active ? 'toggle-success' : 'bg-indigo-600' }}"
                                            {{ $product->is_active ? 'checked' : '' }}
                                            wire:click="toggleStatus({{ $product->id }})"
                                            wire:loading.attr="disabled" wire:target="toggleStatus">
                                    </td>


                                    <!-- Created Date -->
                                    <td class="text-sm">
                                        <div>{{ $product->created_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-400">{{ $product->created_at->format('h:i A') }}
                                        </div>
                                    </td>

                                    <!-- Actions -->
                                    <td>
                                        <div class="dropdown dropdown-end">
                                            <div tabindex="0" class="btn btn-ghost btn-sm">
                                                <x-heroicon-o-ellipsis-vertical class="size-5" />
                                            </div>
                                            <ul tabindex="0"
                                                class="dropdown-content menu bg-base-100 rounded-box z-20 w-52 p-2 shadow-lg border border-base-content/10">
                                                <li>
                                                    <a href="{{ route('admin.products.show', $product) }}"
                                                        class="cursor-pointer">
                                                        <x-heroicon-o-eye class="size-4" />
                                                        View Details
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('admin.products.edit', $product) }}"
                                                        class="cursor-pointer">
                                                        <x-heroicon-o-pencil-square class="size-4" />
                                                        Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="my-1">
                                                </li>
                                                <li>
                                                    <a wire:click.prevent="prepareDelete({{ $product->id }}, '{{ addslashes($product->name) }}')"
                                                        onclick="document.getElementById('delete_modal').showModal()"
                                                        class="cursor-pointer text-red-400 hover:text-red-300">
                                                        <x-heroicon-o-trash class="size-4" />
                                                        Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-12">
                                        <div class="flex flex-col items-center">
                                            <x-heroicon-o-cube class="w-16 h-16 text-gray-400 mb-4" />
                                            <p class="text-gray-500 text-lg font-medium">No products found.</p>
                                            @if ($search || $filterCategory || $filterStatus !== '' || $filterStock)
                                                <p class="text-sm text-gray-400 mt-2">
                                                    Try adjusting your search terms or filters.
                                                </p>
                                                <button wire:click="clearFilters" class="btn btn-primary btn-sm mt-3">
                                                    Clear Filters
                                                </button>
                                            @else
                                                <p class="text-sm text-gray-400 mt-2">
                                                    Start by creating your first product.
                                                </p>
                                                <a href="{{ route('admin.products.create') }}"
                                                    class="btn btn-primary btn-sm mt-3">
                                                    <x-heroicon-o-plus class="size-4 mr-2" />
                                                    Add Product
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($products->hasPages())
                    <div class="p-4 border-t border-base-content/5">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
            @if ($deletingProduct)
                <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                    <div class="bg-base-100 p-6 rounded shadow-md w-full max-w-md">
                        <h2 class="text-lg font-bold mb-4">Delete Product</h2>
                        <p>Are you sure you want to delete <strong>{{ $deletingProductName }}</strong>?</p>
                        <div class="mt-4 flex justify-end gap-2">
                            <button wire:click="confirmDelete" class="btn btn-error">Yes, Delete</button>
                            <button wire:click="resetDeleteForm" class="btn">Cancel</button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Product Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
                <div class="bg-base-100 p-4 rounded-lg shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-500/20 text-blue-400">
                            <x-heroicon-o-cube class="size-6" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-400">Total Products</p>
                            <p class="text-2xl font-bold">{{ $products->total() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-base-100 p-4 rounded-lg shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-500/20 text-green-400">
                            <x-heroicon-o-check-circle class="size-6" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-400">Active Products</p>
                            <p class="text-2xl font-bold">{{ $products->where('is_active', true)->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-base-100 p-4 rounded-lg shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-500/20 text-yellow-400">
                            <x-heroicon-o-exclamation-triangle class="size-6" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-400">Low Stock</p>
                            <p class="text-2xl font-bold">
                                {{ $products->where('stock', '<=', 10)->where('stock', '>', 0)->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-base-100 p-4 rounded-lg shadow">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-500/20 text-red-400">
                            <x-heroicon-o-x-circle class="size-6" />
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-400">Out of Stock</p>
                            <p class="text-2xl font-bold">{{ $products->where('stock', 0)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
