<?php
use App\Http\Middleware\AdminMiddleware;
use App\Livewire\Admin\CategoryMangement;
use App\Livewire\Admin\Dashboard;
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
        }
        return view('dashboard');
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
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/', fn() => redirect()->route('admin.dashboard'));
        // Add your other admin Livewire pages here:
        // Route::get('category', CategoryMangement::class)->name('category');

    });
