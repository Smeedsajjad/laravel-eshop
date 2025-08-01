<?php

namespace App\Livewire;

use App\Services\DatabaseCart;
use Livewire\Component;

class CheckoutPage extends Component
{
    public $cartTotal;

    public function mount()
    {
        $this->cartTotal = app(DatabaseCart::class)->total();
    }

    public function pay()
    {
        $items = app(DatabaseCart::class)
            ->content()
            ->map(fn($row) => [
                'price_data' => [
                    'currency'     => 'usd',
                    'product_data' => [
                        'name' => $row->product->name,
                    ],
                    'unit_amount'  => $row->product->price * 100,
                ],
                'quantity' => $row->quantity,
            ]);

        return auth()->user()->checkout(
            $items->toArray(),
            [
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'  => route('checkout.cancel'),
                'mode'        => 'payment',
            ]
        );
    }

    public function render()
    {
        return view('livewire.checkout-page');
    }
}
