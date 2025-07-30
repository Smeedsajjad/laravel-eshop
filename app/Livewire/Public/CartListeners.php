<?php

namespace App\Livewire\Public;

use App\Models\Product;
use App\Services\DatabaseCart;
use Livewire\Component;

class CartListeners extends Component
{
     protected $listeners = ['addToCart'];

    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);
        app(DatabaseCart::class)->add($product);

        $this->emit('cartUpdated');
        $this->dispatchBrowserEvent('notify', 'Added to cart');
    }

    public function render()
    {
        return <<<'blade'
            <div></div>
        blade;
    }
}
