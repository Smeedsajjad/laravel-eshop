    <!-- Navbar -->
    <div class="navbar bg-white w-full">
        <div class="max-w-7xl mx-auto w-full px-8">
            <!-- Mobile Layout (< lg) -->
            <div class="flex lg:hidden flex-row w-full items-center justify-between">
                <div class="flex-none">
                    <label for="my-drawer-3" aria-label="open sidebar"
                        class="btn btn-square border-none !shadow-none !bg-transparent">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="inline-block h-6 w-6" stroke="#495057" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </label>
                </div>

                <div class="flex-1 flex justify-center">
                    <a href="{{ route('contact') }}" wire:navigate class="w-[85px] h-[75px]">
                        <img src="{{ asset('images/Untitled_1.png') }}" alt="Brand Logo"
                            class="rounded-full w-full h-fit">
                    </a>
                </div>

                <div class="flex flex-row gap-3">
                    <x-heroicon-o-shopping-cart class="size-5 text-gray-600" />
                    <x-heroicon-o-user class="size-5 text-gray-600" />
                </div>
            </div>

            <!-- Desktop Layout (>= lg) -->
            <div class="hidden lg:flex flex-row w-full items-center justify-between">
                <!-- Logo -->
                <a href="{{ route('contact') }}" wire:navigate class="w-[85px] h-[75px]">
                    <img src="{{ asset('images/Untitled_1.png') }}" alt="Brand Logo" class="rounded-full w-full h-fit">
                </a>

                <!-- Search Input -->
                <div class="flex-1 w-full px-24">
                    <livewire:public.search-bar />
                </div>

                <!-- Navigation Links -->
                <div class="flex-none">
                    <div class="flex text-gray-950 flex-row gap-6 items-center">
                        <a href="{{ route('contact') }}" class="font-semibold hover:text-purple-600 transition-colors" wire:navigate>
                            Support
                        </a>
                        <a href="{{ route('contact') }}" class="font-semibold hover:text-purple-600 transition-colors" wire:navigate>
                            About Us
                        </a>
                        <a href="{{ route('contact') }}" class="font-semibold hover:text-purple-600 transition-colors" wire:navigate>
                            FAQs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Mobile Search Bar -->
<div class="lg:hidden bg-softPurple sticky top-0" >
    <div class="max-w-7xl mx-auto w-full px-4 py-3">
        <livewire:public.search-bar />
    </div>
</div>
