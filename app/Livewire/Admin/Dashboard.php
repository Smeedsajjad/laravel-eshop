<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Dashboard extends Component
{
    #[Layout('layouts.admin')]

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
