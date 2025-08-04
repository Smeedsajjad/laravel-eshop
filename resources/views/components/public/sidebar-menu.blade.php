<ul class="menu bg-white min-h-full w-80 p-4">
    <!-- Sidebar content here -->
    <li class="-m-4 py-4 border border-gray-600">
        <a href="{{ route('register') }}" wire:navigate style="background: none">
            <x-heroicon-o-user class="size-7 text-gray-600" />
            <h1 class="text-xl text-purple-600">Login/Rigister</h1>
        </a>
    </li>
    <li class="mt-7">
        <a href="{{ route('home') }}" wire:navigate class="!text-gray-800 p-3 !bg-transparent">
            <x-heroicon-o-home class="size-6 text-gray-800" />Home</a>
    </li>
    <li>
        <a href="{{ route('category') }}" wire:navigate class="!text-gray-800 p-3 !bg-transparent">
            <x-heroicon-o-cube class="size-6 text-gray-800" />Category</a>
    </li>
    <li>
        <a href="{{ route('products') }}" wire:navigate class="!text-gray-800 p-3 !bg-transparent">
            <x-heroicon-o-building-storefront class="size-6 text-gray-800" />Products</a>
    </li>
    <li>
        <a href="{{ route('address') }}" wire:navigate class="!text-gray-800 p-3 !bg-transparent">
            <x-heroicon-o-map-pin class="size-6 text-gray-800" />Address</a>
    </li>
    <li>
        <a href="{{ route('about') }}" wire:navigate class="!text-gray-800 p-3 !bg-transparent">
            <x-heroicon-o-information-circle class="size-6 text-gray-800" />About Us</a>
    </li>
    <li>
        <a href="{{ route('contact') }}" wire:navigate class="!text-gray-800 p-3 !bg-transparent">
            <x-heroicon-o-question-mark-circle class="size-6 text-gray-800" />FQAs</a>
    </li>
    <hr class="border-gray-700">
    <li>
        <a wire:prevent class="disable btn !text-gray-800 p-3 !bg-transparent">
            <x-heroicon-o-language class="size-4 text-gray-600" />En</a>
    </li>
</ul>
