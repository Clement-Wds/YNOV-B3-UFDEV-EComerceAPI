<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as User;

class UserController extends Controller
{
    //Create Account
    public function createUser(){
        request()->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'regex:/^(?=.*[a-z|A-Z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/','confirmed'],
            'password_confirmation' => ['required'],
        ]);

        //Check if user exist
        $existingUser = User::where('email', request('email'))->first();
        if($existingUser != null || $existingUser != '[]'){
            return ('ERREUR : Un compte existe déjà avec l\'adresse mail saisie !');
        }

        $user = User::create([
            'name' => request('name'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
            'status' => 'user'
        ]);

        return redirect('/login');
    }

    //Change Account informations
    public function editUser(){
        //Check if user is auth
        if(!auth()->check()){
            //Vous devez être connectés pour effectuer cette action
            return back();
        }

        //Get Auth User
        $user = auth()->user();

        //Validation data
        request()->validate([
            'name' => ['required'],
            'email' => ['required']
        ]);

        //Change and save modification in DB
        $user->name = request('name');
        $user->email = request('email');
        $user->save();

        //Vos modifications ont bien été enregitrées
        return redirect('/edit_profile');
    }

    //Change password
    public function changePassword(){
        //Check if user is auth
        if(!auth()->check()){
            //Vous devez être connectés pour effectuer cette action
            return back();
        }

        //Get Auth User
        $user = auth()->user();

        //Validation data
        request()->validate([
            'current_password' => ['required'],
            'password' => ['required', 'min:8', 'regex:/^(?=.*[a-z|A-Z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/','confirmed'],
            'password_confirmation' => ['required']
        ]);

        if(Hash::check(request('current_password'), $user->password)){
            $user->password = bcrypt(request('password'));
            $user->save();

            //Succès de la modication du mot de passe
            return redirect('/edit_profile');
        }
        else{
            //Erreur de modification -> ancien mot de passe incorrect
            return redirect('/change_password');
        }
    }

    //Delete Account
    public function deleteUser(){
        //Check if user is auth
        if(!auth()->check()){
            //Vous devez être connectés pour effectuer cette action
            return back();
        }

        //Get Auth User
        $user = auth()->user();

        //Detete user
        $user->delete();

        //Votre compte a bien été supprimé
        return redirect('/');
    }
}
