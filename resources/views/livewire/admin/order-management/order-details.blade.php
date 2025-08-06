<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row justify-between items-start mb-6">
        <div class="flex items-center space-x-4">
            <a wire:navigate href="{{ route('admin.orders.index') }}" class="btn btn-ghost btn-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Orders
            </a>
            <div>
                <h1 class="text-3xl font-bold text-white">Order Details</h1>
                <p class="text-gray-600">Order #{{ $order->order_number }}</p>
            </div>
        </div>
        <div class="flex space-x-2 mt-4 sm:mt-0">
            <button wire:click="printOrder" class="btn btn-outline btn-primary btn-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Print
            </button>
            <button wire:click="sendEmailToCustomer" class="btn btn-outline btn-secondary btn-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Send Email
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- MAIN CONTENT -->
        <div class="lg:col-span-2 space-y-6">
            <!-- ORDER STATUS TIMELINE -->
            <div class="bg-base-100 rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Order Status</h2>
                <ul class="timeline timeline-vertical lg:timeline-horizontal">
                    <!-- Pending -->
                    <li>
                        <div class="timeline-start timeline-box text-xs {{ in_array($order->status, ['pending', 'paid', 'processing', 'shipped', 'delivered']) ? 'bg-primary text-primary-content' : 'bg-base-200 text-base-content' }}">
                            Pending
                        </div>
                        <div class="timeline-middle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                 class="h-4 w-4 {{ in_array($order->status, ['pending', 'paid', 'processing', 'shipped', 'delivered']) ? 'text-primary' : 'text-base-300' }}">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <hr class="{{ in_array($order->status, ['paid', 'processing', 'shipped', 'delivered']) ? 'bg-primary' : 'bg-base-300' }}" />
                    </li>

                    <!-- Processing/Paid -->
                    <li>
                        <hr class="{{ in_array($order->status, ['paid', 'processing', 'shipped', 'delivered']) ? 'bg-primary' : 'bg-base-300' }}" />
                        <div class="timeline-middle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                 class="h-4 w-4 {{ in_array($order->status, ['paid', 'processing', 'shipped', 'delivered']) ? 'text-primary' : 'text-base-300' }}">
                                <path fill-rule="evenodd" d="M2.5 4A1.5 1.5 0 001 5.5V6h18v-.5A1.5 1.5 0 0017.5 4h-15zM19 8.5H1v6A1.5 1.5 0 002.5 16h15a1.5 1.5 0 001.5-1.5v-6zM3 13.25a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5h-1.5a.75.75 0 01-.75-.75zm4.75-.75a.75.75 0 000 1.5h3.5a.75.75 0 000-1.5h-3.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="timeline-end timeline-box text-xs {{ in_array($order->status, ['paid', 'processing', 'shipped', 'delivered']) ? 'bg-primary text-primary-content' : 'bg-base-200 text-base-content' }}">
                            Processing
                        </div>
                        <hr class="{{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-primary' : 'bg-base-300' }}" />
                    </li>

                    <!-- Shipped -->
                    <li>
                        <hr class="{{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-primary' : 'bg-base-300' }}" />
                        <div class="timeline-start timeline-box text-xs {{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-primary text-primary-content' : 'bg-base-200 text-base-content' }}">
                            Shipped
                        </div>
                        <div class="timeline-middle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                 class="h-4 w-4 {{ in_array($order->status, ['shipped', 'delivered']) ? 'text-primary' : 'text-base-300' }}">
                                <path d="M6.5 3c-1.051 0-2.093.04-3.125.117A1.49 1.49 0 002 4.607V10.5h9V4.606c0-.681.422-1.28 1.002-1.511A41.717 41.717 0 016.5 3zM12 5v5.5h8V9A3 3 0 0017 6h-2.5A2.5 2.5 0 0112 8.5V5z" />
                                <path d="M11 16.5c0-.818.393-1.544 1-2v-2.5h-9v2.5c.607.456 1 1.182 1 2a2.5 2.5 0 11-5 0c0-.818.393-1.544 1-2V12a1 1 0 011-1h9a1 1 0 011 1v2.5z" />
                            </svg>
                        </div>
                        <hr class="{{ $order->status === 'delivered' ? 'bg-primary' : 'bg-base-300' }}" />
                    </li>

                    <!-- Delivered -->
                    <li>
                        <hr class="{{ $order->status === 'delivered' ? 'bg-primary' : 'bg-base-300' }}" />
                        <div class="timeline-middle">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                 class="h-4 w-4 {{ $order->status === 'delivered' ? 'text-primary' : 'text-base-300' }}">
                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="timeline-end timeline-box text-xs {{ $order->status === 'delivered' ? 'bg-primary text-primary-content' : 'bg-base-200 text-base-content' }}">
                            Delivered
                        </div>
                    </li>
                </ul>

                <!-- Show cancelled status if applicable -->
                @if($order->status === 'cancelled')
                    <div class="mt-4 p-3 bg-error/10 border border-error/20 rounded-lg">
                        <div class="flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 text-error">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-error font-medium">Order Cancelled</span>
                        </div>
                    </div>
                @endif

                <!-- Status Update Controls -->
                <div class="mt-6 p-4 bg-base-200 rounded-lg">
                    <h3 class="font-semibold mb-3">Update Order Status</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $statusOption)
                            @if($statusOption !== $order->status)
                                <button
                                    wire:click="updateStatus('{{ $statusOption }}')"
                                    class="btn btn-sm {{ $this->getStatusButtonClass($statusOption) }}"
                                    wire:loading.attr="disabled"
                                >
                                    <span class="w-2 h-2 rounded-full {{ $this->getStatusDotClass($statusOption) }} mr-2"></span>
                                    {{ $this->getStatusLabel($statusOption) }}
                                </button>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- ORDER ITEMS -->
            <div class="bg-base-100 rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Order Items</h2>
                <div class="space-y-4">
                    @foreach ($order->items as $item)
                        <div class="flex items-center space-x-4 p-3 bg-base-50 rounded-lg">
                            <a href="{{ route('admin.products.show', $item->product->id) }}">
                                <img src="{{ Storage::url($item->product->first_image_path) }}"
                                     alt="{{ $item->product->name }}"
                                     class="w-16 h-16 rounded object-cover">
                            </a>
                            <div class="flex-1">
                                <a href="{{ route('admin.products.show', $item->product->id) }}"
                                   class="font-semibold text-primary hover:text-primary-focus">
                                    {{ $item->product->name }}
                                </a>
                                <div class="text-sm text-gray-500 mt-1">
                                    <p>SKU: {{ $item->product->sku ?? 'N/A' }}</p>
                                    @if($item->product_attribute_value_id)
                                        <p>Variant: {{ $item->productAttributeValue->value ?? 'N/A' }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-500">Unit Price</p>
                                <p class="font-semibold">${{ number_format($item->price, 2) }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-500">Quantity</p>
                                <p class="font-semibold">{{ $item->quantity }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm text-gray-500">Total</p>
                                <p class="font-semibold">${{ number_format($item->total, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Totals -->
                <div class="mt-6 border-t pt-4">
                    <div class="flex justify-end">
                        <div class="w-64 space-y-2">
                            <div class="flex justify-between">
                                <span>Subtotal:</span>
                                <span>${{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            @if($order->tax > 0)
                                <div class="flex justify-between">
                                    <span>Tax:</span>
                                    <span>${{ number_format($order->tax, 2) }}</span>
                                </div>
                            @endif
                            @if($order->shipping_cost > 0)
                                <div class="flex justify-between">
                                    <span>Shipping:</span>
                                    <span>${{ number_format($order->shipping_cost, 2) }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between font-bold text-lg border-t pt-2">
                                <span>Total:</span>
                                <span>${{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SIDEBAR -->
        <div class="space-y-6">
            <!-- ORDER SUMMARY -->
            <div class="bg-base-100 rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Order Summary</h2>
                <div class="space-y-3">
                    <div>
                        <span class="text-sm text-gray-500">Order ID:</span>
                        <p class="font-mono">{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Date:</span>
                        <p>{{ $order->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Status:</span>
                        <p>
                            <span class="badge {{ $this->getStatusBadgeClass($order->status) }}">
                                {{ $this->getStatusLabel($order->status) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Total Amount:</span>
                        <p class="text-lg font-bold">${{ number_format($order->total, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- CUSTOMER INFO -->
            <div class="bg-base-100 rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Customer Information</h2>
                <div class="space-y-3">
                    <div>
                        <span class="text-sm text-gray-500">Name:</span>
                        <p class="font-medium">{{ $order->user->name }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Email:</span>
                        <p>{{ $order->user->email }}</p>
                    </div>
                    @if($order->user->phone)
                        <div>
                            <span class="text-sm text-gray-500">Phone:</span>
                            <p>{{ $order->user->phone }}</p>
                        </div>
                    @endif
                    {{-- <div class="pt-2">
                        <a href="{{ route('admin.customers.show', $order->user->id) }}"
                           class="btn btn-outline btn-primary btn-sm w-full">
                            View Customer Profile
                        </a>
                    </div> --}}
                </div>
            </div>

            <!-- SHIPPING ADDRESS -->
            @if($order->address)
                <div class="bg-base-100 rounded-xl shadow p-6">
                    <h2 class="text-lg font-semibold mb-4">Shipping Address</h2>
                    <div class="text-sm">
                        <p class="font-medium">{{ $order->address->fullName() }}</p>
                        <p>{{ $order->address->fullAddress() }}</p>
                        @if($order->address->phone)
                            <p class="mt-2">{{ $order->address->phone }}</p>
                        @endif
                    </div>
                </div>
            @endif

            <!-- PAYMENT INFO -->
            <div class="bg-base-100 rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Payment Information</h2>
                <div class="space-y-3">
                    <div>
                        <span class="text-sm text-gray-500">Payment Status:</span>
                        <p>
                            <span class="badge {{ in_array($order->status, ['paid', 'shipped', 'delivered']) ? 'badge-success' : 'badge-warning' }}">
                                {{ in_array($order->status, ['paid', 'shipped', 'delivered']) ? 'Paid' : 'Pending' }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Payment Method:</span>
                        <p>{{ $order->payment_method ?? 'Not specified' }}</p>
                    </div>
                    @if($order->transaction_id)
                        <div>
                            <span class="text-sm text-gray-500">Transaction ID:</span>
                            <p class="font-mono text-xs">{{ $order->transaction_id }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- CUSTOMER NOTES -->
            @if($order->customer_note)
                <div class="bg-base-100 rounded-xl shadow p-6">
                    <h2 class="text-lg font-semibold mb-4">Customer Notes</h2>
                    <div class="bg-base-200 p-3 rounded-lg">
                        <p class="text-sm">{{ $order->customer_note }}</p>
                    </div>
                </div>
            @endif

            <!-- ADMIN ACTIONS -->
            <div class="bg-base-100 rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Admin Actions</h2>
                <div class="space-y-2">
                    <button wire:click="refundOrder" class="btn btn-outline btn-warning btn-sm w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                        </svg>
                        Process Refund
                    </button>
                    {{-- <button wire:click="duplicateOrder" class="btn btn-outline btn-info btn-sm w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Duplicate Order
                    </button> --}}
                    <button wire:click="deleteOrder" wire:confirm="Are you sure you want to delete this order? This action cannot be undone."
                            class="btn btn-outline btn-error btn-sm w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete Order
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notifications -->
    @if (session()->has('message'))
        <div class="toast toast-top toast-end z-10">
            <div class="alert alert-success">
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="toast toast-top toast-end z-10">
            <div class="alert alert-error">
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif
</div>
