<div class="flex flex-col md:flex-row gap-6 w-full">
    {{-- reviews list --}}
    <div class="w-full md:w-3/5">
        <div class="card shadow">
            <div class="card-body">
                <h2 class="card-title">Reviews ({{ $reviews->total() }})</h2>
                    <span>{{ number_format($product->reviews_avg_rating ?: 0, 1) }} / 5 ({{ $product->reviews_count }} reviews)</span>

                @forelse($reviews as $review)
                    <div class="border-b last:border-0 py-4">
                        <div class="flex items-center justify-between">
                            <span class="font-bold">{{ $review->user->name }}</span>
                            <div class="rating rating-sm">
                                @for($i = 1; $i <= 5; $i++)
                                    <input type="radio" name="dummy{{ $review->id }}" class="mask mask-star-2 bg-orange-400"
                                           {{ $i <= $review->rating ? 'checked' : 'disabled' }} />
                                @endfor
                            </div>
                        </div>
                        <p class="text-sm mt-1">{{ $review->comment ?? '—' }}</p>
                        <p class="text-xs text-gray-400 mt-2">{{ $review->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No reviews yet.</p>
                @endforelse

                {{ $reviews->links() }}
            </div>
        </div>
    </div>

    {{-- review form --}}
    <div class="w-full md:w-2/5">
        <div class="card shadow">
            <div class="card-body">
                <h2 class="card-title">Write a review</h2>

                @guest
                    <p class="text-sm text-gray-500">
                        <a href="{{ route('login') }}" class="link link-primary">Log in</a> to leave a review.
                    </p>
                @else
                    @php
                        $existing = auth()->user()->reviews()->where('product_id', $product->id)->first();
                    @endphp

                    @if($existing)
                        <div class="alert alert-success">
                            <span>You already reviewed this product.</span>
                        </div>
                    @else
                        <form wire:submit="saveReview" class="space-y-4">
                            {{-- Rating --}}
                            <div>
                                <label class="label">Rating</label>
                                <div class="rating rating-lg">
                                    @for($i = 1; $i <= 5; $i++)
                                        <input type="radio" name="rating" value="{{ $i }}" class="mask mask-star-2 bg-orange-400"
                                               wire:model="rating" />
                                    @endfor
                                </div>
                            </div>

                            {{-- Comment --}}
                            <div>
                                <label class="label">Comment:</label>
                                <textarea wire:model="comment" rows="3" class="textarea textarea-bordered border-2 border-purple-600 bg-white w-full"
                                          placeholder="Optional…"></textarea>
                            </div>

                            <button type="submit" class="btn bg-purple-600 font-semibold border-0 btn-sm">
                                Submit review
                            </button>

                            @if(session()->has('review_saved'))
                                <span class="text-green-600 text-sm">{{ session('review_saved') }}</span>
                            @endif
                        </form>
                    @endif
                @endguest
            </div>
        </div>
    </div>
</div>
