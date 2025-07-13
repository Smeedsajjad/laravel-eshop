<?php

namespace App\Livewire\Public;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Category extends Component
{
    #[Layout('layouts.app')]

    public function render()
    {
        return view('livewire.public.category');
    }
}
