<?php



use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StockMovementController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [ProductController::class, 'catalogue']);
Route::get('/catalogue', [ProductController::class, 'catalogue'])->name('catalogue.index');
/*
|--------------------------------------------------------------------------
| AUTH ROUTES (PROFILE ONLY)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| CASHIER + ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:cashier,admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/stock-movements', [StockMovementController::class, 'index'])
        ->name('stock-movements.index');

    Route::post('/stock-movements', [StockMovementController::class, 'store'])
        ->name('stock-movements.store');

    Route::delete('/stock-movements/{movement}', [StockMovementController::class, 'destroy'])
        ->name('stock-movements.destroy');

    Route::delete('/stock-movements/{movement}/revert', [StockMovementController::class, 'revert'])
        ->name('stock-movements.revert');


    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');

    Route::delete('/sales/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy');
    Route::post('/sales/{sale}/revert', [SaleController::class, 'revert'])->name('sales.revert');

});

/*
|--------------------------------------------------------------------------
| ADMIN ONLY ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('users', UserController::class);

    Route::get('categories/{category}/json', [CategoryController::class, 'json'])
        ->name('categories.json');
});

require __DIR__.'/auth.php';