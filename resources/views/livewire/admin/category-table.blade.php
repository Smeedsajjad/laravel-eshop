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
        }

        .table img.banner {
            width: 96px;
            height: 32px;
        }
    </style>
    {{-- Modal --}}
    <dialog id="my_modal_3" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <h3 class="text-lg font-bold">Hello!</h3>
            <p class="py-4">Press ESC key or click on ✕ button to close</p>
        </div>
    </dialog>

    <div class="p-4 flex items-center gap-2">
        <select wire:model.live="perPage" class="select select-bordered">
            <option>10</option>
            <option>15</option>
            <option>25</option>
            <option>50</option>
        </select>
        <fieldset class="flex-grow">
            <input wire:model.live.loading.debounce.300ms="search" type="text" class="input input-bordered w-full"
                placeholder="Search..." />
        </fieldset>

        <button wire:click="$refresh" class="btn btn-circle btn-sm" title="Refresh Table">
            <x-heroicon-o-arrow-path class="h-5 w-5" />
        </button>
    </div>

    <div wire:ignore.self wire:loading.class="opacity-50" wire:target="search,perPage,sortBy" class="relative">
        <div wire:loading class="spinner-overlay">
            <div class="loader"></div>
        </div>

        <table class="table table-zebra w-full">
            <thead>
                <tr class="bg-base-200">
                    <th>
                        <a wire:click.prevent="sortBy('id')" role="button">
                            # @include('includes._sort-icons', ['field' => 'id'])
                        </a>
                    </th>
                    <th>
                        <a wire:click.prevent="sortBy('id')" role="button">
                            Name @include('includes._sort-icons', ['field' => 'id'])
                        </a>
                    </th>
                    <th>
                        <a wire:click.prevent="sortBy('id')" role="button">
                            Image @include('includes._sort-icons', ['field' => 'id'])
                        </a>
                    </th>
                    <th>
                        <a wire:click.prevent="sortBy('id')" role="button">
                            Banner @include('includes._sort-icons', ['field' => 'id'])
                        </a>
                    </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($cat as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->cat_name }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $row->main_image) }}" class="w-16 h-12 rounded"
                                alt="">
                        </td>
                        <td>
                            <img src="{{ asset('storage/' . $row->banner_image) }}" class="w-24 h-8 rounded"
                                alt="">
                        </td>
                        <td>
                            <div class="dropdown dropdown-end">
                                <div tabindex="0" class="btn btn-soft btn-circle p-1">
                                    <x-heroicon-o-ellipsis-vertical class="text-white" />
                                </div>
                                <ul tabindex="0"
                                    class="dropdown-content menu bg-base-100 rounded-box z-20 w-52 p-2 shadow-sm">
                                    <li><a onclick="my_modal_3.showModal()" wire:prevent>
                                        <x-heroicon-o-pencil-square class="size-4" />
                                            Edit</a></li>
                                    <li><a wire:click.prevent="delete({{ $row->id }})">
                                        <x-heroicon-o-trash class="size-4" />
                                            Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">
                            <x-heroicon-o-cube class="w-12 h-12 text-gray-400 mx-auto mb-3" /> No categories
                            found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $cat->links() }}
        </div>
    </div>
</div>
