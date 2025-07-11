<?php

use App\Http\Middleware\AdminMiddleware;
use App\Livewire\Admin\CategoryManagement;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\ProductCreate;
use App\Livewire\Admin\ProductEdit;
use App\Livewire\Admin\ProductIndex;
use App\Livewire\Admin\Profile;
use App\Livewire\Admin\ProductShow;
use App\Livewire\Public\About;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Home
|--------------------------------------------------------------------------
|
| Anyone can see the welcome page. But if an authenticated admin visits "/",
| immediately redirect to admin.dashboard.
|
*/

Route::get('/', function () {
    if (Auth::check() && Auth::user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Authenticated User Dashboard
|--------------------------------------------------------------------------
|
| After login (Jetstream sends users here), we inspect role:
| - Admin → admin.dashboard
| - Regular → user dashboard view
|
*/
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return view('welcome');
        }
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| All /admin/* routes here. Visiting "/admin" also lands on admin.dashboard.
|
*/
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // GET /admin OR /admin/dashboard → Livewire Dashboard component
        Route::get('/', fn() => redirect()->route('admin.dashboard'));
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/profile', Profile::class)->name('profile');
        Route::get('/category', CategoryManagement::class)->name('category');

        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', ProductIndex::class)->name('index');
            Route::get('/create', ProductCreate::class)->name('create');
            Route::get('/{product}/edit', ProductEdit::class)->name('edit');
            Route::get('/{product}', ProductShow::class)->name('show');
        });
    });
/*
|--------------------------------------------------------------------------
| Public Pages (no auth required)
|--------------------------------------------------------------------------
*/
Route::get('/about', About::class)->name('about');
// Route::get('/contact', \App\Http\Livewire\Public\Contact::class)->name('contact');
// Route::get('/privacy-policy', \App\Http\Livewire\Public\PrivacyPolicy::class)
//      ->name('privacy.policy');
// add other static or Livewire‑driven pages here…

/*
|--------------------------------------------------------------------------
| Shopping & Catalog (optional: no auth required)
|--------------------------------------------------------------------------
| If you want browsing products & categories open to guests:
*/
// Route::get('/products',   \App\Http\Livewire\Public\ProductListing::class)
//      ->name('products.listing');
// Route::get('/products/{product}', \App\Http\Livewire\Public\ProductDetail::class)
//      ->name('products.detail');
// Route::get('/categories', \App\Http\Livewire\Public\CategoryListing::class)
//      ->name('categories.listing');
// …and so on…

/*
|--------------------------------------------------------------------------
| User Area (auth protected)
|--------------------------------------------------------------------------
*/
// Route::middleware(['auth', config('jetstream.auth_session')])
//      ->name('user.')
//      ->group(function () {

//     // Dashboard / Account Home
//     Route::get('/account', \App\Http\Livewire\User\Dashboard::class)
//          ->name('dashboard');

//     // Profile settings
//     Route::get('/account/profile', \App\Http\Livewire\User\Profile::class)
//          ->name('profile');

//     // Order history & tracking
//     Route::get('/account/orders',
//                \App\Http\Livewire\User\OrderHistory::class)
//          ->name('orders.history');
//     Route::get('/account/orders/{order}',
//                \App\Http\Livewire\User\OrderDetail::class)
//          ->name('orders.detail');

//     // Wishlist
//     Route::get('/account/wishlist',
//                \App\Http\Livewire\User\Wishlist::class)
//          ->name('wishlist');

//     // Cart & Checkout (you may or may not require auth for cart)
//     Route::get('/cart', \App\Http\Livewire\User\Cart::class)
//          ->name('cart');
//     Route::get('/checkout', \App\Http\Livewire\User\Checkout::class)
//          ->name('checkout');
//     Route::get('/order-confirmation/{order}',
//                \App\Http\Livewire\User\OrderConfirmation::class)
//          ->name('order.confirmation');

    // Any additional protected pages…
// });
