<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class CategoryTable extends Component
{
  use WithPagination, WithoutUrlPagination;

    public string $search        = '';
    public int    $perPage       = 10;
    public string $sortField     = 'cat_name';
    public bool   $sortAscending = true;

    protected $listeners = [
      'categoryAdded' => '$refresh',
    ];

    public function sortBy(string $field)
    {
        if ($this->sortField === $field) {
            $this->sortAscending = !$this->sortAscending;
        } else {
            $this->sortField     = $field;
            $this->sortAscending = true;
        }
    }

    public function render()
    {
        $categories = Category::query()
            ->where('cat_name', 'like', '%'.$this->search.'%')
            ->orderBy($this->sortField, $this->sortAscending ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.category-table', [
            'cat' => $categories,
        ]);
    }
}
