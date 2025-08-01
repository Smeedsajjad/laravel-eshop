<x-app-layout>
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-50 via-white to-purple-100 p-4">
    <div class="card w-full max-w-md bg-white shadow-xl rounded-2xl text-center">
        <figure class="px-10 pt-10">
            <div class="bg-green-100 rounded-full p-4 inline-block">
                <x-heroicon-o-check-circle class="w-16 h-16 text-green-500" />
            </div>
        </figure>
        <div class="card-body">
            <h2 class="card-title text-2xl font-bold text-gray-800 justify-center">Payment Successful</h2>
            <p class="text-gray-600 mt-2">Your order has been placed and your cart is now empty.</p>
            <p class="text-sm text-gray-500 mt-1">Thank you for shopping with us!</p>

            <div class="card-actions justify-center mt-6">
                <a href="{{ route('products') }}" wire:navigate
                   class="btn bg-purple-600 hover:bg-purple-700 border-0 text-white">
                    Continue Shopping
                </a>
                <a href="{{ route('home') }}" wire:navigate
                   class="btn btn-outline btn-primary">
                    View My Orders
                </a>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
