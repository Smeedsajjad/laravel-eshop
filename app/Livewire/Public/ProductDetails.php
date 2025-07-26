<?php

namespace App\Livewire\Public;

use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ProductDetails extends Component
{
    #[Layout('layouts.app')]

    public Product $product;

    public function mount(Product $product)
    {
        $this->product = $product;
    }

      public function getAllProductImages(Product $product): array
    {
        $images = [];

        if ($product->images && $product->images->isNotEmpty()) {
            foreach ($product->images as $imageRecord) {
                $currentImagePaths = $imageRecord->image_path;

                if (is_array($currentImagePaths)) {
                    $images = array_merge($images, $currentImagePaths);
                } elseif (is_string($currentImagePaths) && !empty($currentImagePaths)) {
                    $decodedPaths = json_decode($currentImagePaths, true);
                    if (is_array($decodedPaths)) {
                        $images = array_merge($images, $decodedPaths);
                    } else {
                        $images[] = $currentImagePaths;
                    }
                }
            }
        }

        if (empty($images) && isset($product->images_column)) {
            $directProductImages = json_decode($product->images_column, true);
            if (is_array($directProductImages)) {
                $images = array_merge($images, $directProductImages);
            }
        }

        return array_values(array_unique(array_filter($images)));
    }

    public function render()
    {
        $products = Product::query()
            ->where('is_active', true)
            ->with(['attributeValues' => fn($q) => $q->with('attribute'), 'images'])
            ->get();

        $attributes = ProductAttribute::with('values')->get();

        return view('livewire.public.product-details', [
            'products'   => $products,
            'attributes' => $attributes,
            'images' => $this->getAllProductImages($this->product),

        ]);
    }
}
