<?php

namespace App\Livewire\Public;

use Livewire\Attributes\Layout;
use Livewire\Component;

class About extends Component
{
    #[Layout('layouts.app')]
    
    public function render()
    {
        return view('livewire.public.about');
    }
}
