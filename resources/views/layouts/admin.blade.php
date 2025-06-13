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

<body class="min-h-screen bg-base-200 antialiased">
    <div class="drawer lg:drawer-open">
        <input id="admin-drawer" type="checkbox" class="drawer-toggle" />

        {{-- SIDEBAR --}}
        <div class="drawer-side z-50">
            <label for="admin-drawer" class="drawer-overlay"></label>
            @include('components.admin.sidebar-menu')
        </div>

        {{-- CONTENT AREA --}}
        <div class="drawer-content flex flex-col min-h-screen">
            {{-- HEADER --}}
            <x-admin.header />

            {{-- MAIN CONTENT --}}
            <main class="flex-1 w-full mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
                <div class="max-w-full mx-auto">
                    {{ $slot }}
                </div>
            </main>

            {{-- FOOTER (Optional)
            @isset($footer)
            <footer class="bg-base-100 p-4 shadow-md">
                {{ $footer }}
            </footer>
            @endisset --}}
        </div>
    </div>
    @stack('modals')
    @livewireScripts()
</body>

</html>
