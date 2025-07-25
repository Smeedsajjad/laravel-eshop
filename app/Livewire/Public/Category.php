<?php

namespace App\Livewire\Public;

use App\Models\Category as ModelsCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class Category extends Component
{
    use WithPagination, WithoutUrlPagination;

    #[Layout('layouts.app')]

    public $perPage = 9;

    public function render()
    {
        $category = ModelsCategory::paginate($this->perPage);

        return view('livewire.public.category',[
            'category' => $category,
        ]);
    }
}
