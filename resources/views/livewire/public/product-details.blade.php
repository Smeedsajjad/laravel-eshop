<div>
    <style>
        .thumbSwiper .swiper-slide {
            opacity: 0.6;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .thumbSwiper .swiper-slide:hover {
            opacity: 0.8;
            border-color: rgb(139, 92, 246);
        }

        .thumbSwiper .swiper-slide-thumb-active {
            opacity: 1 !important;
            border-color: rgb(139, 92, 246) !important;
            box-shadow: 0 0 0 1px rgb(139, 92, 246);
        }

        /* Main Swiper Styles */
        .mainSwiper .swiper-slide {
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
        }

        .swiper-slide img {
            user-select: none;
        }

        /* Desktop thumbnail styles */
        @media (min-width: 768px) {
            .thumbSwiper .swiper-slide {
                height: 90px;
                margin-bottom: 8px;
            }
        }

        /* Mobile thumbnail styles */
        @media (max-width: 767px) {
            .thumbSwiper .swiper-slide {
                width: 80px;
                height: 80px;
                margin-right: 8px;
            }
        }

        /* Navigation button styles */
        .swiper-button-next,
        .swiper-button-prev {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin-top: -20px;
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 16px;
            font-weight: bold;
        }

        /* Pagination styles */
        .swiper-pagination-bullet {
            background: rgba(139, 92, 246, 0.5);
        }

        .swiper-pagination-bullet-active {
            background: rgb(139, 92, 246);
        }

        .tabs-lift>.tab:is(input:checked, label:has(:checked)) {
            background-color: white;
            color: rgb(139, 92, 246);
            border-color: gray;
            font-weight: 700;
        }

        .tab:not(:checked, label:has(:checked), :hover, .tab-active, [aria-selected="true"]) {
            font-weight: 700;
            color: black
        }

        @media (hover: hover) {
            .tab:hover {
                color: black;
                font-weight: 700;

            }
        }
    </style>
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 max-w-7xl mx-auto p-4">
        <div class="md:col-span-5">


            <div class="flex gap-4 max-w-5xl mx-auto p-4">

                <div class="max-w-6xl mx-auto p-4">
                    <div class="grid grid-cols-12 gap-4">

                        <div class="col-span-12 md:col-span-2 order-2 md:order-1">
                            <div class="swiper thumbSwiper h-24 md:h-[480px] w-full">
                                <div class="swiper-wrapper">
                                    @foreach ($images as $index => $path)
                                    <div class="swiper-slide flex-shrink-0">
                                        <img src="{{ Storage::url($path) }}"
                                            class="w-full h-full object-cover rounded cursor-pointer transition-all duration-300"
                                            alt="Thumbnail {{ $index + 1 }}"
                                            onerror="this.src='{{ asset('images/no-image.webp') }}'" />
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Main Image --}}
                        <div class="col-span-12 md:col-span-10 order-1 md:order-2">
                            <div
                                class="swiper mainSwiper w-full aspect-square bg-gray-100 rounded-xl overflow-hidden relative">
                                <div class="swiper-wrapper">
                                    @foreach ($images as $index => $path)
                                    <div class="swiper-slide">
                                        <img src="{{ Storage::url($path) }}" class="w-full h-full object-contain"
                                            alt="Product image {{ $index + 1 }}"
                                            onerror="this.src='{{ asset('images/no-image.webp') }}'" />
                                    </div>
                                    @endforeach
                                </div>

                                {{-- Pagination --}}
                                <div class="swiper-pagination !bottom-4"></div>

                                {{-- Image counter --}}
                                <div
                                    class="absolute top-4 right-4 bg-black/60 text-white px-3 py-1 rounded-full text-sm z-10">
                                    <span class="current-slide">1</span> / <span class="total-slides">{{ count($images)
                                        }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>



        </div>

        <div class="md:col-span-7 text-gray-800 space-y-6">
            {{-- Name & price --}}
            <div>
                <h1 class="text-3xl sm:text-4xl font-bold leading-tight">{{ $product->name }}</h1>
                <div class="flex items-center gap-3 mt-2">
                    <p class="text-purple-600 font-bold text-2xl">${{ number_format($product->price, 2) }}</p>
                    @if ($product->compare_at_price)
                    <span class="text-gray-400 line-through">${{ number_format($product->compare_at_price, 2) }}</span>
                    <span class="badge badge-sm bg-red-100 text-red-700 font-semibold">
                        {{ round((($product->compare_at_price - $product->price) / $product->compare_at_price) * 100)
                        }}%
                        OFF
                    </span>
                    @endif
                </div>
            </div>

            {{-- Rating / share / wishlist --}}
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-1 text-sm">
                    <x-heroicon-s-star class="h-5 w-5 text-yellow-400" />
                    <span>{{ number_format($product->reviews_avg_rating ?: 0, 1) }} / 5 ({{ $product->reviews_count }} reviews)</span>
                </div>
                <button class="btn btn-ghost btn-sm btn-circle">
                    <x-heroicon-s-share class="h-5 w-5" />
                </button>
                <button class="btn btn-ghost btn-sm btn-circle">
                    <x-heroicon-s-heart class="h-5 w-5" />
                </button>
            </div>

            {{-- Short description --}}
            <p class="text-sm text-gray-600 leading-relaxed">{{ Str::limit($product->description, 120) }}</p>

            {{-- Quantity & CTA --}}
            <div
                class="flex flex-col sm:flex-row items-start sm:items-center border border-t-gray-300 border-b-gray-300 py-6 gap-4 border-l-0 border-r-0">
                <label class="flex items-center gap-2">
                    <span class="text-sm font-medium">Quantity</span>
                    <input type="number" value="1" min="1"
                        class="input border-2 border-purple-600 bg-white w-20 text-center">
                </label>
                <button class="btn bg-purple-600 font-semibold border-0">Add to Cart</button>
                <button class="btn btn-success">Buy it Now</button>
            </div>

            {{-- Warranty / policy icons --}}
            <div
                class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center text-xs border border-b-gray-300 py-6 !m-0 border-l-0 border-r-0">
                <div class="flex flex-col items-center">
                    <img class="w-8 mb-1" src="{{ asset('images/warranty/no-warranty.webp') }}" alt="">
                    <span>No Warranty</span>
                </div>
                <div class="flex flex-col items-center">
                    <img class="w-8 mb-1" src="{{ asset('images/warranty/cash-on-delivery.webp') }}" alt="">
                    <span>COD Available</span>
                </div>
                <div class="flex flex-col items-center">
                    <img class="w-8 mb-1" src="{{ asset('images/warranty/non-returnable.png') }}" alt="">
                    <span>Non-Returnable</span>
                </div>
                <div class="flex flex-col items-center">
                    <img class="w-8 mb-1" src="{{ asset('images/warranty/cancel.png') }}" alt="">
                    <span>Non-Cancellable</span>
                </div>
            </div>

            {{-- Specifications --}}
            <div>
                <h2 class="text-2xl font-bold mb-4">Specifications</h2>
                <div class="overflow-x-auto rounded-md border border-base-200">
                    <table class="table w-full">
                        <tbody>
                            @forelse($product->attributeValues->groupBy('product_attribute_id') as $attrId => $values)
                            @php
                            $first = $values->first();
                            $type = $first->attribute->type;
                            @endphp
                            <tr>
                                <td class="text-lg font-semibold border border-gray-600">{{ $type }}</td>
                                <td class="border border-gray-600">
                                    {{ $values->pluck('value')->join(', ') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center text-sm text-gray-500">
                                    No specifications provided.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- name of each tab group should be unique -->
    <div class="tabs tabs-lift">
        <input type="radio" name="my_tabs_3" class="tab" aria-label="Description" />
        <div class="tab-content p-6 text-black border-t-gray-300 rounded-none z-10">{{ $product->description }}</div>

        <input type="radio" name="my_tabs_3" class="tab" aria-label="Reviews" checked="checked" />
        <div class="tab-content p-6 text-black border-t-gray-300 rounded-none z-10">
            <livewire:public.reviews :product="$product" />
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let thumbSwiper = null;
            let mainSwiper = null;
            let isInitialized = false;

            function initializeSwiper() {
                // Destroy existing swipers if they exist
                if (thumbSwiper) {
                    thumbSwiper.destroy(true, true);
                }
                if (mainSwiper) {
                    mainSwiper.destroy(true, true);
                }

                // Get current screen size
                const isMobile = window.innerWidth < 768;

                // Initialize thumbnail swiper
                thumbSwiper = new Swiper('.thumbSwiper', {
                    direction: isMobile ? 'horizontal' : 'vertical',
                    spaceBetween: 8,
                    slidesPerView: isMobile ? 'auto' : 5,
                    freeMode: true,
                    watchSlidesProgress: true,
                    slideToClickedSlide: true,
                    grabCursor: true,
                    centeredSlides: false,
                    // Remove breakpoints since we handle it manually
                });

                // Initialize main swiper
                mainSwiper = new Swiper('.mainSwiper', {
                    spaceBetween: 0,
                    grabCursor: true,
                    loop: false,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                        type: 'bullets',
                    },
                    thumbs: {
                        swiper: thumbSwiper,
                    },
                    on: {
                        init: function() {
                            // Set total slides
                            const totalSlidesEl = document.querySelector('.total-slides');
                            if (totalSlidesEl) {
                                totalSlidesEl.textContent = this.slides.length;
                            }
                        },
                        slideChange: function() {
                            // Update counter
                            const currentSlideEl = document.querySelector('.current-slide');
                            if (currentSlideEl) {
                                currentSlideEl.textContent = this.activeIndex + 1;
                            }
                        }
                    }
                });

                isInitialized = true;
            }

            // Initialize on load
            initializeSwiper();

            // Handle resize with debounce
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    const currentIsMobile = window.innerWidth < 768;
                    const previousIsMobile = thumbSwiper && thumbSwiper.params.direction === 'horizontal';

                    // Only reinitialize if screen size category changed
                    if (currentIsMobile !== previousIsMobile) {
                        initializeSwiper();
                    }
                }, 250);
            });

            // Handle Livewire updates (if using Livewire)
            if (typeof Livewire !== 'undefined') {
                Livewire.hook('message.processed', (message, component) => {
                    // Reinitialize swiper after Livewire updates
                    setTimeout(() => {
                        if (document.querySelector('.thumbSwiper')) {
                            initializeSwiper();
                        }
                    }, 100);
                });
            }

            // Handle visibility change (when switching tabs)
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden && isInitialized) {
                    setTimeout(() => {
                        if (thumbSwiper) thumbSwiper.update();
                        if (mainSwiper) mainSwiper.update();
                    }, 100);
                }
            });
        });

        // Additional function for manual reinitialization (useful for Livewire)
        window.reinitializeSwiper = function() {
            const event = new Event('resize');
            window.dispatchEvent(event);
        };
    </script>
</div>
