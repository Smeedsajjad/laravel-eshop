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
         <ul tabindex="0" class="menu menu-sm dropdown-content bg-white mt-3 z-[1] p-2 shadow-lg rounded-box w-52">
             @auth
                 {{-- Logged-in section --}}
                 <li class="menu-title text-xs text-gray-500">{{ __('Manage Account') }}</li>

                 @if (auth()->user()->isAdmin())
                     <li><a class="text-gray-600 focus:bg-white" wire:navigate
                             href="{{ route('admin.profile') }}">{{ __('Profile') }}</a></li>
                 @else
                     <li><a class="text-gray-600 focus:bg-white" wire:navigate
                             href="{{ route('profile.show') }}">{{ __('Profile') }}</a></li>
                     <li><a class="text-gray-600 focus:bg-white" wire:navigate
                             href="{{ route('address') }}">{{ __('Address') }}</a></li>
                     <li><a class="text-gray-600 focus:bg-white" wire:navigate
                             href="{{ route('orders') }}">{{ __('Orders') }}</a></li>
                     <li><a class="text-gray-600 flex max-md:flex focus:bg-white" wire:navigate
                             href="{{ route('wishlist') }}">
                             {{ __('Wishlist') }}</a></li>
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
                         class="btn btn-sm bg-white border border-purple-600 text-purple-600 mt-2">{{ __('Register') }}</a>
                 </li>
             @endauth
         </ul>
     </div>
 </li>
