<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\InventoryDetailController;
use App\Http\Controllers\OutInventoryController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['sentinel'])->group(function () {
    Route::resource('/user', UserController::class);
    Route::resource('/product', ProductController::class);
    Route::resource('/unit', UnitController::class);

    //Inventory
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{id}', [InventoryController::class, 'show'])->name('inventory.show');
    Route::patch('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');

    //Supplier
    Route::get('/supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::post('/supplier', [SupplierController::class, 'store'])->name('supplier.store');
    Route::patch('/supplier/{id}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/supplier/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

    //Inventory Detail
    Route::post('/inventoryDetail/{inventory_id}', [InventoryDetailController::class, 'store'])->name('inventoryDetail.store');
    Route::patch('/inventoryDetail/{inventory_id}/{id}', [InventoryDetailController::class, 'update'])->name('inventoryDetail.update');
    Route::delete('/inventoryDetail/{inventory_id}/{id}', [InventoryDetailController::class, 'destroy'])->name('inventoryDetail.destroy');

    //Out Inventory
    Route::post('/outInventory/{inventory_id}', [OutInventoryController::class, 'store'])->name('outInventory.store');
    Route::patch('/outInventory/{inventory_id}/{id}', [OutInventoryController::class, 'update'])->name('outInventory.update');
    Route::delete('/outInventory/{inventory_id}/{id}', [OutInventoryController::class, 'destroy'])->name('outInventory.destroy');

    //Profile
    Route::get('profile',[ProfileController::class, 'index']);
    Route::get('edit-profile',[ProfileController::class, 'editProfile']);
    Route::patch('edit-profile',[ProfileController::class, 'updateProfile']);
    Route::get('edit-password',[ProfileController::class, 'editPassword']);
    Route::patch('edit-password',[ProfileController::class, 'updatePassword']);
});