   <header class="navbar bg-base-100 px-4 py-2 shadow-md z-10 flex-wrap sm:flex-nowrap">
                <div class="flex-1 flex items-center justify-between w-full">
                    <div class="flex items-center space-x-2">
                        <label for="admin-drawer" class="btn btn-primary btn-sm drawer-button lg:hidden mr-2">
                            <x-heroicon-s-bars-3 class="h-5 w-5" />
                        </label>
                        <div class="inline-flex items-center space-x-2 flex-wrap">
                            <span class="badge badge-primary text-xs sm:flex hidden">V 0.0</span>
                            <span class="badge badge-error font-semibold text-white sm:flex hidden text-xs">Development Mode</span>
                        </div>
                    </div>

                    <div class="flex-none flex items-center space-x-2 sm:space-x-4  mr-6">
                        {{-- Language Selector --}}
                        <select class="select select-bordered select-sm sm:select-md mr-2 bg-base-200 w-20 sm:w-auto">
                            <option>EN</option>
                            <option>UR</option>
                            <option>FR</option>
                        </select>

                        <details class="dropdown dropdown-end" style="margin: inherit">
                            <summary class="btn btn-ghost btn-circle btn-sm sm:btn-md">
                                <div tabindex="0" rol   e="button" class="indicator">
                                    <x-heroicon-s-bell class="h-4 w-4 sm:h-5 sm:w-5" />
                                    <span class="badge badge-xs sm:badge-sm badge-error btn-circle indicator-item">3</span>
                                </div>
                            </summary>
                            <ul class="menu dropdown-content bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm">
                                <li><a>Not any notification</a></li>
                            </ul>
                        </details>

                        {{-- Profile Dropdown --}}
                        <div class="dropdown dropdown-end relative">
                            <label tabindex="0" class="btn btn-ghost btn-circle avatar btn-sm sm:btn-md">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <div class="w-6 sm:w-8 rounded-full">
                                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"
                                        class="object-cover" />
                                </div>
                                @else
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="btn ">
                                        {{ Auth::user()->name }}
                                        <svg class="ms-1 sm:ms-2 -me-0.5 size-3 sm:size-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                                @endif
                            </label>
                            <ul tabindex="0"
                                class="mt-3 p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                                <li class="px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                </li>
                                <li>
                                    <a href="{{ route('profile.show') }}">{{ __('Profile') }}</a>
                                </li>
                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <li>
                                    <a href="{{ route('api-tokens.index') }}">{{ __('API Tokens') }}</a>
                                </li>
                                @endif
                                <li>
                                    <div class="border-t border-gray-200 my-2"></div>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit">{{ __('Log Out') }}</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>
