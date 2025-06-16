<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id',
        'price',
        'stock',
        'sku',
        'is_active',
        'meta_data'
    ];

    protected $casts = [
        'images' => 'array',
        'meta_data' => 'array',
    ];

    protected static function booted()
    {
        static::saving(function ($prod) {
            if (empty($prod->slug)) {
                $prod->slug = Str::slug($prod->name) . '-' . Str::random(4);
            }
        });
    }

    public function cateogry(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    // public function scopeActive($query)
    // {
    //     return $query->where('is_active', true);
    // }

    public function specs()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }
}
