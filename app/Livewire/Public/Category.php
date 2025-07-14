<?php

namespace App\Livewire\Public;

use App\Models\Category as ModelsCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Category extends Component
{
    #[Layout('layouts.app')]

    public function render()
    {
        $category = ModelsCategory::get();
        return view('livewire.public.category',[
            'category' => $category,
        ]);
    }
}
