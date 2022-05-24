<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Category as Category;
use App\Models\ProductCategory as ProductCategory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
        'photo',
        'average_score',
        'quantity',
        'category_id'
    ];

    public $timestamps = false;

    public function categories(){
        return $this->belongsToMany(Category::class, 'products_categories', 'category_id', 'product_id');
    }

    public function productCategories(){
        return $this->hasMany(ProductCategory::class);
    }

    public function users(){
        return $this->belongsToMany(User::class, 'cart', 'product_id', 'user_id');
    }

    public function cart(){
        return $this->hasMany(Cart::class);
    }

    public function associateCategory($category){
        return $this->categories()->where('category_id', $category->id)->exists();
    }
}
