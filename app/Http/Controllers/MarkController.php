<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Mark as Mark;
use App\Models\User as User;
use App\Models\Product as Product;

class MarkController extends Controller
{
    //Créer une note
    //POST: /product/mark/create/product_id
    public function createMark(int $productId){
        //Check if user is auth
        if(!auth()->check()){
            //Vous devez être connectés pour effectuer cette action
            return back();
        }

        //GET Auth User
        $user = auth()->user();

        //TODO: Vérifier si l'utilisateur a déjà acheté ce produit au moins une fois

        //GET Product
        $product = Product::where('id', $productId)->firstOrFail();

        //Validation des données
        $request->validate([
            'mark' => ['required'],
            'advice' => ['required']
        ]);

        //Enregistrement de la note utilisateur
        $mark = Mak::create([
            'mark' => request('mark'),
            'advice' => request('advice'),
            'user_id' => $user->id,
            'product_id' => $product->id
        ]);

        return redirect('/product/mark/'.$mark->id);
    }

    //Récupérer une note par id
    //GET: /product/mark/mark_id
    public function getMark(int $id){
        //GET Mark
        $mark = Mark::where('id', $id)->firstOrFail();

        return($mark);
    }

    //Récupérer les notes d'un produit
    //GET: /product/marks/product_id
    public function getMarks(int $productId){
        //GET Product
        $product = Product::where('id', $productId)->firstOrFail();
        //GET Marks
        $marks = Mark::all()->where('product_id', $productId);

        return($marks);
    }

    //Modifier une note
    //POST: /product/mark/edit/mark_id
    public function editMark(int $id){
        //Check if user is auth
        if(!auth()->check()){
            //Vous devez être connectés pour effectuer cette action
            return back();
        }

        //GET Auth User
        $user = auth()->user();
        //GET Mark
        $mark = Mark::where('id', $id)->firstOrFail();

        //CHECK if mark is associate to user
        if($mark->user_id != $user->id){
            //Vous ne pouvez pas modifier cette note
            return back();
        }

        //Validation data
        $request->validate([
            'mark' => ['required'],
            'advice' => ['advice']
        ]);

        //Save data in DB
        $mark->mark = request('mark');
        $mark->advice = request('advice');
        $mark->save();

        return redirect('/product/mark/'.$mark->id);
    }

    //Supprimer une note
    //GET: /product/mark/delete/mark_id
    public function deleteMark(int $id){
        //Check if user is auth
        if(!auth()->check()){
            //Vous devez être connectés pour effectuer cette action
            return back();
        }

        //GET Auth User
        $user = auth()->user();
        //GET Mark
        $mark = Mark::where('id', $id)->firstOrFail();

        //CHECK if mark is associate to user
        if($mark->user_id != $user->id){
            //Vous ne pouvez pas modifier cette note
            return back();
        }

        $product_id = Product::where('id', $mark->product_id)->firstOrFail();
        $mark->delete();
        
        return redirect(`/product/`.$product_id);
    }
}
