<div class="hidden lg:flex navbar bg-softPurple shadow-sm py-5">
    <div class="max-w-7xl mx-auto w-full flex flex-col lg:flex-row items-center justify-between gap-4">

        <!-- Left Side - Navigation Links -->
        <div class="flex-1 w-full lg:w-auto">
            <ul class="flex flex-wrap justify-center lg:justify-start gap-3 text-purple-700">
                <li>
                    <a href="{{ route('home') }}" wire:navigate 
                        class="py-3 px-4 rounded-full font-semibold block transition-all duration-500 ease-in-out {{ request()->routeIs('home') ? 'bg-white' : 'hover:bg-white' }}">
                        Home
                    </a>
                </li>
                <li>
                    <a href="{{ route('category') }}" wire:navigate 
                        class="py-3 px-4 rounded-full font-semibold block transition-all duration-500 ease-in-out {{ request()->routeIs('category.index') ? 'bg-white' : 'hover:bg-white' }}">
                        Category
                    </a>
                </li>
                <li>
                    <a href="{{ route('products') }}" wire:navigate 
                        class="py-3 px-4 rounded-full font-semibold block transition-all duration-500 ease-in-out {{ request()->routeIs('products.index') ? 'bg-white' : 'hover:bg-white' }}">
                        Products
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact') }}" wire:navigate 
                        class="py-3 px-4 rounded-full font-semibold block transition-all duration-500 ease-in-out {{ request()->routeIs('contact') ? 'bg-white' : 'hover:bg-white' }}">
                        Contact Us
                    </a>
                </li>
                <li>
                    <a href="{{ route('about') }}" wire:navigate 
                        class="py-3 px-4 rounded-full font-semibold block transition-all duration-500 ease-in-out {{ request()->routeIs('about') ? 'bg-white' : 'hover:bg-white' }}">
                        About Us
                    </a>
                </li>
            </ul>

        </div>

        <!-- Right Side - Icons -->
        <div class="flex-none w-full lg:w-auto">
            <ul class="flex justify-center lg:justify-end gap-3">
                <li class="bg-white p-3.5 rounded-full">
                    <a href="#">
                        <x-heroicon-o-shopping-bag class="size-5 text-purple-600" />
                    </a>
                </li>
                <li class="bg-white p-3.5 rounded-full">
                    <a href="#">
                        <x-heroicon-o-heart class="size-5 text-purple-600" />
                    </a>
                </li>
                <li class="bg-white p-3.5 rounded-full">
                    <a href="#">
                        <x-heroicon-o-user class="size-5 text-purple-600" />
                    </a>
                </li>
            </ul>
        </div>

    </div>
</div>
