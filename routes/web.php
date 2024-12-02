<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Log;

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

Auth::routes();
Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role: 2,3'])->group(function(){
     //Account
     Route::get('/account', [AccountController::class, 'index'])->name('account');
     Route::get('/account/create', [AccountController::class, 'create'])->name('accreate');
     Route::post('/account/store', [AccountController::class, 'store'])->name('account.store');
     Route::get('/accountData', [AccountController::class, 'getData'])->name('accData');
     Route::get('/account/{id}/edit', [AccountController::class, 'edit'])->name('accedit');
     Route::post('/account/{id}/update', [AccountController::class, 'update'])->name('accupdate');
     Route::match(['post', 'delete'], '/account/delete', [AccountController::class, 'delete'])->name('accdelete');
});

Route::middleware(['auth', 'role: 1,2,3'])->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Inventory - Ingredients
    Route::get('/inventory/ingredients', [InventoryController::class, 'index'])->name('inventory');
    Route::post('/inventory/store', [InventoryController::class, 'store'])->name('invenstore');
    Route::post('/check-inventory',  [InventoryController::class, 'checkInventory'])->name('checkInventory');

    Route::get('/inventoryData/ingredients', [InventoryController::class, 'getData'])->name('invDataIngredients');

    //Inventory - Add Ons
    Route::get('/inventory/add-ons', [InventoryController::class, 'indexAddOns'])->name('inventoryAddOns');
    Route::get('/inventoryData/addons', [InventoryController::class, 'getDataAddOns'])->name('invDataAddOns');
    Route::post('/inventory/store/addons', [InventoryController::class, 'storeAddOns'])->name('invenstoreAddOns');

    //Inventory - Materials
    Route::get('/inventory/materials', [InventoryController::class, 'indexMaterials'])->name('inventoryMaterials');
    Route::get('/inventoryData/materials', [InventoryController::class, 'getDataMeterials'])->name('invDataMaterials');
    Route::post('/inventory/store/materials', [InventoryController::class, 'storeMaterials'])->name('invenstorematerials');

    Route::post('/inventory/edit', [InventoryController::class, 'edit'])->name('invenedit');
    Route::delete('/inventory/delete', [InventoryController::class, 'delete'])->name('invendelete');

    //Product
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::get('/product/create', [ProductController::class, 'create'])->name('prodcreate');
    Route::post('/product/store', [ProductController::class, 'store'])->name('prodstore');
    Route::get('/productData', [ProductController::class, 'getData'])->name('prodData');
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('prodedit');
    Route::post('/product/{id}/update', [ProductController::class, 'update'])->name('produpdate');
    Route::delete('/product/delete', [ProductController::class, 'delete'])->name('proddelete');


});

Route::middleware(['auth', 'role:0,2,3'])->group(function(){

    Route::get('/pos', [POSController::class, 'index'])->name('pos');
    Route::get('/filter-products', [POSController::class, 'filterProducts']);
    Route::post('/checkout', [POSController::class, 'checkout'])->name('checkout');
    Route::get('/receipt/{orderId}', [POSController::class, 'showReceipt'])->name('receipt.show');
    Route::post('/get-product-sizes', [POSController::class, 'getProductSizes'])->name('getProductSizes');


});

