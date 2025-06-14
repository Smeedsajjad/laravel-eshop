<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Database\QueryException;

class CategoryForm extends Component
{
    use WithFileUploads;

    public string $cat_name = '';
    public $main_image_file;
    public $banner_image_file;
    public $flashMessage;

    protected function rules(): array
    {
        return [
            'cat_name'           => 'required|string|max:255|unique:categories,cat_name',
            'main_image_file'    => 'required|image|max:1024',
            'banner_image_file'  => 'required|image|max:1024',
        ];
    }

    public function save()
    {
        // Validate the input (Livewire automatically handles errors)
        $this->validate();

        // Store the uploaded images
        $mainPath   = $this->main_image_file->store('categories/main', 'public');
        $bannerPath = $this->banner_image_file->store('categories/banner', 'public');

        // Try to create the category, catching duplicate errors
        try {
            Category::create([
                'cat_name'     => $this->cat_name,
                'main_image'   => $mainPath,
                'banner_image' => $bannerPath,
            ]);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) { // Integrity constraint violation (e.g., duplicate entry)
                $this->addError('cat_name', 'A category with this name already exists.');
                return;
            }
            throw $e; // Re-throw other unexpected errors
        }

        // Reset form fields and notify success
        $this->reset(['cat_name', 'main_image_file', 'banner_image_file']);
        $this->dispatch('categoryAdded');
        session()->flash('message', 'Category added successfully!');
    }

    public function render()
    {
        return view('livewire.admin.category-form');
    }
}
