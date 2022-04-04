<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User as User;
use App\Models\Product as Product;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product_id',
        'user_id'
    ];

    public function product(){
        return $this->belongTo(Product::class);
    }

    public function user(){
        return $this->belongTo(User::class);
    }
}
