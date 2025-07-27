<?php

namespace App\Livewire\Public;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Reviews extends Component
{
    use WithPagination, WithoutUrlPagination;


    public Product $product;

    public int $rating = 5;
    public string $comment = '';

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function saveReview()
    {
        $this->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        auth()->user()->reviews()->create([
            'product_id' => $this->product->id,
            'rating'     => $this->rating,
            'comment'    => $this->comment,
        ]);

        $this->reset('rating', 'comment');
        session()->flash('review_saved', 'Thanks for your review!');
    }

    function render()
    {
        return view('livewire.public.reviews', [
            'reviews' => $this->product->reviews()->with('user')->latest()->paginate(10),
        ]);
    }
}
