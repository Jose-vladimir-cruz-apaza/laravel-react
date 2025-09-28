<?php

namespace App\Http\Resources\Sale;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        $category = Category::find($this->category_id);
        
        return[            
            "id" => $this->id,
            "name" => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'category' => [
                'id' => $category->id,
                'slug' => $category->slug,
                'name' => $category->name,
            ],
            'image' => $this->image,
            'price' => $this->price,
            'subTotal' => $this->price* $this->pivot['quantity'],
            'quantity' => $this->pivot['quantity']
        ];
    }
}
