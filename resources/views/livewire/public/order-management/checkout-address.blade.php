<div class="bg-white rounded-xl shadow p-6 space-y-6">
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
    <h2 class="text-2xl font-bold text-gray-800">Shipping Address</h2>

    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="alert alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-error">
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Guest User Message --}}
    @if ($isGuest)
        <div class="flex flex-col items-center justify-center text-center py-12 space-y-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-600">Login Required</h3>
            <p class="text-gray-500">Please login first to manage your shipping addresses.</p>
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        </div>
    @else
        {{-- Saved addresses --}}
        @if ($showTable)
            {{-- Add new button --}}
            <button wire:click="add"
                class="btn border border-purple-600 text-purple-600 bg-white hover:text-white hover:bg-purple-600 btn-md">
                ➕ Add new address
            </button>

            <div class="space-y-3">
                @forelse($addresses as $address)
                    <div
                        class="border rounded-lg p-4 relative {{ $selectedId == $address->id ? 'border-purple-500 bg-purple-50' : 'border-gray-200' }}">
                        <label class="flex items-start space-x-3 cursor-pointer"
                            wire:click="select({{ $address->id }})">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <p class="font-semibold text-black">{{ $address->fullName() }}</p>
                                </div>
                                <p class="text-sm text-gray-600">{{ $address->fullAddress() }}</p>
                                @if ($address->phone)
                                    <p class="text-xs text-gray-500">{{ $address->phone }}</p>
                                @endif
                                <div class="w-full flex justify-end">
                                    @if ($address->is_default)
                                        <span class="badge bg-purple-600 border-purple-600 badge-sm">Default</span>
                                    @endif
                                </div>
                            </div>
                        </label>

                        {{-- Action buttons --}}
                        <div class="absolute top-4 right-4 flex space-x-2">
                            @if (!$address->is_default)
                                <button type="button" wire:click="setDefault({{ $address->id }})"
                                    wire:confirm="Set this as your default address?"
                                    class="btn btn-ghost btn-xs text-blue-600 hover:text-blue-800"
                                    title="Set as default">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                </button>
                            @endif

                            <button type="button" wire:click="edit({{ $address }})"
                                class="btn btn-ghost btn-xs text-purple-600 hover:text-purple-800" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>

                            <button type="button" wire:click="delete({{ $address->id }})"
                                wire:confirm="Are you sure you want to delete this address?"
                                class="btn btn-ghost btn-xs text-red-600 hover:text-red-800" title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center text-center col-span-full py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-500 mb-2">No saved addresses yet.</h3>
                        <p class="text-gray-400 mb-4">Add your first shipping address to get started.</p>
                        <button wire:click="add"
                            class="btn text-purple-600 bg-white hover:bg-purple-700 border-purple-600 hover:text-white font-semibold btn-md">Add
                            Address</button>
                    </div>
                @endforelse
            </div>
        @endif

        {{-- Address form (toggle) --}}
        @if ($showForm)
            <form wire:submit.prevent="save" class="space-y-4 border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-800">
                    {{ $editing ? 'Edit Address' : 'Add New Address' }}
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- First Name --}}
                    <div>
                        <input type="text" placeholder="First name" wire:model="first_name"
                            class="input input-bordered w-full bg-white border border-gray-400 text-black focus:border-purple-600 @error('first_name') border-red-500 @enderror">
                        @error('first_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Last Name --}}
                    <div>
                        <input type="text" placeholder="Last name" wire:model="last_name"
                            class="input input-bordered w-full bg-white border border-gray-400 text-black focus:border-purple-600 @error('last_name') border-red-500 @enderror">
                        @error('last_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Address Line 1 --}}
                    <div class="md:col-span-2">
                        <input type="text" placeholder="Address line 1" wire:model="address_line_1"
                            class="input input-bordered w-full bg-white border border-gray-400 text-black focus:border-purple-600 @error('address_line_1') border-red-500 @enderror">
                        @error('address_line_1')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Address Line 2 --}}
                    <div class="md:col-span-2">
                        <input type="text" placeholder="Address line 2 (optional)" wire:model="address_line_2"
                            class="input input-bordered w-full bg-white border border-gray-400 text-black focus:border-purple-600">
                    </div>

                    {{-- City --}}
                    <div>
                        <input type="text" placeholder="City" wire:model="city"
                            class="input input-bordered w-full bg-white border border-gray-400 text-black focus:border-purple-600 @error('city') border-red-500 @enderror">
                        @error('city')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- State --}}
                    <div>
                        <input type="text" placeholder="State (optional)" wire:model="state"
                            class="input input-bordered w-full bg-white border border-gray-400 text-black focus:border-purple-600">
                    </div>

                    {{-- Postal Code --}}
                    <div>
                        <input type="text" placeholder="Postal code" wire:model="postal_code"
                            class="input input-bordered w-full bg-white border border-gray-400 text-black focus:border-purple-600 @error('postal_code') border-red-500 @enderror">
                        @error('postal_code')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Country --}}
                    <div>
                        <select wire:model="country"
                            class="select select-bordered w-full bg-white border border-gray-400 text-black focus:border-purple-600 @error('country') border-red-500 @enderror">
                            <option value="US">United States</option>
                            <option value="CA">Canada</option>
                            <option value="GB">United Kingdom</option>
                            <option value="AU">Australia</option>
                        </select>
                        @error('country')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="md:col-span-2">
                        <input type="text" placeholder="Phone (optional)" wire:model="phone"
                            class="input input-bordered w-full bg-white border border-gray-400 text-black focus:border-purple-600">
                    </div>
                </div>

                {{-- Default Address Checkbox --}}
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" wire:model="is_default" class="checkbox checkbox-primary">
                    <span class="text-gray-700">Set as default address</span>
                </label>

                {{-- Form Actions --}}
                <div class="flex space-x-2">
                    <button type="submit"
                        class="btn text-white bg-purple-600 hover:bg-purple-700 font-semibold btn-md border-0"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove>{{ $editing ? 'Update Address' : 'Save Address' }}</span>
                        <span wire:loading>
                            <span class="loading loading-spinner loading-sm"></span>
                            Saving...
                        </span>
                    </button>
                    <button type="button" wire:click="cancel"
                        class="btn text-purple-600 bg-white hover:bg-purple-700 font-semibold btn-md border-purple-600 hover:text-white">Cancel</button>
                </div>
            </form>
        @endif
    @endif
</div>
