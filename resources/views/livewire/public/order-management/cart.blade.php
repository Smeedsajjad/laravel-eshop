<div>
    <style>
        [type='checkbox']:checked:hover,
        [type='checkbox']:checked:focus,
        [type='radio']:checked:hover,
        [type='radio']:checked:focus {
            background-color: oklch(58% 0.233 277.117)
        }

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

    <livewire:public.cart-hero-section />

    <div class="flex flex-col md:flex-row gap-6 lg:gap-8 w-full my-8 px-4 sm:px-6 lg:px-8">

        <div class="w-full md:w-3/4">
            @if (Auth::check())

                <div class="overflow-x-auto rounded-xl shadow-xl border border-gray-200">
                    <table class="min-w-full bg-white divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                                </th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Product</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Price</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Qty</th>
                                <th
                                    class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Subtotal</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($items as $item)
                                @if ($item->product)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3">
                                            <input type="checkbox" wire:model.live="selected"
                                                value="{{ $item->product_id }}"
                                                class="checkbox checkbox-sm checkbox-primary">
                                        </td>

                                        <td class="px-4 py-3 flex items-center space-x-3">
                                            <img src="{{ $item->product->first_image_path ? Storage::url($item->product->first_image_path) : asset('images/no-image.webp') }}"
                                                alt="{{ $item->product->name }}" class="w-16 h-16 rounded object-cover">
                                            <span
                                                class="text-sm font-semibold text-black">{{ $item->product->name }}</span>
                                        </td>

                                        <td class="px-4 py-3 text-center text-sm text-gray-700">
                                            ${{ number_format($item->product->price, 2) }}
                                        </td>

                                        <td class="px-4 py-3 text-center">
                                            <div class="inline-flex items-center space-x-1">
                                                <button wire:click="decrement({{ $item->product_id }})"
                                                    class="btn btn-xs bg-softPurple border-0 text-gray-600">−</button>
                                                <span
                                                    class="w-8 text-center text-gray-600 font-medium">{{ $item->quantity }}</span>
                                                <button wire:click="increment({{ $item->product_id }})"
                                                    class="btn btn-xs bg-softPurple border-0 text-gray-600">+</button>
                                            </div>
                                        </td>

                                        <td class="px-4 py-3 text-right text-sm font-semibold text-black">
                                            ${{ number_format($item->quantity * $item->product->price, 2) }}
                                        </td>

                                        <td class="px-4 py-3 text-center">
                                            <button wire:click="remove({{ $item->product_id }})"
                                                class="btn btn-ghost btn-sm text-red-500">
                                                <x-heroicon-o-trash class="size-5" />
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-12">
                                        <div class="flex flex-col items-center">
                                            <x-heroicon-o-shopping-cart class="w-20 h-20 text-purple-400 mb-3" />
                                            <p class="text-xl text-gray-600">Your cart is empty</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-6 p-4">
                        {{ $rows->links() }}
                    </div>
                </div>
            @else
                <p class="text-lg text-gray-600 text-center">You Need to Login First.</p>
                <a wire:navigate href="{{ route('login') }}"
                    class="btn bg-purple-600 hover:bg-purple-700 text-white border-0 w-full">
                    Login to Add
                </a>
            @endif
        </div>

        <div class="w-full text-black md:w-2/5">
            <div class="bg-white rounded-xl shadow-xl p-6 space-y-4 border border-gray-100">
                <h3 class="text-xl font-bold text-gray-800 border-b pb-2">Cart Totals</h3>

                <div class="flex justify-between items-center">
                    <span class="text-gray-700">Subtotal</span>
                    <span class="font-semibold text-purple-600 text-lg">
                        ${{ number_format($checkedTotal, 2) }}
                    </span>
                </div>

                <button wire:click="pay" wire:loading.attr="disabled"
                    class="btn bg-gradient-to-r from-purple-600 to-purple-700 text-white font-semibold w-full py-3 rounded-lg hover:from-purple-700 hover:to-purple-800 border-0 {{ empty($selected) ? 'btn-disabled opacity-50 cursor-not-allowed' : '' }}"
                    @if (empty($selected)) disabled tabindex="-1" aria-disabled="true" @endif>
                    <span wire:loading wire:target="pay" class="flex items-center justify-center gap-2">
                        <span class="loading loading-spinner"></span>
                        Processing...
                    </span>
                    <span wire:loading.remove wire:target="pay">
                        Proceed to Checkout
                    </span>
                </button>


            </div>
        </div>

    </div>
</div>
