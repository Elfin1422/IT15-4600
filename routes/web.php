<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockEntryController;
use App\Http\Controllers\SupplierController;
use App\Models\Product;
use App\Models\StockEntry;
use App\Models\Supplier;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    $totalProducts = Product::count();
    $totalSuppliers = Supplier::count();
    $totalStockEntries = StockEntry::count();
    $totalStockDelivered = StockEntry::sum('quantity');
    
    $recentStockEntries = StockEntry::with(['product', 'supplier'])
        ->latest()
        ->take(5)
        ->get();
    
    $lowStockProducts = Product::where('current_stock', '<=', 10)
        ->orderBy('current_stock')
        ->take(5)
        ->get();

    return view('home', compact(
        'totalProducts',
        'totalSuppliers',
        'totalStockEntries',
        'totalStockDelivered',
        'recentStockEntries',
        'lowStockProducts'
    ));
})->name('home');


Route::resource('products', ProductController::class);

Route::resource('suppliers', SupplierController::class);

Route::resource('stock_entries', StockEntryController::class);


use App\Http\Controllers\PostController;

Route::get('/posts', [PostController::class, 'index']);