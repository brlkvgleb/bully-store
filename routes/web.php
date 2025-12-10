<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/bully-store', function () {
    return (123123123);
});

Route::resource('admin/products', AdminController::class, [
    'names' => 'admin.products'
]);

Route::resource('products', ProductController::class)->only(['index','show']);

//Route::get('/admin/products', [AdminController::class, 'index'])->name('admin.products.index');
//Route::get('/admin/products/create', [AdminController::class, 'create'])->name('admin.products.create');
//Route::post('/admin/products', [AdminController::class, 'store'])->name('admin.products.store');
//Route::get('/admin/products/{product}', [AdminController::class, 'show'])->name('admin.products.show');
//Route::get('/admin/products/{product}/edit', [AdminController::class, 'edit'])->name('admin.products.edit');
//Route::put('/admin/products/{product}', [AdminController::class, 'update'])->name('admin.products.update');
//Route::delete('/admin/products/{product}', [AdminController::class, 'destroy'])->name('admin.products.destroy');

//Route::get('/products', [ProductController::class, 'index'])->name('products.index');
//Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
