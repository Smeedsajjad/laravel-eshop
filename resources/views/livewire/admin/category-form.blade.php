<div class="w-full md:w-2/5 p-6 rounded-lg bg-base-200 shadow-md">


    {{-- Success/Error Messages --}}
    @if (session()->has('message'))
        <div class="toast toast-top toast-end z-50" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <div class="alert alert-success">
                <x-heroicon-o-check-circle class="size-5" />
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif

    <h2 class="text-xl font-semibold mb-4 text-white">Add New Category</h2>

    <div class="space-y-4">
        <input type="text" wire:model="cat_name" class="input input-bordered w-full" placeholder="Category Name">
        @error('cat_name')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror

        <div>
            <label class="block text-white mb-1">Main Image</label>
            <input type="file" wire:model="main_image_file" class="file-input file-input-bordered w-full"
                accept="image/*" id="main-image-input">
            @error('main_image_file')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror

            <!-- Main Image Preview -->
            @if ($main_image_file)
                <div class="mt-3">
                    <div class="relative inline-block">
                        <img src="{{ $main_image_file->temporaryUrl() }}" alt="Main Image Preview"
                            class="w-24 h-24 object-cover rounded-lg shadow-md cursor-pointer hover:opacity-80 transition-opacity"
                            onclick="openImageModal('{{ $main_image_file->temporaryUrl() }}', 'Main Image Preview')">
                        <div class="absolute -top-2 -right-2">
                            <button type="button" wire:click="$set('main_image_file', null)"
                                class="btn btn-circle btn-xs btn-error">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Click to view full size</p>
                </div>
            @endif
        </div>

        <div>
            <label class="block text-white mb-1">Banner Image</label>
            <input type="file" wire:model="banner_image_file" class="file-input file-input-bordered w-full"
                accept="image/*" id="banner-image-input">
            @error('banner_image_file')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror

            <!-- Banner Image Preview -->
            @if ($banner_image_file)
                <div class="mt-3">
                    <div class="relative inline-block">
                        <img src="{{ $banner_image_file->temporaryUrl() }}" alt="Banner Image Preview"
                            class="w-32 h-20 object-cover rounded-lg shadow-md cursor-pointer hover:opacity-80 transition-opacity"
                            onclick="openImageModal('{{ $banner_image_file->temporaryUrl() }}', 'Banner Image Preview')">
                        <div class="absolute -top-2 -right-2">
                            <button type="button" wire:click="$set('banner_image_file', null)"
                                class="btn btn-circle btn-xs btn-error">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Click to view full size</p>
                </div>
            @endif
        </div>

        <button wire:click="save" wire:loading.attr="disabled" class="btn btn-primary w-full mt-2">
            <span wire:loading.remove>Save Category</span>
            <span wire:loading class="loading loading-spinner loading-sm"></span>
            <span wire:loading>Saving...</span>
        </button>
    </div>

<!-- Image Modal -->
<div id="imageModal" class="modal">
    <div class="modal-box max-w-4xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-lg" id="modalTitle">Image Preview</h3>
            <button class="btn btn-sm btn-circle btn-ghost" onclick="closeImageModal()">✕</button>
        </div>
        <div class="flex justify-center">
            <img id="modalImage" src="" alt="Full Size Preview"
                class="max-w-full max-h-96 object-contain rounded-lg">
        </div>
        <div class="modal-action">
            <button class="btn" onclick="closeImageModal()">Close</button>
        </div>
    </div>
</div>

<script>
    function openImageModal(imageSrc, title) {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('imageModal').classList.add('modal-open');
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.remove('modal-open');
    }

    // Close modal when clicking outside
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
</script>
</div>
