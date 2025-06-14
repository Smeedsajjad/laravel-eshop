<div>
    <div class="flex w-full items-center justify-between">
        <h1 class="text-gray-300 text-3xl">Manage Categories</h1>

        <div class="breadcrumbs text-sm">
            <ul>
                <li>
                    <a wire:navigate href="{{ route('admin.dashboard') }}">
                        <x-heroicon-s-home class="text-white size-4" /> Home
                    </a>
                </li>
                <li>
                    <a wire:navigate href="{{ route('admin.category') }}">
                        <x-heroicon-s-folder-open class="text-white size-4" /> Categories
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <hr class="my-10 border-gray-700">

    <div class="flex flex-col md:flex-row gap-4">

        <livewire:admin.category-form />
        <livewire:admin.category-table />

    </div>
</div>
