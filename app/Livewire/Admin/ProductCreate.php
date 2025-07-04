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
use Illuminate\Support\Str;

class ProductCreate extends Component
{
    use WithFileUploads;

    #[Layout('layouts.admin')]

    // Product form fields
    public $name = '';
    public $description = '';
    public $category_id = '';
    public $price = '';
    public $stock = '';
    public $sku = '';
    public $is_active = true;
    public $image_path = [];

    // Attribute form fields (separate from product)
    public $addAttribute = '';
    public $filterAttribute = false;

    // Product attributes handling
    public $allAttributes;
    public $newAttribute = '';
    public $newValue = '';
    public $specs = []; // Temporary storage for attribute-value pairs

    // Separate validation rules for product form only
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

    // Separate validation rules for attribute creation
    protected function getAttributeRules()
    {
        return [
            'addAttribute'     => 'required|string|max:255|unique:product_attributes,type',
            'filterAttribute'  => 'boolean'
        ];
    }

    // Validation rules for adding spec to product (only validate spec fields)
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

    public function removeImage($index)
    {
        if (isset($this->image_path[$index])) {
            unset($this->image_path[$index]);
            $this->image_path = array_values($this->image_path);
        }
    }

    // Save new attribute (completely separate from product validation)
    public function saveAttribute()
    {
        // Only validate attribute fields, not product fields
        $this->validate($this->getAttributeRules());

        try {
            $attribute = ProductAttribute::create([
                'type' => $this->addAttribute,
                'is_filterable' => $this->filterAttribute,
            ]);

            // Reset only attribute fields
            $this->reset(['addAttribute', 'filterAttribute']);
            $this->resetValidation(['addAttribute', 'filterAttribute']);

            // Refresh attributes list
            $this->allAttributes = ProductAttribute::orderBy('type')->get();

            $this->dispatch('attribute-created', [
                'message' => 'Attribute "' . $attribute->type . '" created successfully!'
            ]);
        } catch (\Exception $e) {
            $this->addError('addAttribute', 'Failed to create attribute: ' . $e->getMessage());
        }
    }

    // Add spec to temporary storage (separate validation)
    public function addSpec()
    {
        // Only validate spec fields, not product fields
        $this->validate($this->getSpecRules());

        $attribute = $this->allAttributes->firstWhere('id', $this->newAttribute);

        // Check for duplicate attributes
        if ($this->hasAttribute($this->newAttribute)) {
            $this->addError('newAttribute', 'This attribute is already added to the product.');
            return;
        }

        // Add to temporary specs array with unique ID for easier management
        $specId = uniqid(); // Generate unique ID for this spec
        $this->specs[] = [
            'id' => $specId,
            'attribute_id' => $attribute->id,
            'attribute_name' => $attribute->type,
            'value' => $this->newValue,
        ];

        $this->resetErrorBag(['specs']);

        // Reset only spec form fields
        $this->reset(['newAttribute', 'newValue']);
        $this->resetValidation(['newAttribute', 'newValue']);

        // Dispatch success event
        $this->dispatch('spec-added', [
            'attribute' => $attribute->type,
            'value' => $this->newValue,
            'count' => count($this->specs)
        ]);
    }

    // Remove spec from temporary storage
    public function removeSpec($index)
    {
        if (isset($this->specs[$index])) {
            $removedSpec = $this->specs[$index];
            unset($this->specs[$index]);
            $this->specs = array_values($this->specs); // Re-index array

            $this->dispatch('spec-removed', [
                'attribute' => $removedSpec['attribute_name'],
                'count' => count($this->specs)
            ]);
        }
    }

    // Update spec value in temporary storage
    public function updateSpecValue($index, $newValue)
    {
        if (isset($this->specs[$index]) && !empty(trim($newValue))) {
            $oldValue = $this->specs[$index]['value'];
            $this->specs[$index]['value'] = trim($newValue);

            $this->dispatch('spec-updated', [
                'attribute' => $this->specs[$index]['attribute_name'],
                'oldValue' => $oldValue,
                'newValue' => trim($newValue)
            ]);
        }
    }

    // Clear all specifications
    public function clearAllSpecs()
    {
        $count = count($this->specs);
        $this->specs = [];

        $this->dispatch('specs-cleared', [
            'count' => $count
        ]);
    }

    // Save product with all temporary specs
    public function saveProduct()
    {
        $this->resetErrorBag(['specs', 'image_path']);
        Log::info('Images received: ' . count($this->image_path)); // Debug log

        if (empty($this->image_path)) {
            $this->addError('image_path', 'Please select at least one product image.');
            $this->dispatch('validation-error', ['message' => 'At least one image is required.']);
            return;
        }

        if (count($this->image_path) > 6) {
            $this->addError('image_path', 'Maximum 6 images allowed.');
            $this->dispatch('validation-error', ['message' => 'Maximum 6 images allowed.']);
            return;
        }

        $this->validate($this->getProductRules());

        if (empty($this->specs)) {
            $this->addError('specs', 'Please add at least one specification.');
            $this->dispatch('validation-error', ['message' => 'At least one specification is required.']);
            return;
        }

        try {
            DB::beginTransaction();
            $product = Product::create([
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
                'stock' => $this->stock,
                'category_id' => $this->category_id,
                'is_active' => $this->is_active,
                'sku' => $this->sku ?: $this->generateSku(),
            ]);
            $this->handleImageUploads($product);
            $this->saveProductSpecs($product);
            DB::commit();

            $this->dispatch('product-created', ['message' => "Product '{$product->name}' created successfully!"]);
            $this->resetForm();
            session()->flash('message', 'Product created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('product-error', ['message' => 'Failed to create product: ' . $e->getMessage()]);
            Log::error('Product creation failed: ' . $e->getMessage());
        }
    }

    // Handle image uploads (extracted for better organization)
    private function handleImageUploads($product)
    {
        $imagePaths = [];
        foreach ($this->image_path as $index => $file) {
            if ($file && $file->isValid()) {
                try {
                    $filename = time() . '_' . $index . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('products', $filename, 'public');
                    if (!$path) {
                        throw new \Exception("Failed to store image: {$file->getClientOriginalName()}");
                    }
                    $imagePaths[] = $path;
                } catch (\Exception $e) {
                    Log::error('Image upload error: ' . $e->getMessage());
                    throw $e; // Re-throw to trigger rollback
                }
            }
        }

        if (!empty($imagePaths)) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => json_encode($imagePaths),
            ]);
        }
    }

    // Save product specifications (extracted for better organization)
    private function saveProductSpecs($product)
    {
        $attributeValues = [];
        foreach ($this->specs as $spec) {
            $attributeValues[] = [
                'product_id' => $product->id,
                'product_attribute_id' => $spec['attribute_id'],
                'value' => $spec['value'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Batch insert for better performance
        ProductAttributeValue::insert($attributeValues);
    }

    // Generate unique SKU
    private function generateSku()
    {
        do {
            $sku = 'PRD-' . strtoupper(Str::random(8));
        } while (Product::where('sku', $sku)->exists());

        return $sku;
    }

    // Reset the entire form
    public function resetForm()
    {
        Log::info('Resetting form');
        $this->reset([
            'name',
            'description',
            'price',
            'stock',
            'category_id',
            'is_active',
            'image_path',
            'specs',
            'sku',
            'newAttribute',
            'newValue',
        ]);
        $this->resetValidation();
        $this->dispatch('form-reset', ['message' => 'Form has been reset']);
    }

    // Helper methods
    public function getSpecsCount()
    {
        return count($this->specs);
    }

    public function hasAttribute($attributeId)
    {
        return collect($this->specs)->contains('attribute_id', $attributeId);
    }

    public function getUsedAttributeIds()
    {
        return collect($this->specs)->pluck('attribute_id')->toArray();
    }

    public function getAvailableAttributes()
    {
        $usedIds = $this->getUsedAttributeIds();
        return $this->allAttributes->whereNotIn('id', $usedIds);
    }

    // Format file size for display
    public function formatFileSize($bytes)
    {
        if ($bytes === 0) return '0 Bytes';
        $k = 1024;
        $sizes = ['Bytes', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes) / log($k));
        return round(($bytes / pow($k, $i)), 2) . ' ' . $sizes[$i];
    }

    // Component initialization
    public function mount()
    {
        $this->allAttributes = ProductAttribute::orderBy('type')->get();
        $this->specs = []; // Initialize empty specs array
        $this->is_active = true; // Default to active
    }

    // Render the component
    public function render()
    {
        $categories = Category::orderBy('cat_name')->get();
        return view('livewire.admin.product-create', [
            'category' => $categories,
            'availableAttributes' => $this->getAvailableAttributes()
        ]);
    }
}
