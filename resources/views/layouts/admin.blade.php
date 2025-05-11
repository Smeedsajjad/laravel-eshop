<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <title>{{ $title ?? 'Admin Panel | eShop' }}</title>
</head>

<body>
    <div class="drawer lg:drawer-open">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col items-center justify-center">
            <!-- Page content here -->
            <label for="my-drawer-2" class="btn btn-primary drawer-button lg:hidden">
                Open drawer
            </label>
        </div>
        <div class="drawer-side">
            <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
            <div class="flex items-center mb-6">
                <img src="{{ asset('images/Untitled-1_2-removebg-preview.webp') }}" alt="Brand Logo"
                    class="h-10 w-10 mr-2">
                <span class="text-lg font-bold truncate">eShop - Eommerence</span>
            </div>
            <!-- Menu items -->
            <ul class="menu bg-base-200 text-base-content min-h-full w-80 p-4">
                <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <x-heroicon-o-home class="h-5 w-5" /> Dashboard
                    </a>
                </li>
                <li>
                    <a href="#">
                        <x-heroicon-o-folder class="h-5 w-5" /> Categories
                    </a>
                </li>
                <li class="">
                    <a href="#">
                        <x-heroicon-o-shopping-bag class="h-5 w-5" /> Products
                    </a>
                </li>
                <li class="">
                    <a href="#">
                        <x-heroicon-o-briefcase class="h-5 w-5" /> Brands
                    </a>
                </li>
                <li class="">
                    <a href="#">
                        <x-heroicon-o-photo class="h-5 w-5" /> Sliders
                    </a>
                </li>
                <li class="">
                    <a href="#">
                        <x-heroicon-o-clipboard-document-list class="h-5 w-5" /> Orders
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div>
        {{ $slot }}
    </div>

    @livewireScripts
</body>

</html>
