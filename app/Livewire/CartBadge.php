<?php

namespace App\Livewire;

use Livewire\Component;

class CartBadge extends Component
{
  protected $listeners = ['cartUpdated' => '$refresh'];

    public function render()
    {
        return <<<'blade'
            <span class="indicator-item badge bg-purple-600 border-0">
                {{ app(\App\Services\DatabaseCart::class)->count() }}
            </span>
        blade;
    }
}
