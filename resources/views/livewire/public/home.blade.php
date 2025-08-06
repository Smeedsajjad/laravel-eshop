<div>
    <!-- Swiper -->
    @include('components.public.swiper')

    <div class="px-4 py-8 max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-black">Categories</h2>
            <a href="{{ route('category') }}" wire:navigate
                class="bg-purple-200 text-purple-800 px-4 py-2 rounded hover:bg-purple-300">
                View More
            </a>
        </div>

        <div class="container mx-auto px-4 mt-8">
            <div class="flex flex-wrap justify-center gap-6">
                @foreach ($categories as $category)
                    <a href="{{ route('products', $category->slug) }}"
                        class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 max-w-xs rounded-lg shadow overflow-hidden text-center bg-white transition transform hover:scale-105">
                        <div class="h-40 bg-gray-100 flex items-center justify-center">
                            <img src="{{ asset('storage/' . $category->main_image) }}" alt="{{ $category->cat_name }}"
                                class="max-h-full max-w-full object-contain">
                        </div>
                        <div class="p-3">
                            <span class="block text-black font-medium">{{ $category->cat_name }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>



    </div>


</div>
