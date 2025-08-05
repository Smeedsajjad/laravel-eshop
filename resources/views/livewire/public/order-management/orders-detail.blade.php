<div class="max-w-4xl mx-auto px-4 py-8 space-y-8 text-black">

    <!-- HEADER -->
    <div class="flex flex-col sm:flex-row justify-between items-start">
        <h1 class="text-3xl font-bold text-gray-800">Order Details</h1>
        <div class="flex space-x-2 mt-2 sm:mt-0">
            <button wire:click="repeatOrder" class="btn btn-outline btn-primary btn-sm">
                Repeat Order
            </button>
        </div>
    </div>

    <!-- ORDER SUMMARY -->
    <div class="bg-white rounded-xl shadow p-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div>
            <h2 class="text-lg font-semibold mb-2">Order Summary</h2>
            <p><span class="font-medium">Order ID:</span> {{ $order->order_number }}</p>
            <p><span class="font-medium">Date:</span> {{ $order->created_at->format('d M, Y H:i') }}</p>
            <p><span class="font-medium">Total:</span> ${{ number_format($order->total, 2) }}</p>
        </div>

        <!-- ORDER STATUS TIMELINE -->
        <div>
            <h2 class="text-lg font-semibold mb-4">Order Status</h2>
            <ul class="timeline timeline-vertical lg:timeline-horizontal">
                <!-- Pending -->
                <li>
                    <div class="timeline-start timeline-box text-xs {{ in_array($order->status, ['pending', 'paid', 'shipped', 'delivered']) ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                        Pending
                    </div>
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                             class="h-4 w-4 {{ in_array($order->status, ['pending', 'paid', 'shipped', 'delivered']) ? 'text-purple-600' : 'text-gray-300' }}">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <hr class="{{ in_array($order->status, ['paid', 'shipped', 'delivered']) ? 'bg-purple-600' : 'bg-gray-300' }}" />
                </li>

                <!-- Paid -->
                <li>
                    <hr class="{{ in_array($order->status, ['paid', 'shipped', 'delivered']) ? 'bg-purple-600' : 'bg-gray-300' }}" />
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                             class="h-4 w-4 {{ in_array($order->status, ['paid', 'shipped', 'delivered']) ? 'text-purple-600' : 'text-gray-300' }}">
                            <path fill-rule="evenodd" d="M2.5 4A1.5 1.5 0 001 5.5V6h18v-.5A1.5 1.5 0 0017.5 4h-15zM19 8.5H1v6A1.5 1.5 0 002.5 16h15a1.5 1.5 0 001.5-1.5v-6zM3 13.25a.75.75 0 01.75-.75h1.5a.75.75 0 010 1.5h-1.5a.75.75 0 01-.75-.75zm4.75-.75a.75.75 0 000 1.5h3.5a.75.75 0 000-1.5h-3.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="timeline-end timeline-box text-xs {{ in_array($order->status, ['paid', 'shipped', 'delivered']) ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                        Paid
                    </div>
                    <hr class="{{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-purple-600' : 'bg-gray-300' }}" />
                </li>

                <!-- Shipped -->
                <li>
                    <hr class="{{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-purple-600' : 'bg-gray-300' }}" />
                    <div class="timeline-start timeline-box text-xs {{ in_array($order->status, ['shipped', 'delivered']) ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                        Shipped
                    </div>
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                             class="h-4 w-4 {{ in_array($order->status, ['shipped', 'delivered']) ? 'text-purple-600' : 'text-gray-300' }}">
                            <path d="M6.5 3c-1.051 0-2.093.04-3.125.117A1.49 1.49 0 002 4.607V10.5h9V4.606c0-.681.422-1.28 1.002-1.511A41.717 41.717 0 016.5 3zM12 5v5.5h8V9A3 3 0 0017 6h-2.5A2.5 2.5 0 0112 8.5V5z" />
                            <path d="M11 16.5c0-.818.393-1.544 1-2v-2.5h-9v2.5c.607.456 1 1.182 1 2a2.5 2.5 0 11-5 0c0-.818.393-1.544 1-2V12a1 1 0 011-1h9a1 1 0 011 1v2.5z" />
                        </svg>
                    </div>
                    <hr class="{{ $order->status === 'delivered' ? 'bg-purple-600' : 'bg-gray-300' }}" />
                </li>

                <!-- Delivered -->
                <li>
                    <hr class="{{ $order->status === 'delivered' ? 'bg-purple-600' : 'bg-gray-300' }}" />
                    <div class="timeline-middle">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                             class="h-4 w-4 {{ $order->status === 'delivered' ? 'text-purple-600' : 'text-gray-300' }}">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="timeline-end timeline-box text-xs {{ $order->status === 'delivered' ? 'bg-purple-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                        Delivered
                    </div>
                </li>
            </ul>

            <!-- Show cancelled status if applicable -->
            @if($order->status === 'cancelled')
                <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 text-red-600">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-red-600 font-medium">Order Cancelled</span>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- ADDRESSES -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-2">Shipping & Billing Address</h2>
        <p class="text-sm text-gray-600">
            {{ $order->address->fullName() }}<br>
            {{ $order->address->fullAddress() }}<br>
            {{ $order->address->phone }}
        </p>
    </div>

    <!-- ITEMS -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-semibold mb-4">Items Ordered</h2>
        <div class="space-y-4">
            @foreach ($order->items as $item)
                <div class="flex items-center space-x-4">
                    <a href="{{ route('product.details', $item->product->slug) }}">
                        <img src="{{ Storage::url($item->product->first_image_path) }}"
                            alt="{{ $item->product->name }}" class="w-20 h-20 rounded object-cover">
                    </a>
                    <div class="flex-1">
                        <a href="{{ route('product.details', $item->product->slug) }}"
                            class="font-semibold text-purple-600 hover:underline">
                            {{ $item->product->name }}
                        </a>
                        <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                    </div>
                    <p class="font-bold text-gray-900">${{ number_format($item->total, 2) }}</p>
                </div>
            @endforeach
        </div>
    </div>

</div>
