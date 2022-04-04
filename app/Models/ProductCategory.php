<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product as Product;
use App\Models\Category as Category;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product_id',
        'category_id'
    ];

    public function product(){
        return $this->belongTo(Product::class);
    }

    public function category(){
        return $this->belongTo(Category::class);
    }
}
