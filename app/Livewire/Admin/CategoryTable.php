<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class CategoryTable extends Component
{
    use WithPagination, WithoutUrlPagination, WithFileUploads;

    public string $search = '';
    public int $perPage = 10;
    public string $sortField = 'cat_name';
    public bool $sortAscending = true;

    // Edit modal properties
    public $editingCategoryId = null;
    public $editCatName = '';

    // Image editing properties
    public $editMainImage = null;
    public $editBannerImage = null;
    public $currentMainImage = '';
    public $currentBannerImage = '';

    // Delete confirmation properties
    public $deletingCategoryId = null;
    public $deletingCategoryName = '';

    protected $listeners = [
        'categoryAdded' => '$refresh',
    ];

    protected function rules()
    {
        return [
            'editCatName' => 'required|string|max:255',
            'editMainImage' => 'nullable|image|max:1024',
            'editBannerImage' => 'nullable|image|max:1024',
        ];
    }

    public function edit($categoryId)
    {
        $category = Category::findOrFail($categoryId);

        $this->editingCategoryId = $categoryId;
        $this->editCatName = $category->cat_name;

        // Store current images for preview
        $this->currentMainImage = $category->main_image;
        $this->currentBannerImage = $category->banner_image;

        // Reset file inputs
        $this->editMainImage = null;
        $this->editBannerImage = null;

        $this->dispatch('open-edit-modal');
    }

    public function updateCategory()
    {
        $this->validate();

        $category = Category::findOrFail($this->editingCategoryId);

        // Update basic info
        $category->cat_name = $this->editCatName;

        // Handle main image update
        if ($this->editMainImage) {
            // Delete old image if it exists
            if ($category->main_image && Storage::disk('public')->exists($category->main_image)) {
                Storage::disk('public')->delete($category->main_image);
            }

            // Store new image
            $category->main_image = $this->editMainImage->store('categories', 'public');
        }

        // Handle banner image update
        if ($this->editBannerImage) {
            // Delete old image if it exists
            if ($category->banner_image && Storage::disk('public')->exists($category->banner_image)) {
                Storage::disk('public')->delete($category->banner_image);
            }

            // Store new image
            $category->banner_image = $this->editBannerImage->store('categories', 'public');
        }

        $category->save();

        $this->resetEditForm();
        $this->dispatch('close-edit-modal');
        session()->flash('message', 'Category updated successfully!');
    }

    public function cancelEdit()
    {
        $this->resetEditForm();
        $this->dispatch('close-edit-modal');
    }

    private function resetEditForm()
    {
        $this->editingCategoryId = null;
        $this->editCatName = '';

        // Reset image properties
        $this->editMainImage = null;
        $this->editBannerImage = null;
        $this->currentMainImage = '';
        $this->currentBannerImage = '';

        $this->resetValidation();
    }

    // Delete confirmation methods
    public function prepareDelete($categoryId, $categoryName)
    {
        $this->deletingCategoryId = $categoryId;
        $this->deletingCategoryName = $categoryName;

        $this->dispatch('open-delete-modal', [
            'categoryName' => $categoryName
        ]);
    }

    public function confirmDelete()
    {
        if (!$this->deletingCategoryId) {
            return;
        }

        $category = Category::findOrFail($this->deletingCategoryId);

        // Delete associated images
        if ($category->main_image && Storage::disk('public')->exists($category->main_image)) {
            Storage::disk('public')->delete($category->main_image);
        }

        if ($category->banner_image && Storage::disk('public')->exists($category->banner_image)) {
            Storage::disk('public')->delete($category->banner_image);
        }

        $category->delete();

        $this->resetDeleteForm();
        $this->dispatch('close-delete-modal');
        session()->flash('message', 'Category deleted successfully!');
    }

    public function cancelDelete()
    {
        $this->resetDeleteForm();
        $this->dispatch('close-delete-modal');
    }

    private function resetDeleteForm()
    {
        $this->deletingCategoryId = null;
        $this->deletingCategoryName = '';
    }

    // Keep the old delete method for backward compatibility, but it now uses the confirmation modal
    public function delete($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $this->prepareDelete($categoryId, $category->cat_name);
    }

    public function sortBy(string $field)
    {
        if ($this->sortField === $field) {
            $this->sortAscending = !$this->sortAscending;
        } else {
            $this->sortField = $field;
            $this->sortAscending = true;
        }
    }

    // Handle file input changes to prevent unnecessary re-renders
    public function updatedEditMainImage()
    {
        $this->validateOnly('editMainImage');
    }

    public function updatedEditBannerImage()
    {
        $this->validateOnly('editBannerImage');
    }

    public function render()
    {
        $categories = Category::query()
            ->where('cat_name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortAscending ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.category-table', [
            'cat' => $categories,
        ]);
    }
}
