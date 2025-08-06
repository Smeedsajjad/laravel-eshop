<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-start mb-6">
        <h1 class="text-3xl font-bold mb-4 text-white">Orders Management</h1>
        <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
            {{-- Export Options --}}
            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn btn-outline btn-primary btn-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Export
                </label>
                <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a wire:click="exportOrders('csv')">Export as CSV</a></li>
                    <li><a wire:click="exportOrders('pdf')">Export as PDF</a></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Search and Quick Stats --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-6">
        {{-- Search Bar --}}
        <div class="lg:col-span-2">
            <div class="relative">
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Search by Order ID, Customer Name, or Email..."
                    class="input input-bordered w-full pl-10 pr-4" />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                @if ($search)
                    <button wire:click="$set('search', '')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <svg class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                @endif
            </div>
        </div>

        {{-- Quick Stats --}}
        <div class="stats shadow lg:col-span-2">
            <div class="stat place-items-center">
                <div class="stat-title text-xs">Today's Orders</div>
                <div class="stat-value text-primary text-2xl">{{ $todayOrders }}</div>
            </div>
            <div class="stat place-items-center">
                <div class="stat-title text-xs">Total Revenue</div>
                <div class="stat-value text-success text-2xl">${{ number_format($totalRevenue, 0) }}</div>
            </div>
        </div>
    </div>

    {{-- Status Filter Tabs --}}
    <div class="tabs tabs-boxed mb-6 bg-base-200">
        @foreach ([
        'all' => ['label' => 'All Orders', 'count' => $statusCounts['all'] ?? 0],
        'pending' => ['label' => 'Pending', 'count' => $statusCounts['pending'] ?? 0],
        'processing' => ['label' => 'Processing', 'count' => $statusCounts['processing'] ?? 0],
        'shipped' => ['label' => 'Shipped / In Transit', 'count' => $statusCounts['shipped'] ?? 0],
        'delivered' => ['label' => 'Delivered', 'count' => $statusCounts['delivered'] ?? 0],
        'cancelled' => ['label' => 'Cancelled / Failed', 'count' => $statusCounts['cancelled'] ?? 0],
    ] as $tab => $data)
            <button wire:click="setFilter('{{ $tab }}')"
                class="tab transition-all duration-200 {{ $status === $tab ? 'tab-active' : '' }}"
                wire:loading.attr="disabled">
                {{ $data['label'] }}
                @if ($data['count'] > 0)
                    <span class="ml-2 badge badge-sm {{ $status === $tab ? 'badge-neutral' : 'badge-ghost' }}">
                        {{ $data['count'] }}
                    </span>
                @endif
            </button>
        @endforeach
    </div>

    {{-- Loading Indicator --}}
    <div wire:loading class="flex justify-center items-center py-8">
        <div class="flex items-center space-x-2">
            <span class="loading loading-spinner loading-md text-primary"></span>
            <span class="text-sm font-medium">Loading orders...</span>
        </div>
    </div>

    {{-- Orders Table --}}
    <div class="overflow-x-auto rounded-lg border border-base-300 bg-base-100" wire:loading.class="opacity-50">
        <table class="table table-zebra w-full">
            <thead>
                <tr class="bg-base-200">
                    <th class="font-semibold">
                        <button wire:click="sortBy('order_number')"
                            class="flex items-center space-x-1 hover:text-primary">
                            <span>Order ID</span>
                            @if ($sortField === 'order_number')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"></path>
                                </svg>
                            @endif
                        </button>
                    </th>
                    <th class="font-semibold">Customer</th>
                    <th class="font-semibold">
                        <button wire:click="sortBy('created_at')"
                            class="flex items-center space-x-1 hover:text-primary">
                            <span>Date</span>
                            @if ($sortField === 'created_at')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"></path>
                                </svg>
                            @endif
                        </button>
                    </th>
                    <th class="font-semibold">Status</th>
                    <th class="font-semibold">Items</th>
                    <th class="font-semibold">
                        <button wire:click="sortBy('total')" class="flex items-center space-x-1 hover:text-primary">
                            <span>Total</span>
                            @if ($sortField === 'total')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"></path>
                                </svg>
                            @endif
                        </button>
                    </th>
                    <th class="font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr class="hover:bg-base-200 transition-colors duration-200">
                        <td>
                            <div class="font-mono text-sm font-medium">{{ $order->order_number }}</div>
                        </td>
                        <td>
                            <div class="flex flex-col">
                                <div class="font-medium">{{ $order->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-col">
                                <div class="text-sm">{{ $order->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="dropdown dropdown-end">
                                <label tabindex="0"
                                    class="btn btn-sm {{ $this->getStatusButtonClass($order->status) }} cursor-pointer">
                                    {{ $this->getStatusLabel($order->status) }}
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </label>
                                <ul tabindex="0"
                                    class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-48">
                                    @foreach (['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $statusOption)
                                        @if ($statusOption !== $order->status)
                                            <li>
                                                <a wire:click="updateOrderStatus('{{ $order->id }}', '{{ $statusOption }}')"
                                                    class="flex items-center space-x-2">
                                                    <span
                                                        class="w-3 h-3 rounded-full {{ $this->getStatusDotClass($statusOption) }}"></span>
                                                    <span>{{ $this->getStatusLabel($statusOption) }}</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </td>
                        <td>
                            <div class="text-sm">
                                {{ $order->items->count() }} item{{ $order->items->count() > 1 ? 's' : '' }}
                            </div>
                        </td>
                        <td class="font-semibold">${{ number_format($order->total, 2) }}</td>
                        <td>
                            <div class="flex space-x-2">
                                <a wire:navigate href="{{ route('admin.orders.show', $order) }}"
                                    class="btn btn-ghost btn-sm text-primary hover:text-primary-focus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                </a>
                                <div class="dropdown dropdown-end">
                                    <label tabindex="0" class="btn btn-ghost btn-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                            </path>
                                        </svg>
                                    </label>
                                    <ul tabindex="0"
                                        class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-40">
                                        <li><a wire:click="printOrder('{{ $order->id }}')">Print Order</a></li>
                                        <li><a wire:click="sendEmail('{{ $order->id }}')">Send Email</a></li>
                                        <li class="border-t pt-1 mt-1"><a
                                                wire:click="deleteOrder('{{ $order->id }}')"
                                                class="text-error">Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-12">
                            <div class="flex flex-col items-center">
                                @if ($search)
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <p class="text-lg text-gray-600 mb-2">No orders found</p>
                                    <p class="text-gray-500 mb-4">Try adjusting your search or filter criteria</p>
                                    <button wire:click="clearSearch" class="btn btn-primary btn-sm">
                                        Clear Search
                                    </button>
                                @else
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M16 11V7a4 4 0 00-8 0v4M8 11v6a2 2 0 002 2h4a2 2 0 002-2v-6M8 11h8">
                                        </path>
                                    </svg>
                                    <p class="text-lg text-gray-600 mb-2">No orders yet</p>
                                    <p class="text-gray-500">Orders will appear here once customers start purchasing
                                    </p>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Results Summary and Pagination --}}
    @if ($orders->count() > 0)
        <div class="mt-6 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
            <div class="text-sm text-gray-600">
                Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} results
                @if ($search)
                    for "<strong>{{ $search }}</strong>"
                @endif
                @if ($status !== 'all')
                    in <strong>{{ $this->getStatusLabel($status) }}</strong> orders
                @endif
            </div>

            @if ($orders->hasPages())
                <div>
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    @endif

    {{-- Toast Notifications --}}
    @if (session()->has('message'))
        <div class="toast toast-top toast-end">
            <div class="alert alert-success">
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="toast toast-top toast-end">
            <div class="alert alert-error">
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif
</div>
