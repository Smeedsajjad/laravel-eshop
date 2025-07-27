<?php

namespace App\Livewire\Public;

use Livewire\Component;

class SearchBar extends Component
{
    public string $query = '';

    public function render()
    {
        $results = $this->query
            ? \App\Models\Product::search($this->query)->take(8)->get()
            : collect();
        return view('livewire.public.search-bar', compact('results'));
    }
}
