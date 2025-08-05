<div class="max-w-5xl mx-auto text-black px-4 py-8 grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- LEFT: Address & Items --}}
    <div class="lg:col-span-2 space-y-6">
        <h1 class="text-2xl font-bold mb-4">Checkout</h1>
        {{-- Address --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold mb-4">Shipping Address</h2>
            @if (Auth::user()->addresses->isEmpty())
                <p class="text-gray-500 mb-3">No saved address yet.</p>
                <a href="{{ route('address') }}" class="btn btn-outline btn-primary btn-sm">Add Address</a>
            @else
                @foreach (Auth::user()->addresses as $addr)
                    <label
                        class="flex items-center border rounded-lg p-4 mb-3 cursor-pointer
                                  {{ $selectedAddressId == $addr->id ? 'border-purple-500 bg-purple-50' : 'border-gray-200' }}">
                        <input type="radio" wire:model.live="selectedAddressId" value="{{ $addr->id }}"
                            class="radio text-purple-600 mr-3">
                        <div>
                            <p class="font-semibold">{{ $addr->fullName() }}</p>
                            <p class="text-sm text-gray-600">{{ $addr->fullAddress() }}</p>
                            @if ($addr->is_default)
                                <span class="badge bg-purple-600 border-0 text-white badge-sm">Default</span>
                            @endif
                        </div>
                    </label>
                @endforeach
            @endif
        </div>

        {{-- Items --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold mb-4">Order Items</h2>
            @foreach ($cart as $item)
                <div class="flex items-center space-x-4 mb-4">
                    <img src="{{ Storage::url($item->product->first_image_path) }}"
                        class="w-16 h-16 rounded object-cover">
                    <div class="flex-1">
                        <p class="font-semibold">{{ $item->product->name }}</p>
                        <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                    </div>
                    <p class="font-bold text-purple-600">
                        ${{ number_format($item->product->price * $item->quantity, 2) }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- RIGHT: Summary --}}
    <div class="bg-white rounded-xl shadow p-6 space-y-4 border-purple-600 border h-fit">
        <h2 class="text-xl font-bold">Order Summary</h2>

        <div class="flex justify-between"><span>Subtotal</span><span>${{ number_format($subtotal, 2) }}</span></div>
        <div class="flex justify-between"><span>Tax</span><span>${{ number_format($tax, 2) }}</span></div>
        <div class="flex justify-between"><span>Standard Shipping (4
                days)</span><span>${{ number_format($shipping, 2) }}</span></div>
        <hr>
        <div class="flex justify-between font-bold text-lg">
            <span>Total</span><span class="text-purple-600">${{ number_format($total, 2) }}</span>
        </div>

        <button wire:click="proceed" wire:loading.attr="disabled"
            class="btn bg-gradient-to-r from-purple-600 to-purple-700 text-white font-semibold w-full py-3 rounded-lg hover:from-purple-700 hover:to-purple-800 border-0 {{ empty($selectedAddressId) ? 'btn-disabled opacity-50 cursor-not-allowed' : '' }}"
            @empty($selectedAddressId) disabled @endif>
            <span wire:loading wire:target="proceed" class="flex items-center justify-center gap-2">
                <span class="loading loading-spinner"></span>Processing...
            </span>
            <span wire:loading.remove wire:target="proceed">Proceed to Checkout</span>
        </button>
    </div>
</div>
