<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'slug',
        'category_id',
        'stock',
        'price',
        'image',        
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
