<?php

namespace App\Livewire\Public\OrderManagement;

use App\Models\Orders;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Laravel\Cashier\Checkout;
use Stripe\StripeClient;
use Livewire\Component;

class OrdersDetail extends Component
{
    #[Layout('layouts.app')]

    public Orders $order;


    public function mount(Orders $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(404);
        }
        $this->order = $order;
    }

    public function repeatOrder()
    {
        if (!Auth::check()) {
            session()->flash('error', 'Please log in to add items to your cart.');
            return redirect()->route('login');
        }

        if ($this->order->items->isNotEmpty()) {
            foreach ($this->order->items as $item) {
                if ($item->product) {
                    app(\App\Services\DatabaseCart::class)->add($item->product, $item->quantity);
                }
            }
            session()->flash('success', 'Items added to cart!');
            return redirect()->route('checkout');
        }

        session()->flash('info', 'No items found in this order to repeat.');
        return redirect()->back();
    }

    public function payWithStripe()
    {
        $lineItems = $this->order->items->map(fn($i) => [
            'price_data' => [
                'currency'     => 'usd',
                'product_data' => ['name' => $i->product->name],
                'unit_amount'  => $i->unit_price * 100,
            ],
            'quantity'   => $i->quantity,
        ])->toArray();

        $session = Checkout::create([
            'payment_method_types' => ['card'],
            'line_items'           => $lineItems,
            'mode'                 => 'payment',
            'success_url'          => route('orders.show', $this->order) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'           => route('orders.show', $this->order),
            'metadata'             => ['order_id' => $this->order->id],
        ]);

        return redirect($session->url);
    }

    public function render()
    {
        return view('livewire.public.order-management.orders-detail');
    }
}
