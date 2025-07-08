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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductEdit extends Component
{
    use WithFileUploads;

    #[Layout('layouts.admin')]

    public $product;
    public $name = '';
    public $description = '';
    public $category_id = '';
    public $price = '';
    public $stock = '';
    public $sku = '';
    public $is_active = true;
    public $image_path = [];
    public $existing_images = [];
    public $addAttribute = '';
    public $filterAttribute = false;
    public $allAttributes = null;
    public $newAttribute = '';
    public $newValue = '';
    public $specs = [];

    protected function getProductRules()
    {
        return [
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|string|max:100|unique:products,sku,' . $this->product->id,
            'description' => 'nullable|string',
            'image_path.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean',
            'specs.*.attribute_id' => 'required|exists:product_attributes,id',
            'specs.*.value' => 'required|string|max:255',
        ];
    }

    protected function getAttributeRules()
    {
        return [
            'addAttribute' => 'required|string|max:255|unique:product_attributes,type',
            'filterAttribute' => 'boolean',
        ];
    }

    protected function getSpecRules()
    {
        return [
            'newAttribute' => 'required|exists:product_attributes,id',
            'newValue' => 'required|string|max:255',
        ];
    }

    public function updatedImagePath()
    {
        Log::info('Image path updated', ['image_path_count' => count($this->image_path)]);
        $this->validate([
            'image_path.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
    }

    public function updateSpec($index, $value)
    {
        if (isset($this->specs[$index])) {
            $this->specs[$index]['value'] = $value;
        }
    }

    public function removeImage($index)
    {
        if (isset($this->image_path[$index])) {
            Log::info('Removing new image from image_path', ['index' => $index]);
            unset($this->image_path[$index]);
            $this->image_path = array_values($this->image_path);
        }
    }

    public function removeExistingImage($id)
    {
        Log::info('Attempting to remove existing image', ['id' => $id]);
        $this->existing_images = collect($this->existing_images)->filter(function ($image) use ($id) {
            return $image['id'] != $id;
        })->values()->toArray();
        Log::info('Updated existing_images', ['existing_images_count' => count($this->existing_images)]);
    }

    public function addSpec()
    {
        $this->validate($this->getSpecRules());

        $attribute = ProductAttribute::find($this->newAttribute);

        if (!$attribute) {
            $this->addError('newAttribute', 'Selected attribute does not exist.');
            return;
        }

        if ($this->hasAttribute($this->newAttribute)) {
            $this->addError('newAttribute', 'This attribute has already been added.');
            return;
        }

        $this->specs[] = [
            'attribute_id' => $this->newAttribute,
            'attribute_name' => $attribute->type,
            'value' => $this->newValue,
        ];

        $this->reset(['newAttribute', 'newValue']);
        $this->resetValidation(['newAttribute', 'newValue']);

        $this->dispatch('spec-added', [
            'attribute' => $attribute->type
        ]);
    }

    public function removeSpec($index)
    {
        if (isset($this->specs[$index])) {
            $attributeName = $this->specs[$index]['attribute_name'];
            unset($this->specs[$index]);
            $this->specs = array_values($this->specs);

            $this->dispatch('spec-removed', [
                'attribute' => $attributeName
            ]);
        }
    }

    public function clearAllSpecs()
    {
        $count = count($this->specs);
        $this->specs = [];

        $this->dispatch('specs-cleared', [
            'count' => $count
        ]);
    }

    public function saveAttribute()
    {
        $this->validate($this->getAttributeRules());

        try {
            $attribute = ProductAttribute::create([
                'type' => $this->addAttribute,
                'is_filterable' => $this->filterAttribute,
            ]);

            $this->reset(['addAttribute', 'filterAttribute']);
            $this->resetValidation(['addAttribute', 'filterAttribute']);

            $this->refreshAttributes();

            $this->dispatch('attribute-created', [
                'message' => 'Attribute "' . $attribute->type . '" created successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to create attribute', ['error' => $e->getMessage()]);
            $this->addError('addAttribute', 'Failed to create attribute: ' . $e->getMessage());
        }
    }

    public function getSpecsCount()
    {
        return count($this->specs);
    }

    public function hasAttribute($attributeId)
    {
        return collect($this->specs)->contains('attribute_id', $attributeId);
    }

    public function refreshAttributes()
    {
        try {
            $this->allAttributes = ProductAttribute::orderBy('type')->get();
            Log::info('Attributes refreshed', ['count' => $this->allAttributes->count()]);
        } catch (\Exception $e) {
            Log::error('Failed to refresh attributes', ['error' => $e->getMessage()]);
            $this->allAttributes = collect();
        }
    }

    public function mount(Product $product)
    {
        $this->product = $product;

        try {
            $this->product->load([
                'category',
                'images',
                'attributeValues.attribute'
            ]);

            $this->name = $product->name;
            $this->description = $product->description;
            $this->category_id = $product->category_id;
            $this->price = $product->price;
            $this->stock = $product->stock;
            $this->sku = $product->sku;
            $this->is_active = $product->is_active;

            $this->loadExistingImages();
            $this->loadProductSpecs();
            $this->refreshAttributes();

            Log::info('ProductEdit mounted', [
                'product_id' => $product->id,
                'allAttributes_count' => $this->allAttributes ? $this->allAttributes->count() : 0,
                'specs_count' => count($this->specs),
                'existing_images_count' => count($this->existing_images),
            ]);
        } catch (\Exception $e) {
            Log::error('Error in mount', ['error' => $e->getMessage()]);
            $this->allAttributes = collect();
            $this->specs = [];
            $this->existing_images = [];
            session()->flash('error', 'Failed to load product data: ' . $e->getMessage());
        }
    }

    protected function loadExistingImages()
    {
        try {
            $this->existing_images = $this->product->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'path' => $image->image_path,
                    'url' => Storage::url($image->image_path),
                    'key' => (string) $image->id,
                ];
            })->toArray();

            Log::info('Loaded existing images', ['count' => count($this->existing_images)]);
        } catch (\Exception $e) {
            Log::error('Error loading existing images', ['error' => $e->getMessage()]);
            $this->existing_images = [];
        }
    }

    protected function loadProductSpecs()
    {
        try {
            $attributeValues = ProductAttributeValue::where('product_id', $this->product->id)
                ->with('attribute')
                ->get();

            $this->specs = $attributeValues->map(function ($attributeValue) {
                return [
                    'id' => $attributeValue->id,
                    'attribute_id' => $attributeValue->product_attribute_id,
                    'attribute_name' => $attributeValue->attribute ? $attributeValue->attribute->type : 'Attribute Missing',
                    'value' => $attributeValue->value,
                ];
            })->toArray();

            Log::info('Loaded product specs', [
                'product_id' => $this->product->id,
                'specs_count' => count($this->specs),
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading product specs', ['error' => $e->getMessage()]);
            $this->specs = [];
        }
    }

    public function update()
    {
        try {
            $this->validate($this->getProductRules());

            DB::beginTransaction();

            // Update product details
            $this->product->update([
                'name' => $this->name,
                'description' => $this->description,
                'category_id' => $this->category_id,
                'price' => $this->price,
                'stock' => $this->stock,
                'sku' => $this->sku,
                'is_active' => $this->is_active ?? false,
            ]);

            // Handle image deletions first
            $this->handleImageDeletions();

            // Handle new image uploads
            if (!empty($this->image_path)) {
                $this->handleImageUploads();
            }

            // Handle specifications
            $this->handleSpecifications();

            DB::commit();

            // Reset image_path and refresh existing images
            $this->image_path = [];
            $this->product->refresh();
            $this->loadExistingImages();

            Log::info('Product updated successfully', [
                'product_id' => $this->product->id,
                'image_path_count' => count($this->image_path),
                'existing_images_count' => count($this->existing_images),
                'specs_count' => count($this->specs),
            ]);

            session()->flash('success', 'Product "' . $this->product->name . '" updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            Log::error('Validation error during product update', ['errors' => $e->errors()]);
            session()->flash('error', 'Please fix the validation errors.');
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating product', [
                'product_id' => $this->product->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            session()->flash('error', 'Failed to update product: ' . $e->getMessage());
        }
    }

    private function handleImageUploads()
    {
        Log::info('Handling image uploads', ['image_count' => count($this->image_path)]);
        foreach ($this->image_path as $index => $image) {
            try {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $this->product->id,
                    'image_path' => $path,
                ]);
                Log::info('Image uploaded', ['index' => $index, 'path' => $path]);
            } catch (\Exception $e) {
                Log::error('Failed to upload image', [
                    'index' => $index,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    protected function handleImageDeletions()
    {
        try {
            // Get current existing image IDs (what should remain)
            $existingImageIds = collect($this->existing_images)->pluck('id')->toArray();

            // Get original image IDs from database
            $originalImageIds = $this->product->images->pluck('id')->toArray();

            // Find images to delete (original - existing)
            $imagesToDeleteIds = array_diff($originalImageIds, $existingImageIds);

            if (!empty($imagesToDeleteIds)) {
                Log::info('Deleting images', [
                    'existing_ids' => $existingImageIds,
                    'original_ids' => $originalImageIds,
                    'to_delete_ids' => $imagesToDeleteIds
                ]);

                $imagesToDelete = ProductImage::whereIn('id', $imagesToDeleteIds)->get();

                foreach ($imagesToDelete as $image) {
                    try {
                        // Delete file from storage
                        if (Storage::disk('public')->exists($image->image_path)) {
                            Storage::disk('public')->delete($image->image_path);
                            Log::info('Image file deleted from storage', ['path' => $image->image_path]);
                        }

                        // Delete database record
                        $image->delete();
                        Log::info('Image record deleted from database', ['id' => $image->id]);

                    } catch (\Exception $e) {
                        Log::error('Failed to delete image', [
                            'id' => $image->id,
                            'path' => $image->image_path,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            } else {
                Log::info('No images to delete', [
                    'existing_ids' => $existingImageIds,
                    'original_ids' => $originalImageIds
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error in handleImageDeletions', ['error' => $e->getMessage()]);
        }
    }

    protected function handleSpecifications()
    {
        $existingSpecIds = collect($this->specs)->pluck('id')->filter()->toArray();

        Log::info('Handling specifications', [
            'product_id' => $this->product->id,
            'existing_spec_ids' => $existingSpecIds,
            'specs' => $this->specs,
        ]);

        $this->product->attributeValues()
            ->whereNotIn('id', $existingSpecIds)
            ->delete();

        foreach ($this->specs as $spec) {
            if (isset($spec['id']) && !empty($spec['id'])) {
                ProductAttributeValue::where('id', $spec['id'])
                    ->update(['value' => $spec['value']]);
            } else {
                ProductAttributeValue::create([
                    'product_id' => $this->product->id,
                    'product_attribute_id' => $spec['attribute_id'],
                    'value' => $spec['value'],
                ]);
            }
        }
    }

    public function resetForm()
    {
        $this->reset([
            'name',
            'description',
            'category_id',
            'price',
            'stock',
            'sku',
            'is_active',
            'image_path',
            'addAttribute',
            'filterAttribute',
            'newAttribute',
            'newValue',
        ]);
        $this->specs = [];
        $this->existing_images = [];
        $this->resetValidation();
    }

    public function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' bytes';
    }

    public function render()
    {
        Log::info('Rendering ProductEdit', [
            'allAttributes_count' => $this->allAttributes ? $this->allAttributes->count() : 0,
            'specs_count' => count($this->specs),
            'existing_images_count' => count($this->existing_images),
            'image_path_count' => count($this->image_path),
        ]);

        $categories = Category::orderBy('cat_name')->get();
        return view('livewire.admin.product-edit', [
            'product' => $this->product,
            'category' => $categories,
        ]);
    }
}
