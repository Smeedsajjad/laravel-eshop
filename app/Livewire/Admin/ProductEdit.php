<?php

namespace App\Livewire\Admin;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\ProductImage;
use App\Models\ProductAttributeValue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductEdit extends Component
{
    use WithFileUploads;

    #[Layout('layouts.admin')]

    public $name = '';
    public $description = '';
    public $category_id = '';
    public $price = '';
    public $stock = '';
    public $sku = '';
    public $is_active = true;
    public $image_path = [];

    public $addAttribute = '';
    public $filterAttribute = false;

    public $allAttributes;
    public $newAttribute = '';
    public $newValue = '';
    public $specs = [];

    protected function getProductRules()
    {
        return [
            'name'             => 'required|string|max:255',
            'stock'            => 'required|integer|min:0',
            'price'            => 'required|numeric|min:0',
            'category_id'      => 'required|exists:categories,id',
            'is_active'        => 'boolean',
            'description'      => 'nullable|string',
            'image_path.*'     => 'image|max:2048',
        ];
    }

    protected function getAttributeRules()
    {
        return [
            'addAttribute'     => 'required|string|max:255|unique:product_attributes,type',
            'filterAttribute'  => 'boolean'
        ];
    }

   protected function getSpecRules()
    {
        return [
            'newAttribute' => 'required|exists:product_attributes,id',
            'newValue'     => 'required|string|max:255',
        ];
    }

    public function updatedImagePath()
    {
        $this->validate([
            'image_path.*' => 'image|max:2048',
        ]);
    }

  
    public function render()
    {
        return view('livewire.admin.product-edit');        
    }
}