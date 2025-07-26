<?php

namespace App\Livewire\Public;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;

class ProductsList extends Component
{
    use WithPagination, WithoutUrlPagination;

    #[Layout('layouts.app')]

    public $minPrice = '';
    public $maxPrice = '';
    public $allMin;
    public $allMax;
    public $selectedFilters = [];
    public $sortBy = '';
    public $categorySlug;
    public $category;

    public function mount($slug = null)
    {
        $this->categorySlug = $slug;
        $this->category     = $slug
            ? Category::where('slug', $slug)->firstOrFail()
            : null;
        $this->allMin = Product::min('price') ?? 0;
        $this->allMax = Product::max('price') ?? 1000;
        $this->selectedFilters = [];

        $filterableAttributes = ProductAttribute::where('is_filterable', true)->get();
        foreach ($filterableAttributes as $attribute) {
            $this->selectedFilters[$attribute->id] = [];
        }
    }

    public function updatedMinPrice()
    {
        $this->resetPage();
    }

    public function updatedMaxPrice()
    {
        $this->resetPage();
    }

    public function updatedSelectedFilters()
    {
        $this->resetPage();
    }

    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->minPrice = '';
        $this->maxPrice = '';
        $this->selectedFilters = [];
        $this->sortBy = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::query()->where('is_active', true);
        if ($this->category) {
            $query->whereHas(
                'category',
                fn($q) =>
                $q->where('id', $this->category->id)
            );
        }
        // Price filter
        if ($this->minPrice !== '' || $this->maxPrice !== '') {
            $min = $this->minPrice !== '' ? (float) $this->minPrice : 0;
            $max = $this->maxPrice !== '' ? (float) $this->maxPrice : $this->allMax;
            $query->whereBetween('price', [$min, $max]);
        }

        foreach ($this->selectedFilters as $attributeId => $selectedValues) {
            $values = array_filter($selectedValues);
            if ($values) {
                $query->whereHas('attributeValues', function ($q) use ($attributeId, $values) {
                    $q->where('product_attribute_id', $attributeId)
                        ->whereIn('value', $values);
                });
            }
        }

        // Sorting
        switch ($this->sortBy) {
            case 'price_low_high':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high_low':
                $query->orderBy('price', 'desc');
                break;
            case 'name_az':
                $query->orderBy('name', 'asc');
                break;
            case 'name_za':
                $query->orderBy('name', 'desc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(9);
        $filterableAttributes = ProductAttribute::with('values')->where('is_filterable', true)->get();

        return view('livewire.public.products-list', [
            'products' => $products,
            'filterableAttributes' => $filterableAttributes,
        ]);
    }
}
