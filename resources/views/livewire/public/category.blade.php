<div>
    <style>
        .grid-auto-fit {
            display: grid;
            grid-template-columns: repeat(auto-fit, 384px);
            gap: 20px;
        }
    </style>
    <h1 class="text-3xl text-black font-semibold">Categories</h1>

    <div class="grid grid-auto-fit gap-[20px] justify-start mt-6">
        @foreach ($category as $cat)
            <div
                class="card cursor-pointer relative bg-transparent w-96 max-w-full mx-auto shadow-sm rounded-xl overflow-hidden group">
                <figure class="w-full h-64 overflow-hidden">
                    <img class="w-full h-full object-cover transform group-hover:scale-110 transition-all duration-500 ease-in-out"
                        src="{{ asset('storage/' . $cat->banner_image) }}" alt="Category" />
                    <!-- Overlay on the image -->
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
        @endforeach
    </div>
</div>
