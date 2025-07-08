<div>
    <div x-data="productForm()">
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
        <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2">
            @if (session()->has('success'))
                <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-x-full"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform translate-x-0"
                    x-transition:leave-end="opacity-0 transform translate-x-full" x-init="setTimeout(() => show = false, 5000)"
                    class="bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-3 max-w-md">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                    <button @click="show = false" class="text-green-200 hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            @endif

            @if (session()->has('error'))
                <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-x-full"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 transform translate-x-0"
                    x-transition:leave-end="opacity-0 transform translate-x-full" x-init="setTimeout(() => show = false, 5000)"
                    class="bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-3 max-w-md">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                    <button @click="show = false" class="text-red-200 hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            @endif
        </div>
        <!-- Header -->
        <div class="flex flex-col sm:flex-row w-full items-start sm:items-center justify-between mb-6">
            <div>
                <h1 class="text-gray-300 text-2xl lg:text-3xl mb-2">Edit Product</h1>
                <p class="text-gray-400 text-sm">Editing: <span
                        class="font-medium text-indigo-400">{{ $product->name }}</span></p>
            </div>

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
                            <path
                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                        <span class="text-gray-300">Edit</span>
                    </li>
                </ol>
            </nav>
        </div>
        <hr class="my-6 lg:my-10 border-gray-700">

        <form wire:submit.prevent="update">
            <div class="container mx-auto">
                <!-- Basic Information -->
                <div class="bg-base-100 p-4 lg:p-6 shadow-lg rounded-lg grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <!-- Name -->
                    <div class="col-span-1 lg:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Name</label>
                        <input type="text" wire:model="name"
                            class="w-full px-3 py-2 bg-[#191e24] border border-gray-300 rounded-md text-white placeholder-gray-400 focus:ring-2 focus:border-indigo-500 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Product Name">
                        @error('name')
                            <span class="text-red-400 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Stock</label>
                        <input type="number" wire:model="stock"
                            class="w-full px-3 py-2 bg-[#191e24] border border-gray-300 rounded-md text-white placeholder-gray-400 focus:ring-2 focus:border-indigo-500 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Stock">
                        @error('stock')
                            <span class="text-red-400 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Price</label>
                        <input type="number" wire:model="price" step="0.01"
                            class="w-full px-3 py-2 bg-[#191e24] border border-gray-300 rounded-md text-white placeholder-gray-400 focus:ring-2 focus:border-indigo-500 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Price">
                        @error('price')
                            <span class="text-red-400 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Category Select with Search -->
                    <div x-data="{
                        open: false,
                        search: '',
                        selected: @entangle('category_id'),
                        selectedName: '{{ old('selected_category_name', '') }}',
                        categories: @js($category->map(fn($c) => ['id' => $c->id, 'name' => $c->cat_name])),
                        get filtered() {
                            if (!this.search) return this.categories;
                            return this.categories.filter(c => c.name.toLowerCase().includes(this.search.toLowerCase()));
                        },
                        select(cat) {
                            this.selected = cat.id;
                            this.selectedName = cat.name;
                            this.open = false;
                        }
                    }" class="relative">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Category</label>
                        <div @click="open = !open"
                            class="select w-full cursor-pointer flex items-center justify-between bg-[#191e24] border border-base-content/10 rounded px-3 py-2">
                            <span
                                x-text="selected ? (categories.find(c => c.id == selected)?.name || 'Select Category') : 'Select Category'"
                                class="truncate"></span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        <input type="hidden" name="category_id" x-model="selected"
                            wire:model.defer="category_id" />

                        <div x-show="open" @click.away="open = false"
                            class="absolute z-50 mt-1 w-full bg-base-100 border border-base-content/10 rounded shadow-lg">
                            <div class="p-2">
                                <input x-model="search" type="text" placeholder="Search category..."
                                    class="input input-bordered w-full" @keydown.escape.window="open = false"
                                    @keydown.arrow-down.prevent="$refs.list?.children[0]?.focus()" />
                            </div>
                            <ul x-ref="list" class="max-h-48 overflow-y-auto">
                                <template x-for="cat in filtered" :key="cat.id">
                                    <li @click="select(cat)" @keydown.enter.prevent="select(cat)" tabindex="0"
                                        class="px-4 py-2 cursor-pointer hover:bg-base-200"
                                        :class="{ 'bg-base-200': selected == cat.id }" x-text="cat.name"></li>
                                </template>
                                <li x-show="filtered.length === 0" class="px-4 py-2 text-gray-400">No categories
                                    found.
                                </li>
                            </ul>
                        </div>
                        @error('category_id')
                            <span class="text-red-400 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- SKU -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">SKU</label>
                        <input type="text" wire:model="sku"
                            class="w-full px-3 py-2 bg-[#191e24] border border-gray-300 rounded-md text-white placeholder-gray-400 focus:ring-2 focus:border-indigo-500 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Product SKU">
                        @error('sku')
                            <span class="text-red-400 text-sm mt-an1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Is Active Toggle -->
                    <div class="col-span-1 lg:col-span-1 flex items-center">
                        <label class="text-sm font-medium text-gray-300 mr-4">Is Active</label>
                        <input type="checkbox" wire:model="is_active"
                            class="toggle border-indigo-400 bg-indigo-500 checked:border-indigo-500 checked:bg-indigo-500" />
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-6 bg-base-100 p-4 lg:p-6 shadow-lg rounded-lg">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                    <textarea wire:model="description"
                        class="bg-[#191e24] w-full px-3 py-2 border border-gray-600 rounded-md text-white focus:ring-2 focus:border-indigo-500 focus:ring-indigo-500 focus:border-transparent placeholder-gray-400 focus:outline-none h-32 lg:h-48 resize-vertical"
                        placeholder="Product Description"></textarea>
                    @error('description')
                        <span class="text-red-400 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Product Specifications and Create Attribute Section -->
                <div class="mt-6 flex flex-col lg:flex-row gap-4">
                    <!-- Main Specs Section: 75% on large screens -->
                    <div class="w-full lg:w-3/4 p-4 bg-base-100 lg:p-6 shadow-lg rounded-lg space-y-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-semibold">Product Specifications</h3>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-gray-400">
                                    {{ $this->getSpecsCount() }} attributes added
                                </span>
                                @if (!empty($specs))
                                    <button type="button" wire:click="clearAllSpecs"
                                        wire:confirm="Are you sure you want to clear all specifications?"
                                        class="btn btn-sm btn-ghost text-red-400 hover:text-red-600">
                                        Clear All
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Add Specification Form -->
                        <div class="bg-gray-800 p-4 rounded-lg border border-gray-700">
                            <h4 class="text-md font-medium text-gray-300 mb-3">Add Specification</h4>

                            <div
                                class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-2">
                                <!-- Attribute Select -->
                                <div class="w-full sm:w-1/3">
                                    <select wire:model="newAttribute"
                                        class="select select-bordered w-full bg-[#191e24] border border-gray-300 rounded-md text-white placeholder-gray-400 focus:ring-2 focus:border-indigo-500 focus:ring-indigo-500 focus:border-transparent">
                                        <option value="">-- Select Attribute --</option>
                                        @foreach ($allAttributes as $attr)
                                            <option value="{{ $attr->id }}"
                                                @if ($this->hasAttribute($attr->id)) disabled class="text-gray-500" @endif>
                                                {{ $attr->type }}
                                                @if ($this->hasAttribute($attr->id))
                                                    (Already Added)
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('newAttribute')
                                        <span class="text-red-400 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Value Input -->
                                <div class="flex-grow">
                                    <input type="text" wire:model="newValue" placeholder="Enter value"
                                        class="input input-bordered w-full bg-[#191e24] border border-gray-300 rounded-md text-white placeholder-gray-400 focus:ring-2 focus:border-indigo-500 focus:ring-indigo-500 focus:border-transparent" />
                                    @error('newValue')
                                        <span class="text-red-400 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <!-- Add Button -->
                                <button type="button" wire:click="addSpec" wire:loading.attr="disabled"
                                    wire:target="addSpec" class="btn btn-primary whitespace-nowrap">
                                    <span wire:loading.remove wire:target="addSpec">Add Spec</span>
                                    <span wire:loading wire:target="addSpec"
                                        class="loading loading-spinner loading-xs"></span>
                                    <span wire:loading wire:target="addSpec">Adding...</span>
                                </button>
                            </div>
                        </div>

                        <!-- Specs Display Table -->
                        <div class="overflow-x-auto">
                            <table class="table w-full table-zebra">
                                <thead>
                                    <tr class="bg-base-200">
                                        <th class="text-left">#</th>
                                        <th class="text-left">Attribute</th>
                                        <th class="text-left">Value</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($specs as $index => $spec)
                                        <tr class="hover:bg-base-200" wire:key="spec-{{ $spec['id'] ?? $index }}">
                                            <td class="font-medium">{{ $index + 1 }}</td>
                                            <td>
                                                <span
                                                    class="font-medium text-indigo-400">{{ $spec['attribute_name'] }}</span>
                                            </td>
                                            <td>
                                                <div class="flex items-center gap-2">
                                                    <!-- Editable Value Input -->
                                                    <input type="text"
                                                        wire:model.live="specs.{{ $index }}.value"
                                                        class="input input-sm bg-[#191e24] border border-gray-600 text-white w-full max-w-xs"
                                                        placeholder="Enter value">
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" wire:click="removeSpec({{ $index }})"
                                                    wire:loading.attr="disabled" wire:target="removeSpec"
                                                    wire:confirm="Are you sure you want to remove this specification?"
                                                    class="btn btn-sm btn-error">
                                                    <span wire:loading.remove wire:target="removeSpec">Remove</span>
                                                    <span wire:loading wire:target="removeSpec"
                                                        class="loading loading-spinner loading-xs"></span>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-gray-500 py-8">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 text-gray-400 mb-3" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                        </path>
                                                    </svg>
                                                    <p class="text-lg font-medium text-gray-400">No specifications
                                                        added yet</p>
                                                    <p class="text-sm text-gray-500">Add product attributes and their
                                                        values above</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Specs Summary -->
                        @if (!empty($specs))
                            <div
                                class="p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg border border-indigo-200 dark:border-indigo-800">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm text-indigo-700 dark:text-indigo-300">
                                        <strong>{{ count($specs) }}</strong> specifications ready to save with this
                                        product.
                                    </p>
                                    <div class="flex items-center gap-2 text-xs text-indigo-600 dark:text-indigo-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Stored temporarily until product is saved</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Create New Attribute Sidebar: 25% on large screens -->
                    <div class="w-full lg:w-1/4 p-4 bg-base-100 lg:p-6 shadow-lg rounded-lg space-y-4">
                        <h4 class="text-md font-semibold text-gray-300 mb-4">Create New Attribute</h4>

                        <div class="space-y-3">
                            <div>
                                <input type="text" placeholder="Attribute Name (e.g., Color, Size, Material)..."
                                    wire:model="addAttribute"
                                    class="input input-bordered w-full bg-[#191e24] border border-gray-300 rounded-md text-white placeholder-gray-400 focus:ring-2 focus:border-indigo-500 focus:ring-indigo-500 focus:border-transparent" />
                                @error('addAttribute')
                                    <span class="text-red-400 text-sm block mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <fieldset class="border border-gray-600 rounded-lg p-3">
                                <legend class="text-sm text-gray-300 px-2">Options</legend>
                                <div class="flex items-center space-x-3">
                                    <input type="checkbox" wire:model="filterAttribute" id="filterAttribute"
                                        class="toggle border-indigo-400 bg-indigo-500 checked:border-indigo-500 checked:bg-indigo-500" />
                                    <label for="filterAttribute" class="text-sm cursor-pointer text-gray-300">Enable
                                        as filter</label>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">This attribute will appear in shop filters</p>
                            </fieldset>

                            <button type="button" wire:click="saveAttribute" class="btn btn-primary w-full"
                                wire:loading.attr="disabled" wire:target="saveAttribute">
                                <span wire:loading.remove wire:target="saveAttribute">Create Attribute</span>
                                <span wire:loading wire:target="saveAttribute"
                                    class="loading loading-spinner loading-xs"></span>
                                <span wire:loading wire:target="saveAttribute">Creating...</span>
                            </button>
                        </div>

                        <!-- Quick Stats -->
                        <div class="mt-6 p-3 bg-gray-800 rounded-lg border border-gray-700">
                            <h5 class="text-sm font-medium text-gray-300 mb-2">Attribute Statistics</h5>
                            <div class="space-y-1 text-xs">
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Total Available:</span>
                                    <span class="text-white">{{ $allAttributes->count() }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Filterable:</span>
                                    <span
                                        class="text-white">{{ $allAttributes->where('is_filterable', true)->count() }}</span>
                                </div>
                                @if (!empty($specs))
                                    <div class="flex justify-between">
                                        <span class="text-gray-400">Selected:</span>
                                        <span class="text-indigo-400">{{ count($specs) }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Remaining:</span>
                                    <span class="text-green-400">{{ $allAttributes->count() - count($specs) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Images Section -->
                <div class="mt-6 bg-base-100 p-4 lg:p-6 shadow-lg rounded-lg">
                    <label class="block text-sm font-medium text-gray-300 mb-4">Product Images</label>

                    <!-- File Input -->
                    <div class="mb-6">
                        <input type="file" multiple accept="image/*" wire:model.live="image_path"
                            class="w-full px-3 py-2 bg-[#191e24] border border-gray-600 rounded-md text-white file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-600 file:text-white hover:file:bg-indigo-600 file:cursor-pointer cursor-pointer focus:outline-none focus:ring-2 focus:border-indigo-500 focus:ring-indigo-500 focus:border-transparent placeholder-gray-400">
                        <p class="text-gray-400 text-sm mt-2">Select multiple images (JPEG, PNG, WebP supported)</p>
                        @error('image_path.*')
                            <span class="text-red-400 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Livewire Loading State -->
                    <div wire:loading wire:target="image_path" class="mb-4">
                        <div class="flex items-center text-indigo-400">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Processing images...
                        </div>
                    </div>

                    <!-- Image Previews Grid -->
                    @if (!empty($existing_images) || !empty($image_path))
                        <div
                            class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
                            <!-- Existing Images -->
                            @foreach ($existing_images as $index => $image)
                                <div class="relative group">
                                    <div class="image-thumbnail aspect-square bg-gray-700 rounded-lg overflow-hidden cursor-pointer border-2 border-gray-600 hover:border-indigo-500"
                                        @click="openPreview('existing', {{ $index }})">
                                        <img src="{{ $image['url'] }}" alt="Existing Image {{ $index + 1 }}"
                                            class="w-full h-full object-cover">
                                    </div>

                                    <!-- Remove Button -->
                                    <button type="button" wire:click="removeExistingImage('{{ $image['key'] }}')"
                                        class="absolute -top-2 -right-2 bg-red-600 hover:bg-red-700 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold shadow-lg transition-colors">
                                        ×
                                    </button>

                                    <!-- Image Info -->
                                    <div class="mt-2 text-xs text-gray-400 text-center">
                                        <p class="truncate">{{ basename($image['path']) }}</p>
                                        <p class="text-green-400">Existing</p>
                                    </div>
                                </div>
                            @endforeach

                            <!-- New Images -->
                            @foreach ($image_path as $index => $image)
                                <div class="relative group">
                                    <div class="image-thumbnail aspect-square bg-gray-700 rounded-lg overflow-hidden cursor-pointer border-2 border-gray-600 hover:border-indigo-500"
                                        @click="openPreview('new', {{ $index }})">
                                        <img src="{{ $image->temporaryUrl() }}" alt="New Image {{ $index + 1 }}"
                                            class="w-full h-full object-cover">
                                    </div>

                                    <!-- Remove Button -->
                                    <button type="button" wire:click="removeImage({{ $index }})"
                                        class="absolute -top-2 -right-2 bg-red-600 hover:bg-red-700 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold shadow-lg transition-colors">
                                        ×
                                    </button>

                                    <!-- Image Info -->
                                    <div class="mt-2 text-xs text-gray-400 text-center">
                                        <p class="truncate">{{ $image->getClientOriginalName() }}</p>
                                        <p>{{ $this->formatFileSize($image->getSize()) }}</p>
                                        <p class="text-blue-400">New</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <!-- No Images State -->
                        <div class="text-center py-12 border-2 border-dashed border-gray-600 rounded-lg">
                            <svg class="mx-auto h-12 w-12 text-gray-500 mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-gray-400">No images selected</p>
                            <p class="text-gray-500 text-sm">Choose files to see preview</p>
                        </div>
                    @endif
                </div>
                <!-- Submit Button -->
                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <button type="submit" wire:loading.attr="disabled" wire:target="update"
                        class="flex-1 sm:flex-none bg-indigo-600 hover:bg-indigo-700 disabled:bg-gray-600 disabled:cursor-not-allowed text-white font-medium py-3 px-8 rounded-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900 transform hover:scale-105 active:scale-95">
                        <span wire:loading.remove wire:target="update" class="flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            Update Product
                        </span>
                        <span wire:loading wire:target="update" class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Updating Product...
                        </span>
                    </button>

                    <button type="button" wire:click="resetForm"
                        class="flex-1 sm:flex-none bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-8 rounded-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-900 transform hover:scale-105 active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 inline" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset Form
                    </button>
                </div>
            </div>
        </form>


        <!-- Image Preview Modal -->
        @if (!empty($existing_images) || !empty($image_path))
            <div x-show="showPreview" x-cloak x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-50 preview-overlay flex items-center justify-center p-4" @click="closePreview"
                @keydown.escape.window="closePreview">
                <div class="preview-frame bg-white rounded-lg overflow-hidden relative max-w-4xl max-h-[90vh]"
                    @click.stop>
                    <!-- Modal Header -->
                    <div class="bg-base-100 px-4 py-3 flex justify-between items-center">
                        <h3 class="text-white font-medium" x-text="getImageTitle()"></h3>
                        <button @click="closePreview" class="text-gray-400 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Image Display -->
                    <div class="relative bg-gray-100">
                        <!-- Existing Images -->
                        @foreach ($existing_images as $index => $image)
                            <img x-show="currentImageType === 'existing' && currentImageIndex === {{ $index }}"
                                src="{{ $image['url'] }}" alt="Existing Image {{ $index + 1 }}"
                                class="max-w-full max-h-[70vh] object-contain mx-auto block">
                        @endforeach

                        <!-- New Images -->
                        @foreach ($image_path as $index => $image)
                            <img x-show="currentImageType === 'new' && currentImageIndex === {{ $index }}"
                                src="{{ $image->temporaryUrl() }}" alt="New Image {{ $index + 1 }}"
                                class="max-w-full max-h-[70vh] object-contain mx-auto block">
                        @endforeach
                    </div>

                    <!-- Navigation Controls -->
                    @if (count($existing_images) + count($image_path) > 1)
                        <div class="bg-base-100 px-4 py-3 flex justify-between items-center">
                            <button @click="previousImage()" :disabled="!canGoPrevious()"
                                class="flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 disabled:bg-gray-600 disabled:cursor-not-allowed text-white rounded-md transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                                Previous
                            </button>

                            <span class="text-white text-sm" x-text="getImagePosition()"></span>

                            <button @click="nextImage()" :disabled="!canGoNext()"
                                class="flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 disabled:bg-gray-600 disabled:cursor-not-allowed text-white rounded-md transition-colors">
                                Next
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    @endif

                    <!-- Image Details -->
                    <div class="bg-gray-50 px-4 py-3 text-sm text-gray-600">
                        <!-- Existing Images Details -->
                        @foreach ($existing_images as $index => $image)
                            <div x-show="currentImageType === 'existing' && currentImageIndex === {{ $index }}"
                                class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="font-medium">Name:</span>
                                    <span>{{ basename($image['path']) }}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Status:</span>
                                    <span class="text-green-600">Existing Image</span>
                                </div>
                            </div>
                        @endforeach

                        <!-- New Images Details -->
                        @foreach ($image_path as $index => $image)
                            <div x-show="currentImageType === 'new' && currentImageIndex === {{ $index }}"
                                class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="font-medium">Name:</span>
                                    <span>{{ $image->getClientOriginalName() }}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Size:</span>
                                    <span>{{ $this->formatFileSize($image->getSize()) }}</span>
                                </div>
                                <div>
                                    <span class="font-medium">Status:</span>
                                    <span class="text-blue-600">New Upload</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <script>
            function productForm() {
                return {
                    showPreview: false,
                    currentImageType: 'existing', // 'existing' or 'new'
                    currentImageIndex: 0,
                    existingImagesCount: {{ count($existing_images ?? []) }},
                    newImagesCount: {{ count($image_path ?? []) }},

                    openPreview(type, index) {
                        this.currentImageType = type;
                        this.currentImageIndex = index;
                        this.showPreview = true;
                        document.body.style.overflow = 'hidden';
                    },

                    closePreview() {
                        this.showPreview = false;
                        document.body.style.overflow = 'auto';
                    },

                    nextImage() {
                        if (this.currentImageType === 'existing') {
                            if (this.currentImageIndex < this.existingImagesCount - 1) {
                                this.currentImageIndex++;
                            } else if (this.newImagesCount > 0) {
                                this.currentImageType = 'new';
                                this.currentImageIndex = 0;
                            }
                        } else if (this.currentImageType === 'new') {
                            if (this.currentImageIndex < this.newImagesCount - 1) {
                                this.currentImageIndex++;
                            }
                        }
                    },

                    previousImage() {
                        if (this.currentImageType === 'new') {
                            if (this.currentImageIndex > 0) {
                                this.currentImageIndex--;
                            } else if (this.existingImagesCount > 0) {
                                this.currentImageType = 'existing';
                                this.currentImageIndex = this.existingImagesCount - 1;
                            }
                        } else if (this.currentImageType === 'existing') {
                            if (this.currentImageIndex > 0) {
                                this.currentImageIndex--;
                            }
                        }
                    },

                    canGoNext() {
                        if (this.currentImageType === 'existing') {
                            return this.currentImageIndex < this.existingImagesCount - 1 || this.newImagesCount > 0;
                        } else {
                            return this.currentImageIndex < this.newImagesCount - 1;
                        }
                    },

                    canGoPrevious() {
                        if (this.currentImageType === 'existing') {
                            return this.currentImageIndex > 0;
                        } else {
                            return this.currentImageIndex > 0 || this.existingImagesCount > 0;
                        }
                    },

                    getTotalImages() {
                        return this.existingImagesCount + this.newImagesCount;
                    },

                    getCurrentPosition() {
                        if (this.currentImageType === 'existing') {
                            return this.currentImageIndex + 1;
                        } else {
                            return this.existingImagesCount + this.currentImageIndex + 1;
                        }
                    },

                    getImagePosition() {
                        return this.getCurrentPosition() + ' / ' + this.getTotalImages();
                    },

                    getImageTitle() {
                        const position = this.getCurrentPosition();
                        const total = this.getTotalImages();
                        const status = this.currentImageType === 'existing' ? 'Existing' : 'New';
                        return `Image ${position} of ${total} (${status})`;
                    }
                }
            }
            document.addEventListener('DOMContentLoaded', function() {
                // Handle form submission
                const form = document.querySelector('form[wire\\:submit\\.prevent="update"]');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        // Disable submit button to prevent double submission
                        const submitBtn = form.querySelector('button[type="submit"]');
                        if (submitBtn) {
                            submitBtn.disabled = true;
                            // Re-enable after 3 seconds as fallback
                            setTimeout(() => {
                                submitBtn.disabled = false;
                            }, 3000);
                        }
                    });
                }
            });
        </script>
    </div>
