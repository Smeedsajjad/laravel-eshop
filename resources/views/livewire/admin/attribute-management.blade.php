<div>
    <div class="flex w-full items-center justify-between">
        <h1 class="text-gray-300 text-3xl">Manage Attributes</h1>

        <div class="breadcrumbs text-sm">
            <ul>
                <li>
                    <a wire:navigate href="{{ route('admin.dashboard') }}">
                        <x-heroicon-s-home class="text-white size-4" /> Home
                    </a>
                </li>
                <li>
                    <a wire:navigate href="{{ route('admin.attributes') }}">
                        <x-heroicon-s-inbox-stack class="text-white size-4" /> Attributes
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <hr class="my-10 border-gray-700">

    <div class="p-6">
        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div class="alert alert-success mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-error mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Top buttons -->
        <div class="flex justify-between mb-4">
            <h1 class="text-2xl font-bold">Attributes</h1>
            @if(!$showValuesPanel)
            <button class="btn btn-primary btn-sm" wire:click="openCreateModal">Create</button>
            @endif
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-4">
            <!-- Search -->
            <input type="search" class="input input-bordered w-full sm:w-auto" placeholder="Search attribute…"
                wire:model.live.debounce.300ms="search">

            <!-- Per-page selector -->
            <select wire:model.live="perPage" class="select select-bordered w-auto">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>

        <!-- Attribute list (hidden when values panel is open) -->
        @if(!$showValuesPanel)
        <div class="overflow-x-auto">
            <table class="table table-compact w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Filterable</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody wire:loading.class="opacity-50">
                    @forelse($attributes as $attr)
                    <tr>
                        <td>{{ $attr->id }}</td>
                        <td>{{ $attr->type }}</td>
                        <td>
                            <input type="checkbox"
                                class="toggle toggle-sm {{ $attr->is_filterable ? 'toggle-success' : 'bg-primary' }}"
                                {{ $attr->is_filterable ? 'checked' : '' }}
                                wire:click="toggleAttr({{ $attr->id }})"
                                wire:loading.attr="disabled">
                        </td>
                        <td>
                            <button class="btn btn-xs" wire:click="editAttr({{ $attr->id }})">Edit</button>
                            <button class="btn btn-xs btn-error"
                                wire:click="confirmDelete({{ $attr->id }})">Del</button>
                            <button class="btn btn-xs btn-outline"
                                wire:click="manageValues({{ $attr }})">Values</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-12">
                            <div class="flex flex-col items-center">
                                <x-heroicon-o-inbox-stack class="w-16 h-16 text-gray-400 mb-4" />
                                <p class="text-gray-500 text-lg font-medium">No Attribute found.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $attributes->links() }}
        </div>
        @endif

        <!-- VALUES PANEL (shown when showValuesPanel = true) -->
        @if($showValuesPanel)
        <div>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Values for <span class="text-purple-600">{{ $valuesAttribute->type }}</span></h2>
                <button class="btn btn-sm btn-outline" wire:click="closeValuesPanel">← Back</button>
            </div>

            <!-- Add / edit inline -->
            <form wire:submit.prevent="saveValue" class="flex gap-2 mb-4">
                <input type="text" class="input input-bordered w-full max-w-xs" placeholder="New value…"
                    wire:model="valueText">
                <button type="submit" class="btn btn-sm btn-primary" wire:loading.attr="disabled" wire:target="saveValue">
                    <span wire:loading wire:target="saveValue" class="loading loading-xs mr-2"></span>
                    {{ $valueId ? 'Update' : 'Add' }}
                </button>
                @if($valueId)
                <button type="button" class="btn btn-sm" wire:click="resetValueForm">Cancel</button>
                @endif
            </form>
            @error('valueText') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            <!-- Values table -->
            <div class="overflow-x-auto">
                <table class="table table-compact w-full">
                    <thead>
                        <tr>
                            <th>Value</th>
                            <th>Usage</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($valuesAttribute->values as $v)
                        <tr>
                            <td>{{ $v->value }}</td>
                            <td>{{ $v->product()->count() }} product(s)</td>
                            <td>
                                <button class="btn btn-xs" wire:click="editValue({{ $v->id }})">Edit</button>
                                <button class="btn btn-xs btn-error"
                                    onclick="confirm('Delete?') || event.stopImmediatePropagation()"
                                    wire:click="deleteValue({{ $v->id }})">Delete</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-12">
                                <div class="flex flex-col items-center">
                                    <x-heroicon-o-inbox-stack class="w-16 h-16 text-gray-400 mb-4" />
                                    <p class="text-gray-500 text-lg font-medium">No Values found.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

    {{-- Create Modal --}}
    @if($showCreateModal)
    <div class="modal modal-open">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">Create Attribute</h3>

            <form wire:submit.prevent="storeAttr">
                <div class="form-control mb-3">
                    <label class="label"><span class="label-text">Name</span></label>
                    <input type="text" class="input input-bordered" wire:model="type"
                        placeholder="Enter attribute name" />
                    @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-control mb-4">
                    <label class="cursor-pointer label">
                        <span class="label-text">Filterable</span>
                        <input type="checkbox" class="checkbox checkbox-success" wire:model="is_filterable" />
                    </label>
                </div>

                <div class="modal-action">
                    <button type="button" class="btn" wire:click="closeCreateModal">Cancel</button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="storeAttr">
                        <span wire:loading wire:target="storeAttr" class="loading loading-xs mr-2"></span>
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Edit Modal --}}
    @if($showEditModal)
    <div class="modal modal-open">
        <div class="modal-box">
            <h3 class="font-bold text-lg mb-4">Edit Attribute</h3>

            <form wire:submit.prevent="updateAttr">
                <div class="form-control mb-3">
                    <label class="label">
                        <span class="label-text">Name</span>
                    </label>
                    <input type="text" class="input input-bordered" wire:model="type"
                        placeholder="Enter attribute name" />
                    @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="form-control mb-4">
                    <label class="cursor-pointer label">
                        <span class="label-text">Filterable</span>
                        <input type="checkbox" class="checkbox checkbox-success" wire:model="is_filterable" />
                    </label>
                </div>

                <div class="modal-action">
                    <button type="button" class="btn" wire:click="closeEditModal">Cancel</button>
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="updateAttr">
                        <span wire:loading wire:target="updateAttr" class="loading loading-xs mr-2"></span>
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- Delete Modal --}}
    @if($confirmDeleteModal)
    <div class="modal modal-open">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Confirm Delete</h3>
            <p class="py-4">Are you sure you want to delete this attribute?</p>
            <div class="modal-action">
                <button class="btn btn-sm" wire:click="$set('confirmDeleteModal', false)">Cancel</button>
                <button class="btn btn-sm btn-error" wire:click="deleteAttr">Delete</button>
            </div>
        </div>
    </div>
    @endif
</div>
