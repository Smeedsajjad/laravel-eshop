<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Orders extends Model
{
        protected $fillable = [
        'user_id',
        'address_id',
        'order_number',
        'status',
        'subtotal',
        'tax',
        'shipping_cost',
        'total',
        'customer_note',
    ];

    protected $casts = [
        'subtotal'       => 'decimal:2',
        'tax'            => 'decimal:2',
        'shipping_cost'  => 'decimal:2',
        'total'          => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItems::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payments::class);
    }

    /* Helper to generate a friendly order number */
    public static function generateNumber(): string
    {
        return 'ORD-' . now()->format('YmdHis') . strtoupper(Str::random(4));
    }
}
