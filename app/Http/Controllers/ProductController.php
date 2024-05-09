<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateProduct;
use Illuminate\Http\Request;
use App\Models\Product;
use PhpOption\None;

/**
 * @OA\Info(
 *             title="Productos", 
 *             version="1.0",
 *             description="Descripcion"
 * )
 *
 * @OA\Server(url="https://productapi-production-a124.up.railway.app/")
 */
class ProductController extends Controller
{
    /**
     * Listado de productos
     * @OA\Get (
     *     path="/api/products",
     *     tags={"Products"},
     *     @OA\Response(
     *         response=200,
     *         description="ok",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="nombre",
     *                         type="string",
     *                         example="computadors"
     *                     ),
     *                     @OA\Property(
     *                         property="descricion",
     *                         type="string",
     *                         example="descripcion1"
     *                     ),
     *                     @OA\Property(
     *                         property="image_url",
     *                         type="string",
     *                         example="sdfsdfad"
     *                     ),
     *                      @OA\Property(
     *                         property="price",
     *                         type="number",
     *                         example="5000"
     *                     ),
     *                      @OA\Property(
     *                         property="stock",
     *                         type="number",
     *                         example="50"
     *                     ),
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getAllProduct()
    {
        $product =  Product::all();
        $data = [
            "product" => $product
        ];
        return response()->json($data, status: 200);
    }

    /**
     * Registrar la información de un Producto
     * @OA\Post (
     *     path="/api/products",
     *     tags={"Products"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="description",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="image_url",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="price",
     *                          type="number"
     *                      ),
     *                      @OA\Property(
     *                          property="stock",
     *                          type="number"
     *                      )
     *                 ),
     *                 example={
     *                     "name":"producto",
     *                     "description":"descripcion",
     *                     "image_url":"url",
     *                     "price":"5000",
     *                     "stock":"20"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="CREATED",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="producto"),
     *              @OA\Property(property="description", type="string", example="descripcion"),
     *              @OA\Property(property="image_url", type="string", example="url"),
     *              @OA\Property(property="price", type="number", example="5000"),
     *              @OA\Property(property="stock", type="number", example="20")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="UNPROCESSABLE CONTENT",
     *          @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="errors",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="error",
     *                         type="number",
     *                         example="The price field is required."
     *                     )
     *                 )
     *             )
     *           
     *          )
     *      )
     * )
     */

    public function createProduct(StoreProduct $request)
    {

        $validatedData = $request->validated();
        $extraKeys = array_diff(array_keys($request->all()), array_keys($validatedData));

        // Si hay claves no permitidas, devuelve un error
        if (!empty($extraKeys)) {
            return response()->json(['error' => 'Unvalied fields:  ' . implode(', ', $extraKeys)], 422);
        }


        $product = Product::create($validatedData);
        $data = [
            "product" => $product
        ];

        return response()->json($data, 201);
    }

    /**
     * Mostrar la información de un Producto
     * @OA\Get (
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="producto"),
     *              @OA\Property(property="description", type="string", example="descripcion"),
     *              @OA\Property(property="image_url", type="string", example="url"),
     *              @OA\Property(property="price", type="number", example="5000"),
     *              @OA\Property(property="stock", type="number", example="20")
     *         )
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="NOT FOUND",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Cliente] #id"),
     *          )
     *      )
     * )
     */

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
        $data = [
            "product" => $product
        ];
        return response()->json($data, status: 200);
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
        $data = [
            "product" => $product
        ];
        return response()->json($data, status: 200);
    }

    /**
     * Actualizar la información de un producto
     * @OA\Put (
     *     path="/products/{product}",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="price",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "name": "Producto editado",
     *                     "price": 1000
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="Producto editado"),
     *              @OA\Property(property="description", type="string", example="descripcion"),
     *              @OA\Property(property="image_url", type="string", example="url"),
     *              @OA\Property(property="price", type="number", example="1000"),
     *              @OA\Property(property="stock", type="number", example="20")
     *          )
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="UNPROCESSABLE CONTENT",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="'Unvalied fields: "),
     *              
     *          )
     *      )
     * )
     */

    public function update(UpdateProduct $request, Product $product)
    {
        $validatedData = $request->validated();
        $extraFields = array_diff(array_keys($request->all()), array_keys($validatedData));

        if (!empty($extraFields)) {
            return response()->json(['error' => 'Unvalied fields: ' . implode(', ', $extraFields)], 422);
        }

        $product->update($validatedData);
        $data = [
            "product" => $product
        ];
        return response()->json($data, 200);
    }

    /**
     * Eliminar Producto
     * @OA\Delete (
     *     path="/api/products/{id}",
     *     tags={"Products"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="ok",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Product deleted"),
     *             )
     *          ),
     *      @OA\Response(
     *          response=404,
     *          description="NOT FOUND",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="error"),
     *          )
     *      )
     * )
     */

    public function deleteById($id)
    {
        $product = Product::find($id);

        if (!$product) {
            $data = [
                'message' => 'Product not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $product->delete();

        return response()->json(["message" => "Product deleted"]);
    }
}
