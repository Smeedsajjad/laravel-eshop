<div
    class="w-full md:w-3/5 rounded-lg relative overflow-x-auto rounded-box border border-base-content/5 shadow-md bg-base-100">
    <style>
        tr:hover {
            background-color: #191e24;
        }

        .table img {
            width: 64px;
            height: 48px;
            object-fit: cover;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .table img:hover {
            transform: scale(1.05);
        }

        .table img.banner {
            width: 96px;
            height: 32px;
        }

        .image-preview {
            max-width: 150px;
            max-height: 100px;
            object-fit: cover;
            border-radius: 0.25rem;
            border: 1px solid #374151;
        }

        .modal-backdrop {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(4px);
        }

        .image-modal img {
            max-width: 90vw;
            max-height: 90vh;
            object-fit: contain;
        }

        @media (max-width: 768px) {
            .image-preview {
                max-width: 120px;
                max-height: 80px;
            }

            .modal-box {
                margin: 1rem;
                max-width: calc(100vw - 2rem);
                width: auto;
            }
        }
    </style>

    {{-- Image View Modal --}}
    <dialog id="image_view_modal" class="modal modal-backdrop">
        <div class="modal-box max-w-none w-auto bg-transparent shadow-none p-4 image-modal">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2 z-10 bg-black/50 text-white hover:bg-black/70">✕</button>
            </form>
            <img id="modal_image" src="" alt="Full size image" class="rounded-lg">
        </div>
    </dialog>

    {{-- Delete Confirmation Modal --}}
    <dialog id="delete_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" wire:click="cancelDelete">✕</button>
            </form>

            <div class="pt-6">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">Confirm Delete</h3>
                        <p class="text-gray-400 text-sm">This action cannot be undone</p>
                    </div>
                </div>

                <p class="text-gray-300 mb-6">
                    Are you sure you want to delete "<span class="font-semibold" id="delete_category_name"></span>"?
                    All associated data will be permanently removed.
                </p>

                <div class="flex gap-3 justify-end">
                    <button type="button" class="btn btn-ghost" wire:click="cancelDelete">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-error" wire:click="confirmDelete" wire:loading.attr="disabled">
                        <span wire:loading.remove>Delete Category</span>
                        <span wire:loading>
                            <span class="loading loading-spinner loading-sm"></span>
                            Deleting...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </dialog>

    {{-- Edit Modal --}}
    <dialog id="edit_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
        <div class="modal-box max-w-4xl w-full mx-4">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" wire:click="cancelEdit">✕</button>
            </form>

            <div class="pt-6">
                <h2 class="text-lg font-semibold mb-4 text-white">Edit Category</h2>

                <div class="space-y-6">
                    {{-- Category Name --}}
                    <fieldset class="fieldset">
                        <legend class="fieldset-legend">Category Name</legend>
                        <input type="text" class="input input-bordered w-full" placeholder="Category Name"
                            wire:model.defer="editCatName">
                        @error('editCatName')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </fieldset>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        {{-- Main Image Section --}}
                        <div class="space-y-4">
                            <label class="block text-white text-sm font-medium">Main Image</label>

                            <!-- Current Image Preview -->
                            @if ($currentMainImage)
                                <div>
                                    <p class="text-sm text-gray-400 mb-2">Current Image:</p>
                                    <img src="{{ asset('storage/' . $currentMainImage) }}"
                                         class="image-preview cursor-pointer" alt="Current main image"
                                         onclick="showImageModal(this.src)">
                                </div>
                            @endif

                            <!-- File Input -->
                            <input type="file" class="file-input file-input-bordered w-full"
                                wire:model.defer="editMainImage" accept="image/*" />
                            @error('editMainImage')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                            <p class="text-sm text-gray-400">
                                Leave empty to keep current image. Max size: 1MB
                            </p>

                            <!-- New Image Preview -->
                            @if ($editMainImage)
                                <div>
                                    <p class="text-sm text-green-400 mb-2">New Image Preview:</p>
                                    <img src="{{ $editMainImage->temporaryUrl() }}"
                                         class="image-preview cursor-pointer" alt="New main image preview"
                                         onclick="showImageModal(this.src)">
                                </div>
                            @endif
                        </div>

                        {{-- Banner Image Section --}}
                        <div class="space-y-4">
                            <label class="block text-white text-sm font-medium">Banner Image</label>

                            <!-- Current Banner Preview -->
                            @if ($currentBannerImage)
                                <div>
                                    <p class="text-sm text-gray-400 mb-2">Current Banner:</p>
                                    <img src="{{ asset('storage/' . $currentBannerImage) }}"
                                         class="cursor-pointer rounded border border-gray-600"
                                         style="width: 200px; height: 67px; object-fit: cover;"
                                         alt="Current banner image"
                                         onclick="showImageModal(this.src)">
                                </div>
                            @endif

                            <!-- File Input -->
                            <input type="file" class="file-input file-input-bordered w-full"
                                wire:model.defer="editBannerImage" accept="image/*" />
                            @error('editBannerImage')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                            <p class="text-sm text-gray-400">
                                Leave empty to keep current banner. Max size: 1MB
                            </p>

                            <!-- New Banner Preview -->
                            @if ($editBannerImage)
                                <div>
                                    <p class="text-sm text-green-400 mb-2">New Banner Preview:</p>
                                    <img src="{{ $editBannerImage->temporaryUrl() }}"
                                         class="cursor-pointer rounded border border-gray-600"
                                         style="width: 200px; height: 67px; object-fit: cover;"
                                         alt="New banner image preview"
                                         onclick="showImageModal(this.src)">
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-3 justify-end pt-4 border-t border-gray-600">
                        <button type="button" class="btn btn-ghost order-2 sm:order-1" wire:click="cancelEdit">
                            Cancel
                        </button>
                        <button type="button" class="btn btn-primary order-1 sm:order-2" wire:click="updateCategory"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove>Update Category</span>
                            <span wire:loading>
                                <span class="loading loading-spinner loading-sm"></span>
                                Updating...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </dialog>

    {{-- Search and Controls --}}
    <div class="p-4 flex flex-col sm:flex-row items-center gap-3">
        <select wire:model.live="perPage" class="select select-bordered w-full sm:w-auto">
            <option>10</option>
            <option>15</option>
            <option>25</option>
            <option>50</option>
        </select>
        <fieldset class="flex-grow w-full sm:w-auto">
            <input wire:model.live.loading.debounce.300ms="search" type="text" class="input input-bordered w-full"
                placeholder="Search categories..." />
        </fieldset>

        <button wire:click="$refresh" class="btn btn-circle btn-sm flex-shrink-0" title="Refresh Table">
            <x-heroicon-o-arrow-path class="h-5 w-5" />
        </button>
    </div>

    {{-- Table --}}
    <div wire:ignore.self wire:loading.class="opacity-50" wire:target="search,perPage,sortBy,updateCategory,confirmDelete"
        class="relative">
        <div wire:loading class="spinner-overlay">
            <div class="loader"></div>
        </div>

        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr class="bg-base-200">
                        <th class="min-w-[60px]">
                            <a wire:click.prevent="sortBy('id')" role="button" class="cursor-pointer">
                                # @include('includes._sort-icons', ['field' => 'id'])
                            </a>
                        </th>
                        <th class="min-w-[120px]">
                            <a wire:click.prevent="sortBy('cat_name')" role="button" class="cursor-pointer">
                                Name @include('includes._sort-icons', ['field' => 'cat_name'])
                            </a>
                        </th>
                        <th class="min-w-[100px]">Main Image</th>
                        <th class="min-w-[120px]">Banner</th>
                        <th class="min-w-[80px]">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cat as $row)
                        <tr>
                            <td class="font-mono">{{ $row->id }}</td>
                            <td class="font-medium">
                                <div class="truncate max-w-[150px] md:max-w-none" title="{{ $row->cat_name }}">
                                    {{ $row->cat_name }}
                                </div>
                            </td>
                            <td>
                                <img src="{{ asset('storage/' . $row->main_image) }}"
                                     class="w-16 h-12 rounded object-cover cursor-pointer hover:scale-105 transition-transform"
                                     alt="{{ $row->cat_name }}"
                                     loading="lazy"
                                     onclick="showImageModal('{{ asset('storage/' . $row->main_image) }}')">
                            </td>
                            <td>
                                <img src="{{ asset('storage/' . $row->banner_image) }}"
                                     class="w-24 h-8 rounded object-cover cursor-pointer hover:scale-105 transition-transform"
                                     alt="{{ $row->cat_name }}"
                                     loading="lazy"
                                     onclick="showImageModal('{{ asset('storage/' . $row->banner_image) }}')">
                            </td>
                            <td>
                                <div class="dropdown dropdown-end">
                                    <div tabindex="0" class="btn btn-soft btn-circle p-1">
                                        <x-heroicon-o-ellipsis-vertical class="text-white" />
                                    </div>
                                    <ul tabindex="0"
                                        class="dropdown-content menu bg-base-100 rounded-box z-20 w-52 p-2 shadow-sm">
                                        <li>
                                            <a wire:click.prevent="edit({{ $row->id }})"
                                                onclick="document.getElementById('edit_modal').showModal()"
                                                class="cursor-pointer">
                                                <x-heroicon-o-pencil-square class="size-4" />
                                                Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a wire:click.prevent="prepareDelete({{ $row->id }}, '{{ $row->cat_name }}')"
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
                            <td colspan="5" class="text-center py-8">
                                <div class="flex flex-col items-center">
                                    <x-heroicon-o-cube class="w-12 h-12 text-gray-400 mb-3" />
                                    <p class="text-gray-500">No categories found.</p>
                                    @if ($search)
                                        <p class="text-sm text-gray-400 mt-1">
                                            Try adjusting your search terms.
                                        </p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="p-4 border-t border-base-content/5">
            {{ $cat->links() }}
        </div>
    </div>

    {{-- Success/Error Messages --}}
    @if (session()->has('message'))
        <div class="toast toast-top toast-end z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <div class="alert alert-success">
                <x-heroicon-o-check-circle class="size-5" />
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif

    {{-- Modal Control Script --}}
    <script>
        // Function to show image in modal
        function showImageModal(imageSrc) {
            const modalImage = document.getElementById('modal_image');
            const modal = document.getElementById('image_view_modal');

            modalImage.src = imageSrc;
            modal.showModal();
        }

        // Listen for Livewire events to control modals
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-edit-modal', () => {
                document.getElementById('edit_modal').showModal();
            });

            Livewire.on('close-edit-modal', () => {
                document.getElementById('edit_modal').close();
            });

            Livewire.on('open-delete-modal', (data) => {
                document.getElementById('delete_category_name').textContent = data.categoryName;
                document.getElementById('delete_modal').showModal();
            });

            Livewire.on('close-delete-modal', () => {
                document.getElementById('delete_modal').close();
            });
        });

        // Close modals on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                const editModal = document.getElementById('edit_modal');
                const deleteModal = document.getElementById('delete_modal');
                const imageModal = document.getElementById('image_view_modal');

                if (editModal.open) {
                    @this.call('cancelEdit');
                }
                if (deleteModal.open) {
                    @this.call('cancelDelete');
                }
                if (imageModal.open) {
                    imageModal.close();
                }
            }
        });

        // Close image modal when clicking outside the image
        document.getElementById('image_view_modal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.close();
            }
        });
    </script>
</div>
