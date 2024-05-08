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


Route::get("/products", [ProductController::class, "getAllProduct"]);

Route::post("/products", [ProductController::class, "createProduct"]);

Route::get("/products/showByName", [ProductController::class, "showByName"]);

Route::get("/products/{product}", [ProductController::class, "getById"]);

Route::put("/products/{product}", [ProductController::class, "update"]);

Route::delete("/products/{product}", [ProductController::class, "deleteById"]);
