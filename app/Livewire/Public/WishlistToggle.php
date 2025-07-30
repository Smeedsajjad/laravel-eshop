<?php

namespace App\Livewire\Public;

use App\Models\Product;
use App\Services\DatabaseWishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WishlistToggle extends Component
{
    public int $productId;
    public bool $isWished = false;

    protected $listeners = ['wishlist-updated' => '$refresh'];

    public function mount($productId)
    {
        $this->productId = $productId;
        if (Auth::check()) {
            $this->isWished = in_array(
                $productId,
                app(DatabaseWishlist::class)->ids()
            );
        }
    }

    public function toggle()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $product = Product::findOrFail($this->productId);
        app(DatabaseWishlist::class)->toggle($product);

        $this->isWished = !$this->isWished;

        $this->dispatch('wishlist-updated');
    }

    public function render()
    {
        return <<<'blade'
            <button wire:click="toggle"
                    class="btn bg-transparent shadow-none border-0 btn-circle btn-sm text-red-500"
                    title="Add to wishlist">
                <x-heroicon-o-heart class="w-5 h-5 {{ $isWished ? 'fill-current' : '' }}" />
            </button>
        blade;
    }
}
