<div>
    <div class="max-w-2xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Secure Checkout</h1>

    <div class="bg-white rounded-xl shadow p-6 space-y-4">
        <p class="text-lg">
            Order total: <span class="font-bold text-purple-600">${{ number_format($cartTotal, 2) }}</span>
        </p>

        <button wire:click="pay"
                class="btn btn-primary w-full">
            Pay with Stripe
        </button>
    </div>
</div>
</div>
