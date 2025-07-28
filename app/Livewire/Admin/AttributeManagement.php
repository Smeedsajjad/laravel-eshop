<?php

namespace App\Livewire\Admin;

use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class AttributeManagement extends Component
{
    use WithPagination, WithoutUrlPagination;

    #[Layout('layouts.admin')]

    public $showCreateModal = false;
    public $showEditModal = false;
    public $confirmDeleteModal = false;
    public $toDeleteId = null;
    public $attributeId;
    public $type = '';
    public $is_filterable = false;
    public $showValuesPanel = false;
    public $valuesAttribute;
    public string $search = '';
    public int $perPage = 10;

    // Values management
    public $valueId = null;
    public $valueText = '';

    protected function rules()
    {
        return [
            'type' => 'required|string|max:255',
            'is_filterable' => 'boolean',
        ];
    }

    protected function valueRules()
    {
        return [
            'valueText' => 'required|string|max:255'
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function openCreateModal()
    {
        $this->resetErrorBag();
        $this->reset(['attributeId', 'type', 'is_filterable']);
        $this->is_filterable = false; // Explicitly set default
        $this->showCreateModal = true;
    }

    public function storeAttr()
    {
        $this->validate($this->rules());

        try {
            ProductAttribute::create([
                'type' => $this->type,
                'is_filterable' => $this->is_filterable,
            ]);

            session()->flash('success', 'Attribute created successfully!');
            $this->closeCreateModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create attribute. Please try again.');
        }
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
        $this->reset(['type', 'is_filterable', 'attributeId']);
        $this->resetErrorBag();
    }

    public function toggleAttr($attributeId)
    {
        try {
            $attr = ProductAttribute::findOrFail($attributeId);
            $attr->update([
                'is_filterable' => !$attr->is_filterable
            ]);

            session()->flash('success', 'Filterable status updated.');
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong while updating filterable status.');
        }
    }

    public function editAttr($id)
    {
        $this->resetErrorBag();

        try {
            $attr = ProductAttribute::findOrFail($id);
            $this->attributeId = $attr->id;
            $this->type = $attr->type;
            $this->is_filterable = $attr->is_filterable;
            $this->showEditModal = true;
        } catch (\Exception $e) {
            session()->flash('error', 'Attribute not found.');
        }
    }

    public function updateAttr()
    {
        $this->validate($this->rules());

        try {
            ProductAttribute::findOrFail($this->attributeId)
                ->update([
                    'type' => $this->type,
                    'is_filterable' => $this->is_filterable
                ]);

            session()->flash('success', 'Attribute updated successfully!');
            $this->closeEditModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update attribute. Please try again.');
        }
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->reset(['attributeId', 'type', 'is_filterable']);
        $this->resetErrorBag();
    }

    public function confirmDelete($id)
    {
        $this->toDeleteId = $id;
        $this->confirmDeleteModal = true;
    }

    public function deleteAttr()
    {
        try {
            ProductAttribute::findOrFail($this->toDeleteId)->delete();
            session()->flash('success', 'Attribute deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete attribute.');
        }

        $this->reset(['confirmDeleteModal', 'toDeleteId']);
    }

    public function manageValues(ProductAttribute $attribute)
    {
        $this->valuesAttribute = $attribute;
        $this->showValuesPanel = true;
    }

    public function closeValuesPanel()
    {
        $this->reset(['showValuesPanel', 'valuesAttribute', 'valueId', 'valueText']);
    }

    public function saveValue()
    {
        $this->validate($this->valueRules());

        try {
            if ($this->valueId) {
                // Update existing value
                $value = ProductAttributeValue::findOrFail($this->valueId);
                $value->update(['value' => $this->valueText]);
                session()->flash('success', 'Value updated successfully!');
            } else {
                // Create new value
                ProductAttributeValue::create([
                    'product_attribute_id' => $this->valuesAttribute->id,
                    'product_id' => null,
                    'value' => $this->valueText
                ]);
                session()->flash('success', 'Value added successfully!');
            }

            $this->resetValueForm();
            // Refresh the values attribute to show updated data
            $this->valuesAttribute = $this->valuesAttribute->fresh(['values']);
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save value. Please try again.');
        }
    }

    public function editValue($valueId)
    {
        try {
            $value = ProductAttributeValue::findOrFail($valueId);
            $this->valueId = $value->id;
            $this->valueText = $value->value;
        } catch (\Exception $e) {
            session()->flash('error', 'Value not found.');
        }
    }

    public function resetValueForm()
    {
        $this->reset(['valueId', 'valueText']);
        $this->resetErrorBag(['valueText']);
    }

    public function deleteValue($valueId)
    {
        try {
            ProductAttributeValue::findOrFail($valueId)->delete();
            session()->flash('success', 'Value deleted successfully.');
            // Refresh the values attribute
            $this->valuesAttribute = $this->valuesAttribute->fresh(['values']);
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete value.');
        }
    }

    public function render()
    {
        $attributes = ProductAttribute::with(['values'])
            ->when(
                $this->search,
                fn($q) => $q->where('type', 'like', "%{$this->search}%")
            )
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.attribute-management', compact('attributes'));
    }
}
