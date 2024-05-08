<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateProduct;
use Illuminate\Http\Request;
use App\Models\Product;
use PhpOption\None;

class ProductController extends Controller
{
    public function getAllProduct()
    {
        return Product::all();
    }

    public function createProduct(StoreProduct $request)
    {

        $validatedData = $request->validated();
        $extraKeys = array_diff(array_keys($request->all()), array_keys($validatedData));

        // Si hay claves no permitidas, devuelve un error
        if (!empty($extraKeys)) {
            return response()->json(['error' => 'Unvalied fields:  ' . implode(', ', $extraKeys)], 422);
        }


        $product = Product::create($validatedData);

        return response()->json($product, 201);
    }

    public function getById($id)
    {
        $product = Product::find($id);

        if (!$product) {
            $data = [
                'message' => 'Product not found',
                "status" => 404
            ];
            return response()->json($data, 404);
        }
        return $product;
    }

    public function showByName(Request $request)
    {
        $name = $request->name;
        $product = Product::where("name", $name)->first();
        if (!$product) {
            $data = [
                'message' => 'Product not found',
                "status" => 404
            ];
            return response()->json($data, 404);
        }
        return $product;
    }

    public function update(UpdateProduct $request, Product $product)
    {
        $validatedData = $request->validated();
        $extraFields = array_diff(array_keys($request->all()), array_keys($validatedData));

        if (!empty($extraFields)) {
            return response()->json(['error' => 'Unvalied fields: ' . implode(', ', $extraFields)], 422);
        }

        $product->update($validatedData);
        return response()->json($product, 200);
    }

    public function deleteById(Product $product)
    {
        $product->delete();
        if (!$product) {
            $data = [
                'message' => 'Product not found',
                "status" => 404
            ];
            return response()->json($data, status: 404);
        }
        return response()->json(["message" => "Product deleted"]);
    }
}
