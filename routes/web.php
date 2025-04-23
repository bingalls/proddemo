<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Spatie\Csp\AddCspHeaders;

use App\Mail\PriceChangeNotification;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;

// Break out these routes, when this file grows
Route::middleware([AddCspHeaders::class])->group(static function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');

    Route::get('/products/{product_id}', [ProductController::class, 'show'])->name('products.show');

    Route::get('/login', [LoginController::class, 'loginPage'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

Route::prefix('admin')->middleware(['auth', AddCspHeaders::class])->group(static function () {
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/products/add', [AdminController::class, 'addProductForm'])->name('admin.add.product');
    Route::post('/products/add', [AdminController::class, 'addProduct'])->name('admin.add.product.submit');
    Route::get('/products/edit/{id}', [AdminController::class, 'editProduct'])->name('admin.edit.product');
    Route::post('/products/edit/{id}', [AdminController::class, 'updateProduct'])->name('admin.update.product');
    Route::get('/products/delete/{id}', [AdminController::class, 'deleteProduct'])->name('admin.delete.product');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

if (config('app.debug')) {
    Route::get('/testmail', static function () {
        $product = Product::find(3);
        Mail::to('test@example.com')->send(new PriceChangeNotification($product, 0, 42.42));
    });
}
