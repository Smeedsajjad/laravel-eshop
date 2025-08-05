<div>
    <style>
        span.relative.inline-flex.items-center.px-2.py-2.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.cursor-default.rounded-l-md.leading-5.dark\:bg-gray-800.dark\:border-gray-600,
        span.relative.inline-flex.items-center.px-4.py-2.-ml-px.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.cursor-default.leading-5.dark\:bg-gray-800.dark\:border-gray-600,
        button.relative.inline-flex.items-center.px-2.py-2.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.rounded-l-md.leading-5.hover\:text-gray-400.focus\:z-10.focus\:outline-none.focus\:border-blue-300.focus\:ring.ring-blue-300.active\:bg-gray-100.active\:text-gray-500.transition.ease-in-out.duration-150.dark\:bg-gray-800.dark\:border-gray-600.dark\:active\:bg-gray-700.dark\:focus\:border-blue-800,
        span.relative.inline-flex.items-center.px-2.py-2.-ml-px.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.cursor-default.rounded-r-md.leading-5.dark\:bg-gray-800.dark\:border-gray-600 {
            background-color: rgb(119, 32, 182);
        }

        button.relative.inline-flex.items-center.px-4.py-2.-ml-px.text-sm.font-medium.text-gray-700.bg-white.border.border-gray-300.leading-5.hover\:text-gray-500.focus\:z-10.focus\:outline-none.focus\:border-blue-300.focus\:ring.ring-blue-300.active\:bg-gray-100.active\:text-gray-700.transition.ease-in-out.duration-150.dark\:bg-gray-800.dark\:border-gray-600.dark\:text-gray-400.dark\:hover\:text-gray-300.dark\:active\:bg-gray-700.dark\:focus\:border-blue-800,
        button.relative.inline-flex.items-center.px-2.py-2.-ml-px.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.rounded-r-md.leading-5.hover\:text-gray-400.focus\:z-10.focus\:outline-none.focus\:border-blue-300.focus\:ring.ring-blue-300.active\:bg-gray-100.active\:text-gray-500.transition.ease-in-out.duration-150.dark\:bg-gray-800.dark\:border-gray-600.dark\:active\:bg-gray-700.dark\:focus\:border-blue-800,
        [type='checkbox']:checked:hover,
        [type='checkbox']:checked:focus,
        [type='radio']:checked:hover,
        [type='radio']:checked:focus {
            background-color: #9333ea;
        }
    </style>
    <div class="flex flex-col lg:flex-row gap-8 w-full p-4 md:p-6">
        <aside class="w-full md:flex hidden lg:w-1/4">
            <div class="bg-white rounded-xl shadow-xl p-6 space-y-4">
                <h2 class="text-lg font-bold text-gray-800 border-b pb-2">Menu</h2>

                @if(Auth::check() && Auth::user()->is_admin)
                <a href="{{ route('admin.profile') }}" wire:navigate
                    class="text-black block px-3 py-2 rounded-md text-sm hover:bg-purple-100">Profile</a>
                <a href="{{ route('admin.dashboard') }}" wire:navigate
                    class="text-black block px-3 py-2 rounded-md text-sm hover:bg-purple-100">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" wire:navigate
                    class="text-black block px-3 py-2 rounded-md text-sm hover:bg-purple-100">Products</a>
                <a href="{{ route('admin.category') }}" wire:navigate
                    class="text-black block px-3 py-2 rounded-md text-sm hover:bg-purple-100">Categories</a>
                <a href="{{ route('admin.dashboard') }}" wire:navigate
                    class="text-black block px-3 py-2 rounded-md text-sm hover:bg-purple-100">Orders</a>
                <a href="{{ route('admin.reviews') }}" wire:navigate
                    class="text-black block px-3 py-2 rounded-md text-sm hover:bg-purple-100">Reviews</a>
                <a href="{{ route('admin.attributes') }}" wire:navigate
                    class="text-black block px-3 py-2 rounded-md text-sm hover:bg-purple-100">Attributes</a>

                @else
                <a href="{{ route('profile.show') }}" wire:navigate
                    class="text-black block px-3 py-2 rounded-md text-sm hover:bg-purple-100">Profile</a>
                <a href="{{ route('home') }}" wire:navigate
                    class="text-black block px-3 py-2 rounded-md text-sm font-semibold">Home</a>
                <a href="{{ route('products') }}" wire:navigate
                    class="text-black block px-3 py-2 rounded-md text-sm font-semibold">Products</a>
                <a href="{{ route('category') }}" wire:navigate
                    class="text-black block px-3 py-2 rounded-md text-sm font-semibold">Category</a>
                <a href="{{ route('cart') }}" wire:navigate
                    class="text-black block px-3 py-2 rounded-md text-sm font-semibold">Cart</a>
                <a href="{{ route('contact') }}" wire:navigate
                    class="text-black block px-3 py-2 rounded-md text-sm font-semibold">Contact Us</a>
                <a href="{{ route('about') }}" wire:navigate
                    class="text-black block px-3 py-2 rounded-md text-sm font-semibold">About Us</a>
                <a href="{{ route('wishlist') }}" wire:navigate
                    class="text-black block px-3 py-2 rounded-md text-sm font-semibold">Wishlist</a>
                {{-- <a href="{{ route('order') }}" wire:navigate
                    class="text-black block px-3 py-2 rounded-md text-sm hover:bg-purple-100">Orders</a> --}}
                @endif
            </div>
        </aside>

        {{-- 2️⃣ PRODUCT GRID --}}
        <main class="w-full lg:w-3/4">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">My Wishlist</h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($products as $product)
                <div class="card bg-white rounded-lg overflow-hidden group shadow-sm hover:shadow-md transition-shadow">

                    {{-- Heart icon (remove) --}}
                    <div class="absolute top-3 left-3 z-10">
                        <button wire:click="removeFromWishlist({{ $product->id }})"
                            class="btn btn-circle border-0 shadow-none bg-transparent hover:bg-white btn-sm text-red-500">
                            <x-heroicon-o-trash class="w-5 h-5" />
                        </button>
                    </div>

                    {{-- Product image & link --}}
                    <a wire:navigate href="{{ route('product.details', $product->slug) }}" class="text-black block">
                        <figure class="h-48">
                            <img src="{{ $product->first_image_path ? Storage::url($product->first_image_path) : asset('images/no-image.webp') }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover transition-transform group-hover:scale-105">
                        </figure>

                        <div class="card-body py-4 px-4">
                            <h3 class="text-lg font-semibold mb-2 line-clamp-2">{{ $product->name }}</h3>
                            <p class="text-purple-600 font-bold text-lg mb-2">${{ number_format($product->price, 2) }}
                            </p>
                            <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ Str::limit($product->description, 80)
                                }}</p>
                        </div>
                    </a>

                    {{-- Add to cart button --}}
                    <div class="card-actions px-4 pb-4">
                        <button wire:click="$dispatch('add-to-cart', { id: {{ $product->id }} })"
                            class="btn btn-sm bg-purple-600 hover:bg-purple-700 text-white border-0 w-full">
                            Move to Cart
                        </button>
                    </div>
                </div>

                @empty
                <div class="col-span-full flex flex-col items-center py-16">
                    <x-heroicon-o-heart class="w-20 h-20 text-purple-400 mb-4" />
                    <h3 class="text-xl text-gray-500">Your wishlist is empty</h3>
                    <a wire:navigate href="{{ route('products') }}"
                        class="btn bg-purple-600 hover:bg-purple-700 text-white border-0 mt-4">Start Shopping</a>
                </div>
                @endforelse
            </div>
            @if($rows->hasPages())
            <div class="mt-8 p-4">
                {{ $rows->links() }}
            </div>
            @endif
        </main>

    </div>
</div>
