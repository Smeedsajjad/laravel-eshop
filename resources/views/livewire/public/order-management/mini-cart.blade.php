<div>
    <style>
        .menu :where(li)>*:not(ul, .menu-title, details, .btn):active {
            background-color: transparent;
            cursor: default
        }
    </style>
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-semibold text-black">Shopping Cart</h1>
        {{-- Use a Livewire click event to close the drawer, which will update the drawerOpen property in AppLayout --}}
        <button type="button" class="btn btn-sm btn-circle bg-transparent border-0 shadow-none text-gray-600"
            onclick="document.getElementById('mini-cart-toggle').checked = false;">
            <x-heroicon-o-x-mark class="h-6 w-6" />
        </button>
    </div>
    <hr class="border-gray-200 my-4">

    {{-- Items --}}
    <ul class="space-y-4 flex-1 overflow-y-auto h-[calc(100vh-220px)]">

        @if(Auth::check())
        @forelse($items as $item)
        @if($item->product)
        <li class="flex flex-row justify-between bg-transparent" wire:key="cart-item-{{ $item->product_id }}">
            {{-- Image --}}
            <img src="{{ $item->product->first_image_path ? Storage::url($item->product->first_image_path) : asset('images/no-image.webp') }}"
                alt="{{ $item->product->name }}" class="size-20 rounded object-cover">

            {{-- Details --}}
            <div class="flex-1">
                <p class="text-sm font-semibold text-black bg-transparent">{{ $item->product->name }}</p>
                <p class="text-xs text-gray-500">
                    ${{ number_format($item->product->price, 2) }} × {{ $item->quantity }}
                </p>
            </div>

            {{-- Controls --}}
            <div class="flex items-center space-x-2 w-full justify-between">
                <div class="flex items-center space-x-1">
                    <button wire:click="decrement({{ $item->product_id }})"
                        class="btn btn-sm bg-softPurple border-0 text-gray-600">
                        −
                    </button>
                    <input type="number" value="{{ $item->quantity }}" readonly
                        class="input input-sm bg-white border-2 border-purple-600 text-black w-12 text-center">
                    <button wire:click="increment({{ $item->product_id }})"
                        class="btn btn-sm bg-softPurple border-0 text-gray-600">
                        +
                    </button>
                </div>
                <button wire:click="remove({{ $item->product_id }})"
                    class="btn btn-sm bg-transparent hover:bg-transparent border-0 shadow-none text-red-500">
                    <x-heroicon-o-trash class="size-6" />
                </button>
            </div>
        </li>
        @endif
        @empty
        <li class="text-center text-sm text-gray-400 py-10">
            Your cart is empty
        </li>
        @endforelse
        @else
        <p class="text-lg text-gray-600 text-center">You Need to Login First.</p>
        <a wire:navigate href="{{ route('login') }}" class="btn bg-purple-600 hover:bg-purple-700 text-white border-0 w-full">
            Login to Add
        </a>
        @endif


    </ul>

    {{-- Footer --}}
    <div class="absolute bottom-0 right-0 left-0 p-4 bg-white border-t">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-black">Subtotal</h2>
            <p class="text-xl font-bold text-purple-600">
                ${{ number_format($total, 2) }}
            </p>
        </div>

        <div class="grid grid-cols-1 gap-2">
            <a href="{{ route('cart') }}" class="btn bg-softPurple text-purple-700 border-0 w-full">
                View Cart
            </a>
            <button class="btn bg-purple-600 hover:bg-purple-700 text-white border-0 w-full">
                Checkout
            </button>
        </div>
    </div>
</div>
