<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $product = Product::all();
        // return response()->json([
        //     "message"=>"Se envio correctamente",
        //     "product"=>$product
        // ],200);
        return new ProductCollection(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = $request->validated();
        $product['slug'] = $this->createSlug($product['name']);
        $product = Product::create($product);
        return response()->json([
            "message" => "Se agrego correctamente",
            "product" => $product
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $term)
    {
        $product = Product::where('id',$term)
                    ->orWhere('slug',$term)
                    ->get();

        //validar
        
        if(count($product) == 0){
            return response()->json([
                "message" => "no se encontro el producto"                
            ],404);
        }         

        return new ProductResource($product[0]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        if(!$product)
        {
            return response()->json([
                "message" => "no se encontro el producto"                
            ],404);
        }

        if( $request->name )
        {
            $request['slug'] = $this->createSlug($request['name']);

        }
        $product->update($request->all());
        return response()->json([
            "message" => "El producto fue actualizada correctamente",
            "request" => new ProductResource($product)
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if( !$product ){
            return response()->json([
                "message" => "no se encontro la categoria",
            ],404);
        }

        $product->delete();
        return response()->json([
            "mesage" => "Se elimino correctamente",
            "category" => new ProductResource($product)
        ],200);
    }

    private function createSlug(string $text)
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/','-', $text);
        $text = trim($text, '-');
        $text = preg_replace('/-+/','-', $text);
        return $text;
    }
}
