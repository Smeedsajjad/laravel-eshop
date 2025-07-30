<?php

namespace App\Livewire\Public;

use App\Models\Product;
use App\Services\DatabaseWishlist;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Wishlist extends Component
{
    use WithPagination, WithoutUrlPagination;

    #[Layout('layouts.app')]

    public $products;
    public $selected = [];

    protected $listeners = ['wishlist-updated' => '$refresh'];

    public function mount()
    {
        $this->loadProducts();
    }

    public function loadProducts()
    {
        $this->products = app(DatabaseWishlist::class)
            ->content()
            ->pluck('product');
    }

    public function removeFromWishlist($productId)
    {
        app(DatabaseWishlist::class)->toggle(Product::findOrFail($productId));
        $this->loadProducts();
    }

    public function render()
    {
        $rows = \App\Models\Wishlist::with('product')
              ->where('user_id', auth()->id())
              ->paginate(9);

        return view('livewire.public.wishlist', [
            'products' => $rows->pluck('product'),
            'rows'     => $rows,
        ]);
    }
}
