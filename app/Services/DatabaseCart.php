<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DatabaseCart
{
    protected ?int $userId;

    public function __construct()
    {
        $this->userId = Auth::id();
    }

    public function add(Product $product, int $qty = 1): void
    {
        $row = Cart::firstOrCreate(
            ['user_id' => $this->userId, 'product_id' => $product->id],
            ['quantity' => 0]
        );
        $row->increment('quantity', $qty);
    }

    public function remove(int $productId): void
    {
        Cart::where([
            'user_id'    => $this->userId,
            'product_id' => $productId,
        ])->delete();
    }

    public function updateQty(int $productId, int $qty): void
    {
        if ($qty <= 0) {
            $this->remove($productId);
            return;
        }

        Cart::updateOrCreate(
            ['user_id' => $this->userId, 'product_id' => $productId],
            ['quantity' => $qty]
        );
    }

    public function clear(): void
    {
        Cart::where('user_id', $this->userId)->delete();
    }

    public function content()
    {
        return Cart::with('product')
            ->where('user_id', $this->userId)
            ->get();
    }

    public function count(): int
    {
        return $this->content()->sum('quantity');
    }

    public function total(): float
    {
        return $this->content()
            ->filter(fn($item) => $item->product)
            ->sum(fn($item) => $item->quantity * $item->product->price);
    }
}
