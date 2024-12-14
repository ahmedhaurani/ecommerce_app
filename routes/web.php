<?php

use App\Livewire\HomePage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Middleware\AddLocaleToUrls;
use App\Http\Middleware\Localization;
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
use App\Livewire\Admin\Ad\AdManager;
use App\Livewire\Admin\Ad\AdList;
use App\Livewire\Admin\Ad\AdForm;
use App\Livewire\Admin\Blog\BlogLists;
use App\Livewire\Admin\Blog\AddBlog;
use App\Livewire\Admin\Blog\EditBlog;
use App\Livewire\Admin\SettingsController;
use App\Livewire\BrandList;
use App\Livewire\ProductsByBrandPage;


    use App\Livewire\BlogView;
    use App\Livewire\BlogList;

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
use App\Livewire\Auth\UserProfile;

use App\Livewire\SuccessPage;
use App\Livewire\CancelPage;
use App\Livewire\Admin\AdminDashboard;
use App\Livewire\Admin\ProductForm;
use App\Livewire\Admin\ProductList;
use App\Livewire\Admin\Order\OrderDetails;
use App\Livewire\Admin\ReviewManagement;
//use App\Http\Middleware\RedirectToLocale;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Session;

// Main route group with locale prefix and locale middleware

// Route::group([
//     'prefix' => '{locale}',
//     // 'where' => ['locale' => 'en|ar'], // Define allowed locales
//     'middleware' => [App\Http\Middleware\Localization::class]
// ], function () {

Route::get('/', function () {
    // Get the locale from the session, or default to 'ar'
    $locale = Session::get('locale', 'ar');

    // Redirect to the localized home route
    return redirect()->route('home', ['locale' => $locale]);
});

Route::group([
    'prefix' => '{locale}',
    'middleware' => [SetLocale::class, AddLocaleToUrls::class]
], function () {
    // Public routes
    Route::get('/', HomePage::class)->name('home');
    Route::get('products', ProductsPage::class)->name('products.index');
    Route::get('categories', CatgoriesPage::class);
    Route::get('cart', CartPage::class)->name('cart');
    Route::get('products/{slug}', ProductDetailPage::class)->name('products.show');
    Route::get('/category/{slug}', CategoryProducts::class)->name('category.products');
    Route::get('/search-products/{query?}', SearchProducts::class)->name('search.results');
    Route::get('/brands', BrandList::class)->name('brands.index');
    //Route::get('/products/{brand_id?}', ProductsPage::class)->name('products.brand');
    Route::get('/brands1/{brand_slug}/products', ProductsByBrandPage::class)->name('brands.products');


    Route::get('/blogs', BlogList::class)->name('blogs.index');

    Route::get('/blog/{slug}', BlogView::class)->name('blog.show');


    // Guest routes (login, register, forgot, reset)
    //  Route::group(['middleware' => ['guest',App\Http\Middleware\GuestWithLocale::class]], function () {
    Route::middleware(['guest'])->group(function () {

        Route::get('/login', Login::class)->name('login');
        Route::get('/register', RegisterPage::class)->name('register');
        Route::get('/forgot', ForgotPasswordPage::class)->name('forgot');
        Route::get('/reset', ResetPasswordPage::class)->name('reset');
    });

    // Authenticated routes
    Route::middleware([App\Http\Middleware\GuestWithLocale::class])->group(function () {
        Route::post('/logout', function () {
            Auth::logout();
            return redirect('/'); // Redirect to the home page or any desired route
        })->name('logout');
        Route::get('my-profile', UserProfile::class)->name('profile.index');
        Route::get('checkout', CheckoutPage::class)->name('checkout.show');
        Route::get('/my-orders', MyOrdersPage::class)->name('my-order.index');
        Route::get('/my-orders/{orderId}', MyOrderDetailPage::class)->name('my-order.show');
        Route::get('/success', SuccessPage::class)->name('success');
        Route::get('/cancel', CancelPage::class)->name('cancel');
    });
});

// Additional routes outside of locale prefix
Route::middleware([\App\Http\Middleware\ComponentLayoutMiddleware::class])->group(function () {
    Route::prefix('/e/admin')->group(function () {
        Route::get('/', AdminDashboard::class)->name('admin.dashboard');
        Route::get('/products/create', \App\Livewire\Admin\ProductForm::class)->name('admin.products.create');
        Route::get('/products', ProductList::class)->name('admin.products');
        Route::get('/products/{productId}/edit', \App\Livewire\Admin\EditProduct::class)->name('admin.products.edit');
        Route::get('/products/{productId}/edit/{locale}', \App\Livewire\Admin\EditProduct::class)->name('admin.products.edit_locale');
        Route::get('/categories', CategoryManagement::class)->name('category.management');
        Route::get('/categories/create', CategoryCreate::class)->name('category.create');
        Route::get('/categories/edit/{categoryId}', CategoryEdit::class)->name('category.edit');
        Route::get('/brands/create', CreateBrand::class)->name('admin.brands.create');
        Route::get('/brands/edit/{id}', EditBrand::class)->name('admin.brands.edit');
        Route::get('/brands', ListBrands::class)->name('admin.brands.list');
        Route::get('/orders', \App\Livewire\Admin\Order\OrderManagement::class)->name('admin.orders');
        Route::get('/orders/{orderId}', OrderDetails::class)->name('orders.show');
        Route::get('/reviews', ReviewManagement::class);

        Route::get('/ads', AdList::class)->name('admin.ads');
        Route::get('/ads/create', AdForm::class);
        Route::get('/ads/edit/{id}', AdForm::class)->name('admin.ads.edit');;



            Route::get('blogs', BlogLists::class)->name('admin.blogs.index');
            Route::get('blogs/create', AddBlog::class)->name('admin.blogs.create');
            Route::get('blogs/{blogId}/edit', EditBlog::class)->name('admind.blogs.edit1');
            Route::get('blogs/{blogId}/edit/{locale}', EditBlog::class)->name('admin.blogs.edit');
        Route::get('/settings', \App\Livewire\Admin\WebsiteSettings::class)->name('admin.settings');
    });
});


// Language switch route
//Route::get('lang/{locale}', [LanguageController::class, 'switchLang'])->name('lang.switch');

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) { // Add other supported locales as needed
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');
