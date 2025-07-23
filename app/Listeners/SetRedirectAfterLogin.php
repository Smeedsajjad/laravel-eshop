<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetRedirectAfterLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Authenticated $event): void
    {
         if ($event->user->is_admin) {
            session(['url.intended' => route('admin.dashboard')]);
        } else {
            session(['url.intended' => route('home')]);
        }
    }
}
