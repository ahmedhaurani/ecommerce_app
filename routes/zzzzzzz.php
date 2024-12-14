<?php

use App\Livewire\HomePage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Livewire\ProductsPage;
use App\Livewire\SearchProducts;
use App\Livewire\ProductDetailPage;
use App\Livewire\Admin\Category\CategoryManagement;
use App\Livewire\Admin\Category\CategoryCreate;
use App\Livewire\Admin\Category\CategoryEdit;
use App\Livewire\Admin\Brand\BrandManager;
use App\Livewire\Admin\Brand\CreateBrand;
use App\Livewire\Admin\Brand\EditBrand;
use App\Livewire\Admin\Brand\ListBrands;
use App\Livewire\CatgoriesPage;
use App\Livewire\CategoryProducts;
use App\Livewire\CartPage;
use App\Livewire\CheckoutPage;
use App\Livewire\MyOrdersPage;
use App\Livewire\MyOrderDetailPage;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\SuccessPage;
use App\Livewire\CancelPage;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\ProductForm;
use App\Livewire\Admin\ProductList;
use App\Livewire\Admin\Order\OrderDetails;
use App\Livewire\Admin\ReviewManagement;

// Main route group with locale prefix and locale middleware
Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => 'en|ar'], // Define allowed locales
    'middleware' => [App\Http\Middleware\Localization::class]
], function () {
    // Public routes
    Route::get('/', HomePage::class)->name('home');
    Route::get('products', ProductsPage::class)->name('products.index');
    Route::get('categories', CatgoriesPage::class);
    Route::get('cart', CartPage::class);
    Route::get('products/{slug}', ProductDetailPage::class);
    Route::get('/category/{slug}', CategoryProducts::class)->name('category.products');
    Route::get('/search-products/{query?}', SearchProducts::class)->name('search.results');

    // Guest routes (login, register, forgot, reset)
    Route::group(['middleware' => ['guest']], function () {
        Route::get('/login', Login::class)->name('login');
        Route::get('/register', RegisterPage::class)->name('register');
        Route::get('/forgot', ForgotPasswordPage::class)->name('forgot');
        Route::get('/reset', ResetPasswordPage::class)->name('reset');
    });

    // Authenticated routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/logout', function () {
            auth()->logout();
            return redirect()->route('login', ['locale' => app()->getLocale()]);
        });
        Route::get('checkout', CheckoutPage::class)->name('checkout.show');
        Route::get('/my-orders', MyOrdersPage::class);
        Route::get('/my-orders/{orderId}', MyOrderDetailPage::class)->name('my-order.show');
        Route::get('/success', SuccessPage::class)->name('success');
        Route::get('/cancel', CancelPage::class)->name('cancel');
    });
});

// Additional routes outside of locale prefix
Route::middleware([\App\Http\Middleware\ComponentLayoutMiddleware::class])->group(function () {
    Route::get('/admin', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/admin/products/create', \App\Livewire\Admin\ProductForm::class)->name('admin.products.create');
    Route::get('/admin/products', ProductList::class)->name('admin.products');
    Route::get('/admin/products/{productId}/edit', \App\Livewire\Admin\EditProduct::class)->name('admin.products.edit');
    Route::get('/admin/products/{productId}/edit/{locale}', \App\Livewire\Admin\EditProduct::class)->name('admin.products.edit_locale');
    Route::get('/admin/categories', CategoryManagement::class)->name('category.management');
    Route::get('/admin/categories/create', CategoryCreate::class)->name('category.create');
    Route::get('/admin/categories/edit/{categoryId}', CategoryEdit::class)->name('category.edit');
    Route::get('/admin/brands/create', CreateBrand::class)->name('admin.brands.create');
    Route::get('/admin/brands/edit/{id}', EditBrand::class)->name('admin.brands.edit');
    Route::get('/admin/brands', ListBrands::class)->name('admin.brands.list');
    Route::get('/admin/orders', \App\Livewire\Admin\Order\OrderManagement::class)->name('admin.orders');
    Route::get('admin/orders/{orderId}', OrderDetails::class)->name('orders.show');
    Route::get('/admin/reviews', ReviewManagement::class);
});

// Language switch route
Route::get('lang/{locale}', [LanguageController::class, 'switchLang'])->name('lang.switch');
