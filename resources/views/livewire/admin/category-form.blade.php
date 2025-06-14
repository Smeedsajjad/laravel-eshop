<div class="w-full md:w-2/5 p-6 rounded-lg bg-base-200 shadow-md">

    <div class="toast toast-start toast-middle z-[99]" id="toast-container">
        @if (session('message'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                x-transition:leave="transition ease-in-out duration-300 transform opacity-100 to opacity-0"
                class="alert alert-success" data-toast>
                <span>{{ session('message') }}</span>
            </div>
        @endif
        @if ($errors->has('cat_name'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                x-transition:leave="transition ease-in-out duration-300 transform opacity-100 to opacity-0"
                class="alert alert-error" data-toast>
                <span>{{ $errors->first('cat_name') }}</span>
            </div>
        @endif
    </div>

    <h2 class="text-xl font-semibold mb-4 text-white">Add New Category</h2>

    <div class="space-y-4">
        <input type="text" wire:model="cat_name" class="input input-bordered w-full" placeholder="Category Name">
        @error('cat_name')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror

        <div>
            <label class="block text-white mb-1">Main Image</label>
            <input type="file" wire:model="main_image_file" class="file-input file-input-bordered w-full"
                accept="image/*">
            @error('main_image_file')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="block text-white mb-1">Banner Image</label>
            <input type="file" wire:model="banner_image_file" class="file-input file-input-bordered w-full"
                accept="image/*">
            @error('banner_image_file')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <button wire:click="save" wire:loading.attr="disabled" class="btn btn-primary w-full mt-2">
            Save Category
        </button>
    </div>
</div>
