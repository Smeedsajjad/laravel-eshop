<?php

namespace App\Livewire\Public\OrderManagement;

use Livewire\Attributes\Layout;
use App\Models\Product;
use App\Services\DatabaseCart;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Cart extends Component
{
    #[Layout('layouts.app')]

    public $items = [];
    public $total = 0;
    public $count = 0;
    public array $selected = [];
    public float $checkedTotal = 0;

    protected $listeners = [
        'add-to-cart' => 'addToCart',
        'cartUpdated' => 'refresh',
    ];

    public function mount()
    {
        if (Auth::check()) {
            $this->refresh();
        } else {
            $this->items = collect();
            $this->total = 0;
            $this->count = 0;
        }
    }

    public function addToCart($id)
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please log in to add items to your cart.');
            return redirect()->route('login');
        }

        $product = Product::findOrFail($id);
        app(DatabaseCart::class)->add($product);

        $this->dispatch('cartUpdated');
        session()->flash('success', 'Product added to cart!');
    }

    public function refresh()
    {
        if (Auth::check()) {
            $cart = app(DatabaseCart::class);
            $this->items = $cart->content();
            $this->total = $cart->total();
            $this->count = $cart->count();
            $this->calculateCheckedTotal();
        } else {
            $this->items = collect();
            $this->total = 0;
            $this->count = 0;
        }
    }

    public function remove($productId)
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please log in to manage your cart.');
            return redirect()->route('login');
        }

        app(DatabaseCart::class)->remove($productId);
        $this->dispatch('cartUpdated');
        session()->flash('success', 'Product removed from cart.');
    }

    public function updateQty($productId, $qty)
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please log in to manage your cart.');
            return redirect()->route('login');
        }

        app(DatabaseCart::class)->updateQty($productId, (int) $qty);
        $this->dispatch('cartUpdated');
        session()->flash('success', 'Cart quantity updated.');
    }

    public function increment(int $productId)
    {
        $cart = app(DatabaseCart::class);
        $current = $cart->content()
            ->firstWhere('product_id', $productId)
            ->quantity ?? 0;
        $cart->updateQty($productId, $current + 1);
        $this->dispatch('cartUpdated');
    }

    public function decrement(int $productId)
    {
        $cart = app(DatabaseCart::class);
        $current = $cart->content()
            ->firstWhere('product_id', $productId)
            ->quantity ?? 0;
        if ($current > 1) {
            $cart->updateQty($productId, $current - 1);
        } else {
            $cart->remove($productId);
        }
        $this->dispatch('cartUpdated');
    }

    public function updatedSelected()
    {
        $this->calculateCheckedTotal();
    }

    public function calculateCheckedTotal()
    {
        $this->checkedTotal = $this->items
            ->filter(fn($item) => in_array($item->product_id, $this->selected))
            ->sum(fn($item) => $item->quantity * $item->product->price);
    }

    public function render()
    {
        return view('livewire.public.order-management.cart');
    }
}
