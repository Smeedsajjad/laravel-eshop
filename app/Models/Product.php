<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use Searchable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id',
        'price',
        'stock',
        'sku',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    protected static function booted()
    {
        static::saving(function ($prod) {
            if (empty($prod->slug)) {
                $prod->slug = Str::slug($prod->name) . '-' . Str::random(4);
            }
        });
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        $this->loadMissing('category');

        return array_merge($this->toArray(), [
            'id' => (string) $this->id,
            'name' => (string) $this->name,
            'description' => $this->description,
            'category_name'    => $this->category->cat_name,
            'price' => (float) $this->price,
            'category_id' => (int) $this->category_id,
            'created_at' => $this->created_at->timestamp,
            'created_at' => $this->created_at->timestamp,
        ]);
    }

    public function getFirstImagePathAttribute(): ?string
    {
        $decodedImages = json_decode($this->images, true);
        if (!is_array($decodedImages) || empty($decodedImages)) {
            return null;
        }

        $firstImageObject = $decodedImages[0];
        if (!isset($firstImageObject['image_path'])) {
            return null;
        }

        $imagePathsArray = json_decode($firstImageObject['image_path'], true);
        if (!is_array($imagePathsArray) || empty($imagePathsArray)) {
            return null;
        }

        return $imagePathsArray[0];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function attributeValues(): HasMany
    {
        return $this->hasMany(ProductAttributeValue::class, 'product_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function avgRating(): HasMany
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
