<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ProductShow extends Component
{
    #[Layout('layouts.admin')]
    public $product;

    public function mount($product)
    {
        $this->product = Product::where('slug', $product)->with('attributeValues.attribute')->firstOrFail();
    }

    public function render()
    {
        // Check if attribute values exist
        if ($this->product->relationLoaded('attributeValues')) {
            Log::info('Attribute Values:', $this->product->attributeValues->toArray());
        } else {
            Log::warning('Attribute values not loaded');
        }

        return view('livewire.admin.product-show', [
            'product' => $this->product,
            'images' => $this->getAllProductImages($this->product),
        ]);
    }

    public function getAllProductImages($product)
    {
        $images = [];

        if ($product->images && $product->images->isNotEmpty()) {
            foreach ($product->images as $imageRecord) {
                $imagePath = $imageRecord->image_path;

                if (is_array($imagePath)) {
                    $images = array_merge($images, $imagePath);
                } elseif (is_string($imagePath) && !empty($imagePath)) {
                    $decoded = json_decode($imagePath, true);
                    if ($decoded !== null && is_array($decoded)) {
                        $images = array_merge($images, $decoded);
                    } else {
                        $images[] = $imagePath;
                    }
                }
            }
        }

        if (empty($images) && isset($product->images_column)) {
            $productImages = json_decode($product->images_column, true);
            if (is_array($productImages)) {
                $images = $productImages;
            }
        }

        return array_values(array_unique(array_filter($images)));
    }

    public function formatPrice($price)
    {
        return '$' . number_format($price, 2);
    }

    public function getStockStatus($stock)
    {
        if ($stock <= 0) {
            return ['status' => 'Out of Stock', 'class' => 'badge-error'];
        } elseif ($stock <= 10) {
            return ['status' => 'Low Stock', 'class' => 'badge-warning'];
        } else {
            return ['status' => 'In Stock', 'class' => 'badge-success'];
        }
    }
}
