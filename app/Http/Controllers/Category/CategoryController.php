<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            "message" => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        //validar datos        
        $category = $request->validated();
        $category['slug'] = $this->createSlug($category['name']);
        
        //Guardar el request
        Category::create($category);

        
        //Retornar mensaje guardado        
        return response()->json([
            "message" => "La categoria fue agregada correctamente",
            "request" => $category 
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $term)
    {
        $category = Category::where('id',$term)
                    ->orWhere('slug',$term)
                    ->get();

        //validar
        
        if(count($category) == 0){
            return response()->json([
                "message" => "no se encontro la categoria"                
            ],404);
        }
        return response()->json([
            "category" => $category[0]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {        
        $category = Category::find($id);
        if(!$category)
        {
            return response()->json([
                "message" => "no se encontro la categoria"                
            ],404);
        }

        if( $request->name )
        {
            $request['slug'] = $this->createSlug($request['name']);

        }
        $category->update($request->all());
        return response()->json([
            "message" => "La categoria fue actualizada correctamente",
            "request" => $category 
        ], 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {        
        $category = Category::find($id);
        if( !$category ){
            return response()->json([
                "message" => "no se encontro la categoria",
            ],404);
        }

        $category->delete();
        return response()->json([
            "mesage" => "Se elimino correctamente",
            "category" => $category
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
