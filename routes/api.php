<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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
    Route::get("/products", "getAllProduct");

    Route::post("/products", "createProduct");

    Route::get("/products/showByName", "showByName");

    Route::get("/products/{product}", "getById");

    Route::put("/products/{product}", "update");

    Route::delete("/products/{product}", "deleteById");
});
