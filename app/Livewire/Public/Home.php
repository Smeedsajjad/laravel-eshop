<?php

namespace App\Livewire\Public;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Category;

class Home extends Component
{
    #[Layout('layouts.app')]
    public $categories;

    public function mount()
    {
        $this->categories = Category::orderBy('created_at', 'desc')
            ->take(8)
            ->get();
    }

    public function render()
    {
        return view('livewire.public.home');
    }
}
