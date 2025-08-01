<x-app-layout>
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-red-50 via-white to-red-100 p-4">
    <div class="card w-full max-w-md bg-white shadow-xl rounded-2xl text-center">
        <figure class="px-10 pt-10">
            <div class="bg-red-100 rounded-full p-4 inline-block">
                <x-heroicon-o-x-circle class="w-16 h-16 text-red-500" />
            </div>
        </figure>
        <div class="card-body">
            <h2 class="card-title text-2xl font-bold text-gray-800 justify-center">Payment Cancelled</h2>
            <p class="text-gray-600 mt-2">No worries—your cart is still intact.</p>
            <p class="text-sm text-gray-500 mt-1">You can complete the purchase whenever you’re ready.</p>

            <div class="card-actions justify-center mt-6">
                <a href="{{ route('checkout') }}" wire:navigate
                   class="btn bg-purple-600 hover:bg-purple-700 border-0 text-white">
                    Try Again
                </a>
                <a href="{{ route('products') }}" wire:navigate
                   class="btn btn-outline btn-primary">
                    Browse Products
                </a>
            </div>
        </div>
    </div>
</div>
</x-app-layout>

