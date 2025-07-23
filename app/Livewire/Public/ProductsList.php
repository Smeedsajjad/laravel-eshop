<?php

namespace App\Livewire\Public;

use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ProductsList extends Component
{
    use WithPagination, WithoutUrlPagination;

    #[Layout('layouts.app')]

    public $minPrice = '';
    public $maxPrice = '';
    public $allMin;
    public $allMax;
    public $applyFilter = false;

    public function mount()
    {
        $this->allMin = Product::min('price');
        $this->allMax = Product::max('price');
    }

    public function filter()
    {
        $this->validate([
            'minPrice' => 'nullable|numeric|min:0',
            'maxPrice' => 'nullable|numeric' . ($this->minPrice !== '' ? '|gte:minPrice' : ''),
        ]);

        $this->applyFilter = true;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->minPrice = '';
        $this->maxPrice = '';
        $this->applyFilter = false;
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::query()->where('is_active', true);

        if ($this->applyFilter && ($this->minPrice !== '' || $this->maxPrice !== '')) {
            $min = $this->minPrice !== '' ? (float) $this->minPrice : 0;
            $max = $this->maxPrice !== '' ? (float) $this->maxPrice : $this->allMax;

            $query->whereBetween('price', [$min, $max]);
        }

        $products = $query->latest()->paginate(9);

        return view('livewire.public.products-list', [
            'products' => $products
        ]);
    }
}
