<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-4 text-black">My Orders</h1>

    {{-- Search Bar --}}
    <div class="mb-6">
        <div class="relative">
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Search by Order ID or Product Name..."
                class="input input-bordered w-full pl-10 pr-4 py-2 text-black bg-white border-gray-300 focus:border-purple-600 focus:ring-purple-600" />
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Tabs/Filters --}}
    <div class="tabs tabs-boxed mb-6 bg-gray-100">
        @foreach ([
        'all' => 'All Orders',
        'pending' => 'Pending',
        'processing' => 'Processing',
        'shipped' => 'Shipped',
        'delivered' => 'Delivered',
        'cancelled' => 'Cancelled / Failed',
    ] as $tab => $label)
            <button wire:click="setFilter('{{ $tab }}')"
                class="tab transition-all duration-200 {{ $status === $tab ? 'tab-active bg-purple-600 text-white' : '!text-gray-600 hover:text-purple-600' }}"
                wire:loading.attr="disabled">
                {{ $label }}
                @if ($tab !== 'all' && isset($statusCounts[$tab]) && $statusCounts[$tab] > 0)
                    <span
                        class="ml-2 badge badge-sm {{ $status === $tab ? 'badge-ghost' : 'bg-purple-100 text-purple-600' }}">
                        {{ $statusCounts[$tab] }}
                    </span>
                @endif
            </button>
        @endforeach
    </div>

    {{-- Loading Indicator --}}
    <div wire:loading class="flex justify-center items-center py-8">
        <div class="flex items-center space-x-2 text-purple-600">
            <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="m4 12a8 8 0 0 1 8-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 0 1 4 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span class="text-sm font-medium">Loading orders...</span>
        </div>
    </div>

    {{-- Order table --}}
    @if (Auth::check())
        <div class="overflow-x-auto rounded-box border border-base-content/5" wire:loading.class="opacity-50">
            <table class="table w-full text-black">
                <thead>
                    <tr class="text-black bg-gray-50">
                        <th class="font-semibold">Order ID</th>
                        <th class="font-semibold">Date</th>
                        <th class="font-semibold">Status</th>
                        <th class="font-semibold">Items</th>
                        <th class="font-semibold">Total</th>
                        <th class="font-semibold">Cancel</th>
                        <th class="font-semibold">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="font-mono text-sm">{{ $order->order_number }}</td>
                            <td>{{ $order->created_at->format('d M, Y') }}</td>
                            <td>
                                <span class="badge {{ $this->getStatusBadgeClass($order->status) }}">
                                    {{ $this->getStatusLabel($order->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="text-sm text-gray-600">
                                    {{ $order->items->count() }} item{{ $order->items->count() > 1 ? 's' : '' }}
                                </div>
                            </td>
                            <td class="font-semibold">${{ number_format($order->total, 2) }}</td>
                            <td>
                                @if ($order->status === 'pending')
                                    <button wire:click="cancelOrder('{{ $order->id }}')"
                                        wire:loading.attr="disabled"
                                        onclick="return confirm('Are you sure you want to cancel this order?')"
                                        class="btn btn-xs btn-error ml-2">
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Cancel
                                    </button>
                                @endif
                            </td>
                            <td>
                                <a wire:navigate href="{{ route('orders.show', $order->id) }}"
                                    class="text-purple-600 underline underline-offset-4 hover:text-purple-700 transition-colors duration-200">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12">
                                <div class="flex flex-col items-center">
                                    @if ($search)
                                        <svg class="w-20 h-20 text-gray-400 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        <p class="text-xl text-gray-600 mb-2">No orders found</p>
                                        <p class="text-gray-500">Try adjusting your search or filter criteria</p>
                                        <button wire:click="clearSearch"
                                            class="mt-3 text-purple-600 hover:text-purple-700 underline">
                                            Clear search
                                        </button>
                                    @else
                                        <svg class="w-20 h-20 text-purple-400 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M16 11V7a4 4 0 00-8 0v4M8 11v6a2 2 0 002 2h4a2 2 0 002-2v-6M8 11h8">
                                            </path>
                                        </svg>
                                        <p class="text-xl text-gray-600 mb-2">No orders yet</p>
                                        <p class="text-gray-500">Start shopping to see your orders here</p>
                                        <a wire:navigate href="{{ route('products') }}"
                                            class="mt-4 btn bg-purple-600 hover:bg-purple-700 text-white border-0">
                                            Start Shopping
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Results Summary --}}
        @if ($orders->count() > 0)
            <div class="mt-4 text-sm text-gray-600 flex justify-between items-center">
                <span>
                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results
                    @if ($search)
                        for "<strong>{{ $search }}</strong>"
                    @endif
                    @if ($status !== 'all')
                        in <strong>{{ $this->getStatusLabel($status) }}</strong> orders
                    @endif
                </span>
            </div>
        @endif
    @else
        <div class="text-center py-12 bg-white rounded-lg border border-gray-200">
            <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <p class="text-lg text-gray-600 mb-4">You need to login first to view your orders</p>
            <a wire:navigate href="{{ route('login') }}"
                class="btn bg-purple-600 hover:bg-purple-700 text-white border-0">
                Login to Continue
            </a>
        </div>
    @endif

    {{-- Pagination --}}
    @if ($orders->hasPages())
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @endif
</div>
