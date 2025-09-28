<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sale extends Model
{
    use HasFactory;
    
    protected $fillable = [
        "total",
        "user_id",
        "client"
    ];

    public function products():BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_sales')
            ->withPivot('quantity');
    }
}
