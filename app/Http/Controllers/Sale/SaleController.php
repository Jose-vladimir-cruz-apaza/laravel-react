<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Http\Resources\Sale\SaleCollection;
use App\Http\Resources\Sale\SaleResource;
use App\Models\Product;
use App\Models\ProductSale;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new SaleCollection(Sale::all()); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //instanciar una vent
        $sale = new Sale();
        $sale->client = $request->client;
        $sale->total = $request->total;
        $sale->user_id = $request->user_id;
        $sale->save();
        //Obtener arreglo de detalles
        $details =[];
        $products = $request->products;
        //iterar los detalles 
        foreach( $products as $product)
        {
            $details[] = [
                'sale_id'       => $sale->id,
                'product_id'    => $product['product_id'],
                'product_name'  => $product['product_name'],
                'product_slug'  => $product['product_slug'],
                'product_price' => $product['product_price'],
                'quantity'      => $product['quantity'],
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ];
            //actualizando stock
            $product_updated = Product::find($product['product_id']);           
            if($product['quantity'] > $product_updated['stock']){

                $sale->delete();
                return response()->jsom([
                    "message" => "No hay suficiente stock, no se realizo la venta"
                ],400);
            }   
            $product_updated['stock'] = $product_updated['stock'] - $product['quantity'];
            $product_updated->update();
        }
        //guardar los datos de la venta
        ProductSale::insert($details);
        return response()->json([
            "message" => "se registro la venta correctamente",            
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sale = Sale::find($id);
        return new SaleResource($sale);
    }

    /**
     * Update the specified resource in storage.
     */
    
}
