<?php

namespace App\Livewire;

use Livewire\Component;

class WishlistBadge extends Component
{
  protected $listeners = ['wishlist-updated' => '$refresh'];

    public function render()
    {
        return <<<'blade'
            <span class="indicator-item badge bg-purple-600 border-0">
                {{ app(\App\Services\DatabaseWishlist::class)->count() }}
            </span>
        blade;
    }
}
