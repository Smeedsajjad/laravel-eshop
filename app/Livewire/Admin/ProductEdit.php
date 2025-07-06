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

    public function updateSpec($index, $value)
    {
        if (isset($this->specs[$index])) {
            $this->specs[$index]['value'] = $value;
        }
    }

    public function removeImage($index)
    {
        if (isset($this->image_path[$index])) {
            unset($this->image_path[$index]);
            $this->image_path = array_values($this->image_path);
        }
    }

    public function removeExistingImage($key)
    {
        $this->existing_images = collect($this->existing_images)->reject(function ($image) use ($key) {
            return $image['key'] == $key;
        })->values()->toArray();
    }

    public function addSpec()
    {
        $this->validate($this->getSpecRules());

        $attribute = ProductAttribute::find($this->newAttribute);

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

            $this->allAttributes = ProductAttribute::orderBy('type')->get();

            $this->dispatch('attribute-created', [
                'message' => 'Attribute "' . $attribute->type . '" created successfully!'
            ]);
        } catch (\Exception $e) {
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
        $this->allAttributes = ProductAttribute::orderBy('type')->get();
    }

    public function debugDatabase()
    {
        try {
            $tables = ['products', 'product_attributes', 'product_attribute_values'];
            foreach ($tables as $table) {
                $exists = DB::getSchemaBuilder()->hasTable($table);
                Log::info("Table {$table} exists: " . ($exists ? 'YES' : 'NO'));
            }

            $productData = DB::table('products')->where('id', $this->product->id)->first();
            Log::info('Product data from DB', ['product' => $productData]);

            $allAttributes = DB::table('product_attributes')->get();
            Log::info('All attributes in DB', ['count' => $allAttributes->count(), 'attributes' => $allAttributes->toArray()]);

            $attributeValues = DB::table('product_attribute_values')
                ->where('product_id', $this->product->id)
                ->get();
            Log::info('Attribute values for product', ['count' => $attributeValues->count(), 'values' => $attributeValues->toArray()]);

            $joinedData = DB::table('product_attribute_values as pav')
                ->join('product_attributes as pa', 'pav.attribute_id', '=', 'pa.id')
                ->where('pav.product_id', $this->product->id)
                ->select('pav.*', 'pa.type as attribute_name')
                ->get();
            Log::info('Joined data', ['count' => $joinedData->count(), 'data' => $joinedData->toArray()]);

            return $joinedData;
        } catch (\Exception $e) {
            Log::error('Database debug error', ['error' => $e->getMessage()]);
            return collect();
        }
    }

    public function mount(Product $product)
    {
        $this->product = $product;

        $this->product->load([
            'category',
            'images',
            'attributeValues.attribute'
        ]);

        $this->name        = $product->name;
        $this->description = $product->description;
        $this->category_id = $product->category_id;
        $this->price       = $product->price;
        $this->stock       = $product->stock;
        $this->sku         = $product->sku;
        $this->is_active   = $product->is_active;

        $this->loadExistingImages();

        $joinedData = $this->debugDatabase();

        $this->loadProductSpecs();

        if (empty($this->specs) && $joinedData->count() > 0) {
            $this->specs = $joinedData->map(function ($item) {
                return [
                    'id' => $item->id,
                    'attribute_id' => $item->attribute_id,
                    'attribute_name' => $item->attribute_name,
                    'value' => $item->value,
                ];
            })->toArray();

            Log::info('Used joined data for specs', ['specs' => $this->specs]);
        }

        $this->allAttributes = ProductAttribute::orderBy('type')->get();

        Log::info('Product specs loaded in mount', [
            'product_id' => $product->id,
            'specs_count' => count($this->specs),
            'specs' => $this->specs
        ]);
    }

    protected function loadExistingImages()
    {
        $this->existing_images = $this->product->images->flatMap(function ($image) {
            $paths = is_string($image->image_path) && Str::startsWith($image->image_path, '[')
                ? json_decode($image->image_path, true)
                : [$image->image_path];

            if (is_array($paths) && count($paths) > 1) {
                Log::warning("ProductImage id {$image->id} has multiple paths: " . json_encode($paths));
            } else {
                $paths = [$image->image_path];
            }

            return collect($paths)->map(function ($path, $index) use ($image) {
                return [
                    'id' => $image->id,
                    'path' => $path,
                    'url' => Storage::url($path),
                    'key' => $image->id . '-' . $index,
                ];
            });
        })->values()->toArray();
    }

    protected function loadProductSpecs()
    {
        try {
            Log::info('Loading specs for product', [
                'product_id' => $this->product->id ?? 'NULL',
                'product_exists' => $this->product ? 'YES' : 'NO'
            ]);

            $attributeValues = ProductAttributeValue::where('product_id', $this->product->id)
                ->with('attribute')
                ->get();

            Log::info('Attribute values loaded', [
                'count' => $attributeValues->count(),
                'raw_data' => $attributeValues->toArray()
            ]);

            // Check attribute IDs against existing attributes
            $attributeIds = $attributeValues->pluck('attribute_id')->unique();
            Log::info('Attribute IDs in product_attribute_values', ['attribute_ids' => $attributeIds->toArray()]);

            $existingAttributes = ProductAttribute::whereIn('id', $attributeIds)->get();
            Log::info('Existing attributes', [
                'count' => $existingAttributes->count(),
                'ids' => $existingAttributes->pluck('id')->toArray()
            ]);

            // $this->specs = $attributeValues
            //     ->filter(function ($attributeValue) {
            //         $hasAttribute = $attributeValue->attribute !== null;
            //         Log::info('Filtering attribute value', [
            //             'id' => $attributeValue->id,
            //             'has_attribute' => $hasAttribute,
            //             'attribute_id' => $attributeValue->attribute_id,
            //             'attribute_data' => $attributeValue->attribute ? $attributeValue->attribute->toArray() : null
            //         ]);
            //         return $hasAttribute;
            //     })
            //     ->map(function ($attributeValue) {
            //         $mapped = [
            //             'id' => $attributeValue->id,
            //             'attribute_id' => $attributeValue->attribute_id,
            //             'attribute_name' => $attributeValue->attribute->type,
            //             'value' => $attributeValue->value,
            //         ];
            //         Log::info('Mapped spec', $mapped);
            //         return $mapped;
            //     })->values()->toArray();

            // // Optional: Include attribute values with missing attributes (uncomment if desired)

            $this->specs = $attributeValues->map(function ($attributeValue) {
                $mapped = [
                    'id' => $attributeValue->id,
                    'attribute_id' => $attributeValue->attribute_id,
                    'attribute_name' => $attributeValue->attribute ? $attributeValue->attribute->type : 'Attribute Missing',
                    'value' => $attributeValue->value,
                ];
                Log::info('Mapped spec (including null attributes)', $mapped);
                return $mapped;
            })->toArray();


            Log::info('Final specs array', [
                'specs_count' => count($this->specs),
                'specs' => $this->specs
            ]);
        } catch (\Exception $e) {
            Log::error('Error loading product specs', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->specs = [];
        }
    }

    public function update()
    {
        try {
            $this->validate($this->getProductRules());

            DB::beginTransaction();

            $this->product->update([
                'name' => $this->name,
                'description' => $this->description,
                'category_id' => $this->category_id,
                'price' => $this->price,
                'stock' => $this->stock,
                'sku' => $this->sku,
                'is_active' => $this->is_active,
            ]);

            if (!empty($this->image_path)) {
                foreach ($this->image_path as $image) {
                    $imagePath = $image->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $this->product->id,
                        'image_path' => $imagePath,
                    ]);
                }
            }

            $this->handleImageDeletions();
            $this->handleSpecifications();

            DB::commit();

            $this->image_path = [];

            session()->flash('success', 'Product "' . $this->product->name . '" updated successfully!');

            return redirect()->to('/admin/products');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Product update failed', [
                'product_id' => $this->product->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            session()->flash('error', 'Failed to update product: ' . $e->getMessage());

            return redirect()->back();
        }
    }

    protected function handleImageDeletions()
    {
        $existingImageIds = collect($this->existing_images)->pluck('id')->toArray();
        $originalImageIds = $this->product->images->pluck('id')->toArray();
        $removedImageIds = array_diff($originalImageIds, $existingImageIds);

        if (!empty($removedImageIds)) {
            $imagesToDelete = ProductImage::whereIn('id', $removedImageIds)->get();
            foreach ($imagesToDelete as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
                $image->delete();
            }
        }
    }

    protected function handleSpecifications()
    {
        $existingSpecIds = collect($this->specs)->pluck('id')->filter()->to lArray();

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
                    'attribute_id' => $spec['attribute_id'],
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
            'newValue'
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
        } else {
            return $bytes . ' bytes';
        }
    }

    public function render()
    {
        Log::info('Rendering ProductEdit component', [
            'specs_count' => count($this->specs),
            'specs' => $this->specs
        ]);

        $categories = Category::orderBy('cat_name')->get();
        return view('livewire.admin.product-edit', [
            'product' => $this->product,
            'category' => $categories,
        ]);
    }
}
