<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class DatabaseWishlist
{
    protected int $userId;
    public function __construct()
    {
        $this->userId = Auth::id() ?? abort(401, 'Please log in');
    }

    public function toggle(Product $product): void
    {
        $exists = Wishlist::where('user_id', $this->userId)
            ->where('product_id', $product->id)
            ->exists();

        if ($exists) {
            Wishlist::where('user_id', $this->userId)
                ->where('product_id', $product->id)
                ->delete();
        } else {
            Wishlist::create([
                'user_id'    => $this->userId,
                'product_id' => $product->id,
            ]);
        }
    }

    public function ids(): array
    {
        return Wishlist::where('user_id', $this->userId)
            ->pluck('product_id')->toArray();
    }

    public function content()
    {
        return Wishlist::with('product')
            ->where('user_id', $this->userId)
            ->get();
    }

    public function count(): int
    {
        return Wishlist::where('user_id', $this->userId)->count();
    }
}
