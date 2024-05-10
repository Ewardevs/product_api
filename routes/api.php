<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VentasController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(ProductController::class)->group(function () {
    Route::get("/products", "getAllProduct")->name('api.getAllProduct');

    Route::post("/products", "createProduct")->name('api.createProduct');

    Route::get("/products/showByName", "showByName")->name('api.showByName');

    Route::get("/products/{product}", "getById")->name('api.getById');

    Route::put("/products/{product}", "update")->name('api.update');

    Route::delete("/products/{product}", "deleteById")->name('api.deleteById');
});

Route::controller(VentasController::class)->group(function () {
    Route::post("/createSale", "createSale");

    Route::get("/sales", "showSales");
});
