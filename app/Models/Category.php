<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product as Product;
use App\Models\ProductCategory as ProductCategory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'identifier'
    ];

    public $timestamps = false;

    public function products(){
        return $this->belongsToMany(Product::class, 'products_categories', 'category_id', 'product_id');
    }

    public function productCategories(){
        return $this->hasMany(ProductCategory::class);
    }
}
