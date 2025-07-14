<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16 text-gray-900">
    <!-- Hero -->
    <section class="text-center py-20 bg-gray-50 rounded-lg">
        <h1 class="text-5xl font-bold">Welcome to ShopEase</h1>
        <p class="mt-4 text-lg text-gray-700">Your one‑stop online marketplace...</p>
        <a href="{{ route('home') }}" class="mt-8 btn border-0 shadow-md bg-purple-600 align-middle">Shop Now</a>
    </section>

    <!-- Our Story -->
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
        <img src="{{ asset('images/Untitled_2.png') }}" alt="Our story" class="rounded-lg md:w-full shadow-lg" />
        <div>
            <h2 class="text-3xl font-semibold">Our Story</h2>
            <p class="mt-4 text-gray-700">Founded in 2023 by lifelong shoppers and tech lovers, ShopEase was born
                from a simple frustration: too many clicks, not enough curated finds. We set out to build an
                intuitive marketplace where you discover top brands, small artisans, and daily essentials all in one
                place—no noise, just quality and great deals.
            </p>
            <a href="{{ route('home') }}" class="mt-6 inline-block text-purple-600 hover:underline">Learn More →</a>
        </div>
    </section>

    <!-- Core Values -->
    <section>
        <h2 class="text-3xl font-semibold text-center">Our Values</h2>
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="text-center space-y-3">
                <div class="mx-auto w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                    <img class="w-full h-full rounded-full" src="{{ asset('images/Untitled_3.png') }}" alt="">
                </div>
                <h3 class="font-semibold">Quality First</h3>
                <p class="text-gray-600">We hand‑pick every item.</p>
            </div>
            <div class="text-center space-y-3">
                <div class="mx-auto w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                    <img class="w-full h-full rounded-full" src="{{ asset('images/Untitled_4.png') }}" alt="">
                </div>
                <h3 class="font-semibold">Integrity</h3>
                <p class="text-gray-600">Transparent pricing, honest policies, and no hidden fees.</p>
            </div>
            <div class="text-center space-y-3">
                <div class="mx-auto w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                    <img class="w-full h-full rounded-full" src="{{ asset('images/Untitled_5.png') }}" alt="">
                </div>
                <h3 class="font-semibold">Customer Commitment</h3>
                <p class="text-gray-600">Your satisfaction drives us. 24/7 support and easy returns.</p>
            </div>
            <div class="text-center space-y-3">
                <div class="mx-auto w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                    <img class="w-full h-full rounded-full" src="{{ asset('images/Untitled_6.png') }}" alt="">
                </div>
                <h3 class="font-semibold">Innovation</h3>
                <p class="text-gray-600">We support eco‑friendly brands and reduce packaging waste where possible.
                </p>
            </div>
        </div>
    </section>

    <!-- Team -->
    <section>
        <h2 class="text-3xl font-semibold text-center mb-8">Meet the Team</h2>
        <div class="flex flex-wrap gap-6 justify-center px-4">
            <div class="text-center w-full sm:w-1/2 lg:w-1/4 max-w-xs">
                <img src="{{ asset('images/team/1.jpeg') }}" alt="Jane Doe"
                    class="w-32 h-32 object-cover rounded-full mx-auto" />
                <h4 class="mt-4 font-semibold">Jane Doe</h4>
                <p class="text-gray-500">CEO</p>
            </div>
            <div class="text-center w-full sm:w-1/2 lg:w-1/4 max-w-xs">
                <img src="{{ asset('images/team/2.jpg') }}" alt="John Smith"
                    class="w-32 h-32 object-cover rounded-full mx-auto" />
                <h4 class="mt-4 font-semibold">John Smith</h4>
                <p class="text-gray-500">CTO</p>
            </div>
            <div class="text-center w-full sm:w-1/2 lg:w-1/4 max-w-xs">
                <img src="{{ asset('images/team/3.jpg') }}" alt="Emily Carter"
                    class="w-32 h-32 object-cover rounded-full mx-auto" />
                <h4 class="mt-4 font-semibold">Emily Carter</h4>
                <p class="text-gray-500">Head of Customer Experience</p>
            </div>
            <div class="text-center w-full sm:w-1/2 lg:w-1/4 max-w-xs">
                <img src="{{ asset('images/team/4.jpeg') }}" alt="Michael Chen"
                    class="w-32 h-32 object-cover rounded-full mx-auto" />
                <h4 class="mt-4 font-semibold">Michael Chen</h4>
                <p class="text-gray-500">Lead Product Designer</p>
            </div>
            <div class="text-center w-full sm:w-1/2 lg:w-1/4 max-w-xs">
                <img src="{{ asset('images/team/5.jpg') }}" alt="Sara Ahmed"
                    class="w-32 h-32 object-cover rounded-full mx-auto" />
                <h4 class="mt-4 font-semibold">Sara Ahmed</h4>
                <p class="text-gray-500">Marketing Director</p>
            </div>
            <div class="text-center w-full sm:w-1/2 lg:w-1/4 max-w-xs">
                <img src="{{ asset('images/team/6.jpg') }}" alt="Daniel Lee"
                    class="w-32 h-32 object-cover rounded-full mx-auto" />
                <h4 class="mt-4 font-semibold">Daniel Lee</h4>
                <p class="text-gray-500">Logistics Manager</p>
            </div>
        </div>

    </section>

    <!-- Timeline -->
    <section>
        <h2 class="text-3xl font-semibold text-center mb-8">Our Journey</h2>
        <div class="relative">
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-full h-0.5 bg-gray-200"></div>
            </div>
            <div class="relative grid grid-cols-3 gap-8 text-center">
                <div><span class="text-purple-600">2023</span>
                    <p class="mt-2">Launched MVP</p>
                </div>
                <div><span class="text-purple-600">2024</span>
                    <p class="mt-2">10K users</p>
                </div>
                <div><span class="text-purple-600">2025</span>
                    <p class="mt-2">Global expansion</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="text-center py-16 bg-purple-50 rounded-lg">
        <h2 class="text-3xl font-semibold">Ready to discover something great?</h2>
        <a href="{{ route('home') }}" class="mt-6 btn border-0 bg-purple-600">Shop Now</a>
    </section>

</div>
