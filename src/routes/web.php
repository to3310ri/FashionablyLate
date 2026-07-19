<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/products/register', [ProductController::class, 'create'])
    ->name('products.create');

Route::post('/products/register', [ProductController::class, 'store'])
    ->name('products.store');

Route::get('/products/detail/{product}', [ProductController::class, 'show'])
    ->name('products.show');

Route::patch('/products/detail/{product}', [ProductController::class, 'update'])
    ->name('products.update');

Route::delete('/products/detail/{product}', [ProductController::class, 'destroy'])
    ->name('products.destroy');