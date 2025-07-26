<div>
    <style>
        .grid-auto-fit {
            display: grid;
            grid-template-columns: repeat(auto-fit, 384px);
            gap: 20px;
        }

        /* Tailwind overrides */
        span.relative.inline-flex.items-center.px-2.py-2.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.cursor-default.rounded-l-md.leading-5.dark\:bg-gray-800.dark\:border-gray-600,
        span.relative.inline-flex.items-center.px-4.py-2.-ml-px.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.cursor-default.leading-5.dark\:bg-gray-800.dark\:border-gray-600,
        button.relative.inline-flex.items-center.px-2.py-2.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.rounded-l-md.leading-5.hover\:text-gray-400.focus\:z-10.focus\:outline-none.focus\:border-blue-300.focus\:ring.ring-blue-300.active\:bg-gray-100.active\:text-gray-500.transition.ease-in-out.duration-150.dark\:bg-gray-800.dark\:border-gray-600.dark\:active\:bg-gray-700.dark\:focus\:border-blue-800,
        span.relative.inline-flex.items-center.px-2.py-2.-ml-px.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.cursor-default.rounded-r-md.leading-5.dark\:bg-gray-800.dark\:border-gray-600 {
            background-color: rgb(119, 32, 182);
        }

        button.relative.inline-flex.items-center.px-4.py-2.-ml-px.text-sm.font-medium.text-gray-700.bg-white.border.border-gray-300.leading-5.hover\:text-gray-500.focus\:z-10.focus\:outline-none.focus\:border-blue-300.focus\:ring.ring-blue-300.active\:bg-gray-100.active\:text-gray-700.transition.ease-in-out.duration-150.dark\:bg-gray-800.dark\:border-gray-600.dark\:text-gray-400.dark\:hover\:text-gray-300.dark\:active\:bg-gray-700.dark\:focus\:border-blue-800,
        button.relative.inline-flex.items-center.px-2.py-2.-ml-px.text-sm.font-medium.text-gray-500.bg-white.border.border-gray-300.rounded-r-md.leading-5.hover\:text-gray-400.focus\:z-10.focus\:outline-none.focus\:border-blue-300.focus\:ring.ring-blue-300.active\:bg-gray-100.active\:text-gray-500.transition.ease-in-out.duration-150.dark\:bg-gray-800.dark\:border-gray-600.dark\:active\:bg-gray-700.dark\:focus\:border-blue-800,
        [type='checkbox']:checked:hover,
        [type='checkbox']:checked:focus,
        [type='radio']:checked:hover,
        [type='radio']:checked:focus {
            background-color: #9333ea;
        }
    </style>

    <h1 class="text-3xl text-black font-semibold">Categories</h1>

    {{-- Loading Skeleton --}}
    <div wire:loading.delay.longest class="flex gap-6 overflow-x-auto scrollbar-hide mt-6 px-2">
        @for ($i = 0; $i < 6; $i++) <div
            class="card bg-white rounded-lg overflow-hidden relative shadow-sm min-w-[250px] flex-shrink-0">
            <figure class="h-48">
                <div class="skeleton h-full w-full"></div>
            </figure>
            <div class="card-body py-4 px-4">
                <div class="skeleton h-6 w-3/4 mb-2"></div>
                <div class="skeleton h-5 w-20 mb-4"></div>
                <div class="skeleton h-4 w-full mb-2"></div>
                <div class="skeleton h-4 w-2/3 mb-4"></div>
                <div class="skeleton h-8 w-full rounded-btn"></div>
            </div>
    </div>
    @endfor
</div>



{{-- Actual Categories --}}
<div wire:loading.remove>
    <div class="grid grid-auto-fit gap-[20px] justify-start mt-6">
        @forelse ($category as $cat)
          <a wire:navigate href="{{ route('category.products', $cat->slug) }}">

        <div
            class="card cursor-pointer relative bg-transparent w-96 max-w-full mx-auto shadow-sm rounded-xl overflow-hidden group">
            <figure class="w-full h-64 overflow-hidden">
                <img class="w-full h-full object-cover transform group-hover:scale-110 transition-all duration-500 ease-in-out"
                    src="{{ asset('storage/' . $cat->banner_image) }}" alt="Category" />
                <div class="absolute inset-0 rounded-xl"
                    style="background: linear-gradient(0deg, rgb(0,0,0) 0%, rgb(4,4,4) 2%, rgba(255,255,255,0) 50%);">
                </div>
            </figure>
            <div class="absolute bottom-0 left-0 w-full flex flex-col items-start">
                <h2
                    class="text-white p-5 text-2xl font-semibold transform transition-all duration-500 ease-in-out -mb-20 group-hover:-mb-6">
                    {{ $cat->cat_name }}
                </h2>
                <div
                    class="w-full p-5 transform translate-y-full group-hover:translate-y-0 transition-all duration-500 ease-in-out rounded-b-xl flex justify-start">
                    <button class="btn bg-purple-600 border-0 p-5">Explore</button>
                </div>
            </div>
        </div>
        </a>
        @empty
        <div class="flex flex-col items-center justify-center text-center col-span-full py-16">
            <svg class="w-20 h-20 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <h3 class="text-xl font-semibold text-gray-500 mb-2">No categories found</h3>
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8 border-t border-gray-200 pt-6">
        {{ $category->links() }}
    </div>
</div>
</div>
