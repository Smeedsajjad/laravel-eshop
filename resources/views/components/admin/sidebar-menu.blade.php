<ul class="menu bg-base-200 text-base-content min-h-full w-70 p-4">
    {{-- Brand Logo --}}
    <div class="flex items-center mb-6 px-2">
        <img src="{{ asset('images/Untitled-1_2-removebg-preview.webp') }}" alt="Brand Logo"
            class="h-10 w-10 mr-2 rounded-full">
        <span class="text-lg font-bold truncate">eShop – E-commerce</span>
    </div>

    {{-- Dashboard Link --}}
    <li class="
               p-2 rounded-md
               hover:bg-base-300 hover:text-primary
               {{ request()->routeIs('admin.dashboard')
                   ? 'menu-active bg-primary text-white'
                   : '' }}
               ">
        <a class="flex items-center gap-2 hover:bg-base-300" wire:navigate href="{{ route('admin.dashboard') }}">
            <x-heroicon-s-home class="h-5 w-5" />
            Dashboard
        </a>
    </li>

    {{-- Categories Link --}}
    <li  class="
               p-2 rounded-md my-2
               hover:bg-base-300 hover:text-primary
               {{ request()->routeIs('admin.category')
                   ? 'menu-active bg-primary text-white'
                   : '' }}
               ">
        <a class="flex items-center gap-2 hover:bg-base-300" wire:navigate href="{{ route('admin.category') }}">
            <x-heroicon-s-folder class="h-5 w-5" />
            Categories
        </a>
    </li>

    {{-- Products Link --}}
    <li>
        <a class="flex items-center gap-2" href="#">
            <x-heroicon-s-shopping-bag class="h-5 w-5" />
            Products
        </a>
    </li>

    {{-- Brands Link --}}
    <li>
        <a class="flex items-center gap-2" href="#">
            <x-heroicon-s-briefcase class="h-5 w-5" />
            Brands
        </a>
    </li>

    {{-- Sliders Link --}}
    <li>
        <a class="flex items-center gap-2" href="#">
            <x-heroicon-s-photo class="h-5 w-5" />
            Sliders
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
