<?php

namespace App\Livewire\Admin;

use App\Models\Review;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Reviews extends Component
{
    use WithPagination, WithoutUrlPagination;

    #[Layout('layouts.admin')]

    public $search = '';
    public $filterRating = '';
    public $confirmingDelete = false;
    public $toDelete = null;

    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedFilterRating()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->toDelete = $id;
        $this->confirmingDelete = true;
    }

    public function delete()
    {
        Review::findOrFail($this->toDelete)->delete();

        // reset both modal flag and the id
        $this->confirmingDelete = false;
        $this->toDelete = null;

        session()->flash('message', 'Review deleted.');
    }


    public function render()
    {
        $reviews = Review::with(['product:id,name', 'user:id,name'])
            ->when(
                $this->search,
                fn($q) =>
                $q->where(function ($q2) {
                    $q2->where('comment', 'like', "%{$this->search}%")
                        ->orWhereHas(
                            'product',
                            fn($q3) =>
                            $q3->where('name', 'like', "%{$this->search}%")
                        );
                })
            )
            ->when(
                $this->filterRating,
                fn($q) =>
                $q->where('rating', $this->filterRating)
            )
            ->latest()
            ->paginate(15);

        $stats = [
            'total'   => Review::count(),
            'average' => round(Review::avg('rating'), 1),
        ];

        return view('livewire.admin.reviews', compact('reviews', 'stats'));
    }
}
