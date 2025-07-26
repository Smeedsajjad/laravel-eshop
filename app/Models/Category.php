<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'cat_name',
        'main_image',
        'banner_image',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cat) {
            $cat->slug = Str::slug($cat->cat_name);
        });
    }

    public function category(): HasMany
    {
        return $this->hasMany(Category::class);
    }
}
