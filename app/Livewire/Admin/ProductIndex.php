<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class ProductIndex extends Component
{
    use WithPagination, WithoutUrlPagination;

    #[Layout('layouts.admin')]

    public $search = '';
    public $perPage = 10;
    public $sortBy = 'id';
    public $sortDirection = 'asc';

    // Delete confirmation
    public $deletingProduct = null;
    public $deletingProductName = '';

    // Filter properties
    public $filterCategory = '';
    public $filterStatus = '';
    public $filterStock = '';

    // Image gallery modal properties
    public $showImageModal = false;
    public $currentProduct = null; // Store the entire product object
    public $currentImages = [];
    public $currentImageIndex = 0;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortBy' => ['except' => 'id'],
        'sortDirection' => ['except' => 'desc'],
        'filterCategory' => ['except' => ''],
        'filterStatus' => ['except' => ''],
        'filterStock' => ['except' => ''],
    ];

    protected $rules = [
        'editName' => 'required|string|max:255',
        'editStock' => 'required|integer|min:0',
        'editPrice' => 'required|numeric|min:0',
        'editCategoryId' => 'required|exists:categories,id',
        'editDescription' => 'nullable|string|max:1000',
    ];

    public function mount()
    {
        $this->perPage = 10;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function prepareDelete($productId, $productName)
    {
        $this->deletingProduct = $productId;
        $this->deletingProductName = $productName;
    }

    public function confirmDelete()
    {
        try {
            $product = Product::findOrFail($this->deletingProduct);

            // Delete associated images
            if ($product->images) {
                $images = json_decode($product->images, true);
                if (is_array($images)) {
                    foreach ($images as $image) {
                        if (Storage::disk('public')->exists($image)) {
                            Storage::disk('public')->delete($image);
                        }
                    }
                }
            }

            $productName = $product->name;
            $product->delete();

            $this->dispatch('product-deleted', [
                'message' => "Product '{$productName}' deleted successfully!",
                'product' => $productName
            ]);

            $this->resetDeleteForm();
        } catch (\Exception $e) {
            $this->dispatch('product-error', [
                'message' => 'Error deleting product: ' . $e->getMessage()
            ]);
        }
    }

    public function toggleStatus($productId)
    {
        try {
            $product = Product::findOrFail($productId);
            $product->update(['is_active' => !$product->is_active]);

            $status = $product->is_active ? 'activated' : 'deactivated';

            $this->dispatch('product-status-changed', [
                'message' => "Product '{$product->name}' {$status}!",
                'product' => $product->name,
                'status' => $status
            ]);
        } catch (\Exception $e) {
            $this->dispatch('product-error', [
                'message' => 'Error updating product status: ' . $e->getMessage()
            ]);
        }
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->filterCategory = '';
        $this->filterStatus = '';
        $this->filterStock = '';
        $this->resetPage();
    }

    public function resetDeleteForm()
    {
        $this->deletingProduct = null;
        $this->deletingProductName = '';
    }

    // Image gallery methods
    public function openImageGallery($productId)
    {
        // Find the product in the already loaded products to avoid DB query
        $product = $this->products->firstWhere('id', $productId);

        if (!$product) {
            // Fallback if product not found in current page
            $product = Product::with('images')->find($productId);
        }

        if ($product) {
            $this->currentProduct = $product;
            $this->currentImages = $this->getAllProductImages($product);
            $this->currentImageIndex = 0;
            $this->showImageModal = true;
        }
    }

    public function closeImageGallery()
    {
        $this->showImageModal = false;
        $this->currentProduct = null;
        $this->currentImages = [];
        $this->currentImageIndex = 0;
    }

    public function nextImage()
    {
        if (!empty($this->currentImages)) {
            if ($this->currentImageIndex < count($this->currentImages) - 1) {
                $this->currentImageIndex++;
            } else {
                $this->currentImageIndex = 0; // Loop to first image
            }
        }
    }

    public function previousImage()
    {
        if (!empty($this->currentImages)) {
            if ($this->currentImageIndex > 0) {
                $this->currentImageIndex--;
            } else {
                $this->currentImageIndex = count($this->currentImages) - 1; // Loop to last image
            }
        }
    }

    public function goToImage($index)
    {
        if ($index >= 0 && $index < count($this->currentImages)) {
            $this->currentImageIndex = $index;
        }
    }

    public function getAllProductImages($product)
    {
        $images = [];

        // Check if product has images relationship
        if ($product->images && $product->images->isNotEmpty()) {
            foreach ($product->images as $imageRecord) {
                $imagePath = $imageRecord->image_path;

                if (is_array($imagePath)) {
                    $images = array_merge($images, $imagePath);
                } elseif (is_string($imagePath) && !empty($imagePath)) {
                    // Try to decode JSON
                    $decoded = json_decode($imagePath, true);
                    if ($decoded !== null && is_array($decoded)) {
                        $images = array_merge($images, $decoded);
                    } else {
                        $images[] = $imagePath;
                    }
                }
            }
        }

        // Fallback: check if product has direct images column
        if (empty($images) && isset($product->images_column)) {
            $productImages = json_decode($product->images_column, true);
            if (is_array($productImages)) {
                $images = $productImages;
            }
        }

        // Filter out empty values and ensure unique images
        return array_values(array_unique(array_filter($images)));
    }

    public function getCurrentImage()
    {
        if (!empty($this->currentImages) && isset($this->currentImages[$this->currentImageIndex])) {
            return $this->currentImages[$this->currentImageIndex];
        }
        return null;
    }

    public function getCurrentImageCount()
    {
        return count($this->currentImages);
    }

    public function getProductsProperty()
    {
        $query = Product::with(['category','images'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhereHas('category', function ($categoryQuery) {
                            $categoryQuery->where('cat_name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->filterCategory, function ($query) {
                $query->where('category_id', $this->filterCategory);
            })
            ->when($this->filterStatus !== '', function ($query) {
                $query->where('is_active', $this->filterStatus);
            })
            ->when($this->filterStock, function ($query) {
                switch ($this->filterStock) {
                    case 'in_stock':
                        $query->where('stock', '>', 0);
                        break;
                    case 'out_of_stock':
                        $query->where('stock', 0);
                        break;
                    case 'low_stock':
                        $query->where('stock', '>', 0)->where('stock', '<=', 10);
                        break;
                }
            })
            ->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    public function getCategoriesProperty()
    {
        return Category::orderBy('cat_name')->get();
    }

    public function formatPrice($price)
    {
        return '$' . number_format($price, 2);
    }

    public function getStockStatus($stock)
    {
        if ($stock <= 0) {
            return ['status' => 'Out of Stock', 'class' => 'text-red-500'];
        } elseif ($stock <= 10) {
            return ['status' => 'Low Stock', 'class' => 'text-yellow-500'];
        } else {
            return ['status' => 'In Stock', 'class' => 'text-green-500'];
        }
    }

    public function getFirstImage($images)
    {
        if ($images->isEmpty()) {
            return null;
        }

        $imagePath = $images->first()->image_path;

        if (is_array($imagePath)) {
            return $imagePath[0] ?? null;
        }

        if (is_string($imagePath) && !empty($imagePath)) {
            if (json_decode($imagePath, true) !== null) {
                $decoded = json_decode($imagePath, true);
                return is_array($decoded) ? ($decoded[0] ?? null) : null;
            }
            return $imagePath;
        }

        return null;
    }

    public function getImageCount($product)
    {
        return count($this->getAllProductImages($product));
    }

    public function render()
    {
        return view('livewire.admin.product-index', [
            'products' => $this->products,
            'categories' => $this->categories,
        ]);
    }
}
