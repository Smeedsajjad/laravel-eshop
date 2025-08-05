<?php

namespace App\Livewire\Public\OrderManagement;

use App\Models\OrderItems;
use App\Models\Orders;
use App\Services\DatabaseCart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CheckoutPage extends Component
{
    #[Layout('layouts.app')]

    public $addresses;
    public $selectedAddressId;
    public $subtotal = 0;
    public $tax = 0;
    public $shipping = 5;
    public $total = 0;

    public function mount()
    {
        if (!Auth::check()) return redirect()->route('login');

        $this->loadTotals();
        $this->addresses = Auth::user()->addresses()
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $this->selectedAddressId = Auth::user()->defaultAddress?->id;
    }

    public function updatedSelectedAddressId()
    {
        $this->loadTotals();
    }

    private function loadTotals()
    {
        $cart = app(DatabaseCart::class);
        $this->subtotal = $cart->total();
        $this->tax      = $this->subtotal * 0.08;
        $this->total    = $this->subtotal + $this->tax + $this->shipping;
    }

    public function proceed()
    {
        if (!$this->selectedAddressId) {
            session()->flash('error', 'Choose or add a shipping address.');
            return;
        }

        $order = Orders::create([
            'user_id'       => Auth::id(),
            'address_id'    => $this->selectedAddressId,
            'order_number'  => Orders::generateNumber(),
            'status'        => 'pending',
            'subtotal'      => $this->subtotal,
            'tax'           => $this->tax,
            'shipping_cost' => $this->shipping,
            'total'         => $this->total,
        ]);

        foreach ($cart = app(DatabaseCart::class)->content() as $row) {
            OrderItems::create([
                'order_id'   => $order->id,
                'product_id' => $row->product_id,
                'price'      => $row->product->price,
                'quantity'   => $row->quantity,
                'total'      => $row->quantity * $row->product->price,
            ]);
        }

        $items = $cart->map(fn($r) => [
            'price_data' => [
                'currency'     => 'usd',
                'product_data' => ['name' => $r->product->name],
                'unit_amount'  => $r->product->price * 100,
            ],
            'quantity' => $r->quantity,
        ])->toArray();

        return Redirect::away(
            Auth::user()->checkout($items, [
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'  => route('checkout.cancel'),
                'metadata'    => ['order_id' => $order->id],
            ])->url
        );
    }

    public function render()
    {
        return view('livewire.public.order-management.checkout-page', [
            'cart' => app(DatabaseCart::class)->content(),
        ]);
    }
}
