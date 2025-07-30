<?php

namespace App\Livewire\Public;

use Illuminate\Support\Facades\Route;
use Livewire\Component;

class CartHeroSection extends Component
{
    public int $step = 1;

    public function mount()
    {
        $this->step = match (Route::currentRouteName()) {
            'checkout'  => 2,
            'order.complete'  => 3,
            default           => 1,
        };
    }

    public function render()
    {
        return view('livewire.public.cart-hero-section');
    }
}
