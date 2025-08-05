<?php

use App\Http\Middleware\AdminMiddleware;
use App\Livewire\Admin\AttributeManagement;
use App\Livewire\Admin\CategoryManagement;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\ProductCreate;
use App\Livewire\Admin\ProductEdit;
use App\Livewire\Admin\ProductIndex;
use App\Livewire\Admin\Profile;
use App\Livewire\Admin\ProductShow;
use App\Livewire\Admin\Reviews;
use App\Livewire\CheckoutPage;
use App\Livewire\Public\About;
use App\Livewire\Public\Category;
use App\Livewire\Public\Contact;
use App\Livewire\Public\Home;
use App\Livewire\Public\OrderManagement\Cart;
use App\Livewire\Public\OrderManagement\CheckoutAddress;
use App\Livewire\Public\OrderManagement\CheckoutPage as OrderManagementCheckoutPage;
use App\Livewire\Public\PrivacyPolicy;
use App\Livewire\Public\ProductDetails;
use App\Livewire\Public\ProductsList;
use App\Livewire\Public\ReturnPolicy;
use App\Livewire\Public\ShippingPolicy;
use App\Livewire\Public\TermsCondition;
use App\Livewire\Public\Wishlist;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (No Authentication Required)
|--------------------------------------------------------------------------
*/

Route::get('/', Home::class)->name('home');
Route::get('/about', About::class)->name('about');
Route::get('/contact', Contact::class)->name('contact');
Route::get('/privacy-policy', PrivacyPolicy::class)->name('privacy-policy');
Route::get('/return-policy', ReturnPolicy::class)->name('return-policy');
Route::get('/shipping-policy', ShippingPolicy::class)->name('shipping-policy');
Route::get('/terms-condition', TermsCondition::class)->name('terms-and-conditions');

/*
|--------------------------------------------------------------------------
| Admin Routes (Authentication and Admin Role Required)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', fn() => redirect()->route('admin.dashboard'));
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/profile', Profile::class)->name('profile');
        Route::get('/category', CategoryManagement::class)->name('category');
        Route::get('/reviews', Reviews::class)->name('reviews');
        Route::get('/attributes', AttributeManagement::class)->name('attributes');

        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', ProductIndex::class)->name('index');
            Route::get('/create', ProductCreate::class)->name('create');
            Route::get('/{product}/edit', ProductEdit::class)->name('edit');
            Route::get('/{product}', ProductShow::class)->name('show');
        });
    });

/*
|--------------------------------------------------------------------------
| Shopping & Catalog (optional: no auth required)
|--------------------------------------------------------------------------
| If you want browsing products & categories open to guests:
*/
Route::get('/category', Category::class)->name('category');
Route::get('/category/{slug}', ProductsList::class)->name('category.products');
Route::get('/products', ProductsList::class)->name('products');
Route::get('/products/{product:slug}', ProductDetails::class)->name('product.details');
/*
|--------------------------------------------------------------------------
| Shopping Cart & Wishlist
|--------------------------------------------------------------------------
*/
Route::get('/cart', Cart::class)->name('cart');
Route::get('/checkout', Cart::class)->name('checkout');
Route::get('/order/complete', Cart::class)->name('order.complete');
Route::get('/wishlist', Wishlist::class)->name('wishlist');
Route::get('/address', CheckoutAddress::class)->name('address');
/*
|--------------------------------------------------------------------------
| Strip Checkout
|--------------------------------------------------------------------------
*/
// routes/web.php
Route::middleware('auth')->group(function () {
    Route::get('/checkout', OrderManagementCheckoutPage::class)->name('checkout');
    Route::view('/checkout/success', 'checkout.success')->name('checkout.success');
    Route::view('/checkout/cancel',  'checkout.cancel')->name('checkout.cancel');
});

