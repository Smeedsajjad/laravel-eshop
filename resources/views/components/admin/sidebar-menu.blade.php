<ul class="menu bg-base-200 text-base-content min-h-full w-70 p-4">
    {{-- Brand Logo --}}
    <div class="flex items-center mb-6 px-2">
        <img src="{{ asset('images/Untitled-1_2-removebg-preview.webp') }}" alt="Brand Logo"
            class="h-10 w-10 mr-2 rounded-full">
        <span class="text-lg font-bold truncate">eShop – E-commerce</span>
    </div>

    {{-- Dashboard Link --}}
    <li
        class="
               p-2 rounded-md
               hover:bg-base-300 hover:text-primary
               {{ request()->routeIs('admin.dashboard') ? 'menu-active bg-primary text-white' : '' }}
               ">
        <a class="flex items-center gap-2 hover:bg-base-300" wire:navigate href="{{ route('admin.dashboard') }}">
            <x-heroicon-s-home class="h-5 w-5" />
            Dashboard
        </a>
    </li>

    {{-- Categories Link --}}
    <li
        class="
               p-2 rounded-md my-2
               hover:bg-base-300 hover:text-primary
               {{ request()->routeIs('admin.category') ? 'menu-active bg-primary text-white' : '' }}
               ">
        <a class="flex items-center gap-2 hover:bg-base-300" wire:navigate href="{{ route('admin.category') }}">
            <x-heroicon-s-folder class="h-5 w-5" />
            Categories
        </a>
    </li>

    <li class="my-2">
        <details {{ request()->routeIs('admin.products.*') ? 'open' : '' }}>
            <summary
                class=" p-[13px] pl-[21px]
            flex items-center gap-2 rounded-md cursor-pointer
            hover:bg-base-300 hover:text-primary
            {{ request()->routeIs('admin.products.*') ? 'bg-primary text-white' : '' }}
        ">
                <x-heroicon-s-shopping-bag class="h-5 w-5" />
                <span>Products</span>
            </summary>

            <ul class="ml-4">
                {{-- All Products Link --}}
                <li
                    class="
                rounded-md my-2
                hover:bg-base-300 hover:text-primary
                {{ request()->routeIs('admin.products.index') ? 'menu-active bg-primary text-white' : '' }}
            ">
                    <a class="flex items-center gap-2" wire:navigate href="{{ route('admin.products.index') }}">
                        <x-heroicon-s-list-bullet class="h-4 w-4" />
                        All Products
                    </a>
                </li>

                {{-- Create Product Link --}}
                <li
                    class="
                rounded-md my-2
                hover:bg-base-300 hover:text-primary
                {{ request()->routeIs('admin.products.create') ? 'menu-active bg-primary text-white' : '' }}
            ">
                    <a class="flex items-center gap-2" wire:navigate href="{{ route('admin.products.create') }}">
                        <x-heroicon-s-plus class="h-4 w-4" />
                        Create Product
                    </a>
                </li>
            </ul>
        </details>
    </li>

    {{-- Reviews Link --}}
    <li
        class="
               p-2 rounded-md my-2
               hover:bg-base-300 hover:text-primary
               {{ request()->routeIs('admin.reviews') ? 'menu-active bg-primary text-white' : '' }}
               ">
        <a class="flex items-center gap-2 hover:bg-base-300" wire:navigate href="{{ route('admin.reviews') }}">
            <x-heroicon-s-star class="h-5 w-5" />
            Reviews
        </a>
    </li>
    {{-- Attributes Link --}}
    <li
        class="
               p-2 rounded-md my-2
               hover:bg-base-300 hover:text-primary
               {{ request()->routeIs('admin.reviews') ? 'menu-active bg-primary text-white' : '' }}
               ">
        <a class="flex items-center gap-2 hover:bg-base-300" wire:navigate href="{{ route('admin.attributes') }}">
            <x-heroicon-s-inbox-stack class="h-5 w-5" />
            Attributes
        </a>
    </li>
    {{-- Orders Link --}}
    <li>
        <a class="flex items-center gap-2" href="#">
            <x-heroicon-s-clipboard-document-list class="h-5 w-5" />
            Orders
        </a>
    </li>

</ul>
