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
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        .swiper-pagination-bullet {
            background-color: #6B21A8;
            opacity: 0.7;
        }

        .swiper-pagination-bullet-active {
            background-color: #6B21A8;
            opacity: 1;
        }

        .text {
            color: black !important;
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="min-h-screen antialiased bg-white">
    {{-- NAVIGATION MENU --}}
    <div class="drawer">
        {{-- TOGGLE --}}
        <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col">
            {{-- Navbar --}}
            @include('components.public.top-navbar')
            @include('components.public.main-navbar')
            <!--  Mini-Cart drawer -->
            <div class="drawer drawer-end">
                <input id="mini-cart-toggle" type="checkbox" class="drawer-toggle" wire:model="drawerOpen" />
                <div class="drawer-content">
                    <!-- rest of your page / navbar -->
                </div>

                <div class="drawer-side z-20">
                    <label for="mini-cart-toggle" aria-label="close sidebar" class="drawer-overlay"></label>
                    <ul class="menu bg-white text-base-content min-h-full w-80 p-4">
                        <livewire:public.order-management.mini-cart />
                    </ul>
                </div>
            </div>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-5">
                {{ $slot }}
            </main>
            @include('components.public.footer')
        </div>

        <div class="drawer-side">
            <label for="my-drawer-3" aria-label="close sidebar" class="drawer-overlay"></label>
            @include('components.public.sidebar-menu')
        </div>
    </div>

    @stack('modals')
    @livewireScripts
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true,
            },
            simulateTouch: true,
            grabCursor: true,
        });
    </script>
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('toast', (e) => {
                const {
                    type,
                    message
                } = e;
                // DaisyUI toast
                const toast = document.createElement('div');
                toast.className = `alert alert-${type} fixed top-4 right-4 z-50`;
                toast.innerHTML = `<span>${message}</span>`;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);
            });
        });
    </script>
</body>

</html>
