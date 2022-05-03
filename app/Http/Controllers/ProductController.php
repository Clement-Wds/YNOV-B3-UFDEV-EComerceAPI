<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product as Product;
use App\Models\Category as Category;
use App\Models\ProductCategory as ProductCategory;

class ProductController extends Controller
{
    //Créer un produit
    //POST : /product/create
    public function createProduct(){
        //Check if user is auth
        if(!auth()->check()){
            //Vous devez être connectés pour effectuer cette action
            return back();
        }

        $user = auth()->user();
        //Ckeck user status
        if($user->status != 'admin'){
            //Vous n'avez pas l'autorisation d'effectuer cette action
            return back();
        }

        request()->validate([
            'name' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'quantity' => ['quantity']
        ]);

        $product = Product::create([
            'name' => request('name'),
            'description' => request('description'),
            'price' => request('price'),
            'quantity' => request('quantity')
        ]);

        //Le produit a été créé avec succès
        return redirect('product/'.$product->id);
    }

    //Modifier un produit
    //POST : /product/edit/id
    public function editProduct(int $id){
        //Check if user is auth
        if(!auth()->check()){
            //Vous devez être connectés pour effectuer cette action
            return back();
        }

        $user = auth()->user();
        //Ckeck user status
        if($user->status != 'admin'){
            //Vous n'avez pas l'autorisation d'effectuer cette action
            return back();
        }

        $product = Product::all()->where('id', $id)->firstOrFail();
        
        request()->validate([
            'name' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'quantity' => ['required']
        ]);

        $product->name = request('name');
        $product->description = request('description');
        $product->price = request('price');
        $product->quantity = request('quantity');
        $product->save();

        //Le produit a été modifié avc succès
        return redirect('product/'.$product->id);
    }

    //Lire un produit
    //GET : /product/id
    public function readProduct(int $id){
        $product = Product::all()->where('id', $id)->firstOrFail();

        return($product);
    }

    //Liste des produits
    //GET : /products
    public function listProducts(){
        $products = Product::all();
        return($products);
    }

    //Récupérer des produits grâce à l'id de la catégorie
    //GET: /products/category_id/id
    public function getProductsCategoryId(int $id){
        $category = Category::where('id', $id)->firstOrFail();
        $products = array();

        $productsAll = Product::all();

        foreach($productsAll as $product){
            if($product->associateCategory($category)){
                array_push($products, $product);
            }
        }

        return($products);
    }

    //Récupérer des produits grâce au nom de la catégorie
    //GET: /products/category_name/indentifier
    public function getProductsCategoryName(string $identifier){
        $category = Category::where('identifier', $identifier)->firstOrFail();
        $products = array();

        $productsAll = Product::all();

        foreach($productsAll as $product){
            if($product->associateCategory($category)){
                array_push($products, $product);
            }
        }

        return($products);
    }
    
    //Supprimer un produit
    //GET : /product/delete/id
    public function deleteProduct(int $id){
        //Check if user is auth
        if(!auth()->check()){
            //Vous devez être connectés pour effectuer cette action
            return back();
        }

        $user = auth()->user();
        //Ckeck user status
        if($user->status != 'admin'){
            //Vous n'avez pas l'autorisation d'effectuer cette action
            return back();
        }

        $product = Product::all()->where('id', $id)->firstOrFail();

        $product->delete();

        //le produit a été supprimé avec succès
        return redirect('/products');
    }

}
