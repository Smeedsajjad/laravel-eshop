<?php

namespace App\Livewire\Public;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Products extends Component
{
    #[Layout('layouts.app')]

    public function render()
    {
        return view('livewire.public.products');
    }
}
