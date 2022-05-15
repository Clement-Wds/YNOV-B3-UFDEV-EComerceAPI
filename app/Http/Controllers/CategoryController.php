<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category as Category;

class CategoryController extends Controller
{
    //Créer une catégorie
    //POST : /category/create
    public function createCategory(Request $request){
        // //Check if user is auth
        // if(!auth()->check()){
        //     //Vous devez être connectés pour effectuer cette action
        //     //return ('pas connectés');
        // }

        // $user = auth()->user();
        // //Ckeck user status
        // if($user->status != 'admin'){
        //     //Vous n'avez pas l'autorisation d'effectuer cette action
        //     //return ('pas bon statut');
        // }

        $request->validate([
            'name' => ['required'],
            'identifer' => ['required']
        ]);

        $category = Category::create([
            'name' => $request->input('name'),
            'identifier' => $request->input('identifier')
        ]);

        //Catégorie créée avec succès
        return redirect('/categories');
    }

    //Modifier une catégorie
    //POST : /catagory/edit/1
    public function editCategory(Request $request, int $id){
        // //Check if user is auth
        // if(!auth()->check()){
        //     //Vous devez être connectés pour effectuer cette action
        //     return back();
        // }

        // $user = auth()->user();
        // //Ckeck user status
        // if($user->status != 'admin'){
        //     //Vous n'avez pas l'autorisation d'effectuer cette action
        //     return back();
        // }

        $category = Category::all()->where('id', $id)->firstOrFail();

        $request->validate([
            'name' => ['required'],
            'identifier' => ['required']
        ]);

        $category->name = $request->input('name');
        $category->identifier = $request->input('identifier');
        $category->save();

        //La catégorie a été modifiée avec succès
        return redirect('/categories');
    }

    //Supprimer une catégorie
    //GET : /category/delete/1
    public function deleteCategory(int $id){
        // //Check if user is auth
        // if(!auth()->check()){
        //     //Vous devez être connectés pour effectuer cette action
        //     return back();
        // }

        // $user = auth()->user();
        // //Ckeck user status
        // if($user->status != 'admin'){
        //     //Vous n'avez pas l'autorisation d'effectuer cette action
        //     return back();
        // }

        $category = Category::all()->where('id', $id)->firstOrFail();
        $category->delete();

        //La catégorie a été supprimée avec succès
        return redirect('/categories');
    }

    //Voir les catégories
    //GET : /categories
    public function listCategories(){
        $categories = Category::all();
        return($categories);
    }
}
