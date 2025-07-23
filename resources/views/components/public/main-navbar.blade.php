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
                        class="py-3 px-4 rounded-full font-semibold block transition-all duration-500 ease-in-out {{ request()->routeIs('category') ? 'bg-white' : 'hover:bg-white' }}">
                        Category
                    </a>
                </li>
                <li>
                    <a href="{{ route('products') }}" wire:navigate
                        class="py-3 px-4 rounded-full font-semibold block transition-all duration-500 ease-in-out {{ request()->routeIs('products') ? 'bg-white' : 'hover:bg-white' }}">
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
                {{-- 1-line replacement for the old <li> --}}
                <li class="content-center">
                    <div class="dropdown dropdown-end">
                        {{-- Trigger --}}
                        <label tabindex="0" class="btn btn-circle btn-lg border-0 shadow-none avatar text-black bg-white">
                            @auth
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <div class="w-8 rounded-full">
                                        <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </div>
                                @else
                                    <span class="text-sm font-bold">{{ Str::limit(Auth::user()->name, 1) }}</span>
                                @endif
                            @else
                                {{-- Guest: show user icon --}}
                                <x-heroicon-o-user class="size-5 text-purple-600" />
                            @endauth
                        </label>

                        {{-- Dropdown menu --}}
                        <ul tabindex="0"
                            class="menu menu-sm dropdown-content bg-white mt-3 z-[1] p-2 shadow-lg rounded-box w-52">
                            @auth
                                {{-- Logged-in section --}}
                                <li class="menu-title text-xs text-gray-500">{{ __('Manage Account') }}</li>

                                @if (auth()->user()->isAdmin())
                                    <li><a class="text-gray-600 focus:bg-white" href="{{ route('admin.profile') }}">{{ __('Profile') }}</a></li>
                                @else
                                    <li><a class="text-gray-600 focus:bg-white" href="{{ route('profile.show') }}">{{ __('Profile') }}</a></li>
                                @endif

                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <li><a href="{{ route('api-tokens.index') }}">{{ __('API Tokens') }}</a></li>
                                @endif

                                <hr class="my-1">

                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left text-red-600">
                                            {{ __('Log Out') }}
                                        </button>
                                    </form>
                                </li>
                            @else
                                {{-- Guest section --}}
                                <li><a href="{{ route('login') }}" class="btn btn-sm bg-purple-600 border-0">{{ __('Login') }}</a>
                                </li>
                                <li><a href="{{ route('register') }}"
                                        class="btn btn-sm bg-white border border-purple-600 text-purple-600 mt-2">{{ __('Register') }}</a></li>
                            @endauth
                        </ul>
                    </div>
                </li>
            </ul>
        </div>

    </div>
</div>
