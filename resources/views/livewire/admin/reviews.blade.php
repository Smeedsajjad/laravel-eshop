<div class="p-6">
    <div class="flex w-full items-center justify-between">
        <h1 class="text-gray-300 text-3xl">Manage Reviews</h1>

        <div class="breadcrumbs text-sm">
            <ul>
                <li>
                    <a wire:navigate href="{{ route('admin.dashboard') }}">
                        <x-heroicon-s-home class="text-white size-4" /> Home
                    </a>
                </li>
                <li>
                    <a wire:navigate href="{{ route('admin.reviews') }}">
                        <x-heroicon-s-star class="text-white size-4" /> Reviews
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <hr class="my-10 border-gray-700">
    <!-- Stats -->
    <div class="stats stats-vertical md:stats-horizontal shadow mb-4">
        <div class="stat">
            <div class="stat-title">Total Reviews</div>
            <div class="stat-value">{{ $stats['total'] }}</div>
        </div>
        <div class="stat">
            <div class="stat-title">Average Rating</div>
            <div class="stat-value">{{ $stats['average'] }} ★</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="flex flex-col sm:flex-row gap-2 mb-4">
        <input type="text" placeholder="Search comment or product…" class="input input-bordered w-full sm:w-1/2"
            wire:model.live.debounce.300ms="search">
        <select class="select select-bordered w-full sm:w-auto" wire:model.live="filterRating">
            <option value="">All ratings</option>
            @for($i=1;$i<=5;$i++) <option value="{{ $i }}">{{ $i }} star{{ $i>1?'s':'' }}</option>
                @endfor
        </select>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="table table-compact w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>User</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr>
                    <td>{{ $review->id }}</td>
                    <td>{{ $review->product->name }}</td>
                    <td>{{ $review->user->name }}</td>
                    <td>{{ $review->rating }} ★</td>
                    <td>{{ \Illuminate\Support\Str::limit($review->comment, 50) }}</td>
                    <td>{{ $review->created_at->diffForHumans() }}</td>
                    <td>
                        <button wire:click="confirmDelete({{ $review->id }})" class="btn btn-xs btn-error">
                            Del
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">
                    <x-heroicon-s-star class="inline h-8 w-8 sm:h-5 sm:w-5" />
                        No reviews found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $reviews->links() }}

    @if(session('message'))
    <div class="alert alert-success mt-4">{{ session('message') }}</div>
    @endif

    <!-- Delete‑Modal Toggle -->
    <input type="checkbox" id="deleteModal" class="modal-toggle" wire:model="confirmingDelete" />

    <label for="deleteModal" class="modal cursor-pointer">
        <label class="modal-box relative">
            <h3 class="text-lg font-bold">Confirm Delete</h3>
            <p class="py-4">
                Are you sure you want to delete review #{{ $toDelete }}?
            </p>
            <div class="modal-action">
                <button type="button" class="btn btn-sm" wire:click="$set('confirmingDelete', false)">Cancel</button>
                <button type="button" class="btn btn-sm btn-error" wire:click="delete">Delete</button>
            </div>
        </label>
    </label>

</div>
