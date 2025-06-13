<div>
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <style>
        h3.text-lg.font-medium.text-gray-900 {
            color: #F1F5F9;
            /* text-base-content */
        }

        p.mt-1.text-sm.text-gray-600,
        .mt-3.max-w-xl.text-sm.text-gray-600>p {
            color: #A0AEC0;
            /* text-secondary */
        }

        label.block.font-medium.text-sm.text-gray-700 {
            color: #F1F5F9;
            /* text-base-content */
        }

        /* Background color updates */
        .px-4.py-5.bg-white.sm\:p-6.shadow.sm\:rounded-tl-md.sm\:rounded-tr-md,
        .px-4.py-5.sm\:p-6.bg-white.shadow.sm\:rounded-lg,
        .flex.items-center.justify-end.px-4.py-3.bg-gray-50.text-end.sm\:px-6.shadow.sm\:rounded-bl-md.sm\:rounded-br-md {
            background-color: #1d232a;
            /* bg-base-200 */
        }

        .col-span-6.sm\:col-span-4>input {
            color: #b8c1ce;
            background-color: #191e24;
        }
    </style>
    <div class="p-6">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Profile') }}
            </h2>
        </x-slot>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                    @livewire('profile.update-profile-information-form')

                    <x-section-border />
                @endif

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                    <div class="mt-10 sm:mt-0">
                        @livewire('profile.update-password-form')
                    </div>

                    <x-section-border />
                @endif

                @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                    <div class="mt-10 sm:mt-0">
                        @livewire('profile.two-factor-authentication-form')
                    </div>

                    <x-section-border />
                @endif

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.logout-other-browser-sessions-form')
                </div>

            </div>
        </div>
    </div>

</div>
