<header class="navbar bg-base-100 px-4 py-2 shadow-md z-10 flex flex-wrap items-center justify-between">
    <div class="flex items-center gap-2">
        <label for="admin-drawer" class="btn btn-primary btn-sm drawer-button lg:hidden">
            <x-heroicon-s-bars-3 class="h-5 w-5" />
        </label>
        <div class="hidden sm:flex items-center gap-2">
            <span class="badge badge-primary text-xs">V 0.0</span>
            <span class="badge badge-error font-semibold text-white text-xs">Development Mode</span>
        </div>
    </div>

    <div class="flex items-center gap-2 sm:gap-4">

        <details class="dropdown dropdown-end relative">
            <summary class="btn btn-ghost btn-circle btn-sm sm:btn-md">
                <div class="indicator">
                    <x-heroicon-s-bell class="h-4 w-4 sm:h-5 sm:w-5" />
                    <span class="badge badge-xs sm:badge-sm badge-error indicator-item">3</span>
                </div>
            </summary>
            <ul class="menu dropdown-content bg-base-100 rounded-box z-20 p-2 shadow-md w-56 right-0">
                <li><a>Not any notification</a></li>
            </ul>
        </details>

        <select class="select select-bordered select-sm sm:select-md bg-base-200">
            <option>EN</option>
            <option>UR</option>
            <option>FR</option>
        </select>

        <div class="dropdown dropdown-end relative">
            <label tabindex="0" class="btn avatar btn-sm sm:btn-md">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="w-6 sm:w-8 rounded-full overflow-hidden">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @else
                    <span class="inline-flex items-center">
                        <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                        <svg class="ms-1 sm:ms-2 size-3 sm:size-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </span>
                @endif
            </label>
            <ul tabindex="0" class="menu dropdown-content bg-base-100 rounded-box shadow-md w-56 z-30 right-0">
                <li class="px-4 py-2 text-xs text-gray-400">{{ __('Manage Account') }}</li>

                @auth
                    @if (auth()->user()->isAdmin())
                        <li><a href="{{ route('admin.profile') }}">{{ __('Profile') }}</a></li>
                    @else
                        <li><a href="{{ route('profile.show') }}">{{ __('Profile') }}</a></li>
                    @endif
                @endauth

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <li><a href="{{ route('api-tokens.index') }}">{{ __('API Tokens') }}</a></li>
                @endif

                <li>
                    <div class="border-t border-gray-200 my-2"></div>
                </li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left">{{ __('Log Out') }}</button>
                    </form>

                </li>
            </ul>
        </div>
    </div>
</header>
