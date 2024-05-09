<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Venta;
use Illuminate\Http\Request;

class VentasController extends Controller
{
    public function createSale(Request $request)
    {
        // aqui obtenemos los productos enviado
        $products = $request->venta["productos"];
        $descuentos = $request->venta["descuentos"];
        // creamos una instancia para crear un modelo
        $venta = new Venta();
        // agregamos datos
        $venta->cliente = $request->venta["cliente"];
        //plantilla del json
        $sale = [
            "id_venta" => 0,
            "fecha_venta" => "",
            "cliente" => $request->venta["cliente"],
            "productos" => [],
            "total" => 0,
            "descuentos" => [],
            "total_con_descuento" => 0
        ];
        //recorremos los productos enviados y agregamos los productos al json
        foreach ($products as $product) {
            // buscamos los productos en la base de datos y agregamos a la plantilla
            $result = Product::find($product["id"]);
            if ($result->stock <= 0) {
                $errorMessage = ["productos sin stock" => []];
                array_push($errorMessage["productos sin stock"], ["name" => $result->name]);
                return response()->json($errorMessage, status: 200);
            }

            $result->stock -= $product["cantidad"];
            $result->save();

            $saleProducts = [
                "id" => $result->id,
                "name" => $result->name,
                "cantidad" => $product["cantidad"],
                "unit_price" => $result->price,
                "subtotal" => round($result->price * $product["cantidad"], 2)
            ];
            // guardamos datos del total al modelo y lo agregamos a la plantilla
            $venta->total += round($result->price * $product["cantidad"], 2);
            round($sale["total"] += $result->price * $product["cantidad"], 3);

            // insertamos los datos al json
            array_push($sale["productos"], $saleProducts);
        }
        //aca calculamos el descuento
        $descuentototal = 0;
        foreach ($descuentos as $descuento) {
            $descuentototal += $descuento["valor"];
        }
        array_push($sale["descuentos"], $descuentos);
        $sale["total_con_descuento"] = $sale["total"] - $descuentototal;


        $venta->productos = $sale["productos"];
        $venta->save();
        // agregamos losd atos faltantes
        $sale["fecha_venta"] = $venta->created_at;
        $sale["id_venta"] = $venta->id;

        return response()->json($sale, status: 200);
    }


    public function showSales()
    {
        $ventas = Venta::all();
        return response()->json($ventas, status: 200);
    }
}
