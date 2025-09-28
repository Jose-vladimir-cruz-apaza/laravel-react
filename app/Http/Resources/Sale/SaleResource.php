<?php

namespace App\Http\Resources\Sale;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    public static $wrap = "sale";
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = User::find($this->user_id);
        //Se obtiene los prouctos por la tabla pivote
        $products = Sale::find($this->id)->products;
        

        return [
            'id' => $this->id,
            'client' => $this->client,
            'total' => $this->total,
            'user' => $user,
            'products' => new DetailCollection($products),
            'createdAt' => $this->created_at

        ];
    }
}
