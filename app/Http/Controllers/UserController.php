<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as User;

class UserController extends Controller
{
    //Create Account
    public function createUser(Request $request){
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'regex:/^(?=.*[a-z|A-Z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/','confirmed'],
            'password_confirmation' => ['required'],
        ]);

        //Check if user exist
        $existingUser = User::where('email', $request->input('email'))->first();
        if($existingUser != null){
            return ('ERREUR : Un compte existe déjà avec l\'adresse mail saisie !');
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'status' => 'user',
            'postal_code' => $request->input('postal_code'),
            'city' => $request->input('city'),
            'country' => $request->input('country'),
            'postal_adress' => $request->input('postal_adress'),
            'postal_supplement' => $request->input('postal_supplement')
        ]);

        return redirect('/login');
    }

    //Change Account informations
    public function editUser(Request $request){
        //Check if user is auth
        if(!auth()->check()){
            //Vous devez être connectés pour effectuer cette action
            return back();
        }

        //Get Auth User
        $user = auth()->user();

        //Validation data
        $request->validate([
            'name' => ['required'],
            'email' => ['required']
        ]);

        //Change and save modification in DB
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->postal_code = $request->input('postal_code');
        $user->city = $request->input('city');
        $user->country = $request->input('country');
        $user->postal_adress = $request->input('postal_adress');
        $user->postal_supplement = $request->input('postal_supplement');
        $user->save();

        //Vos modifications ont bien été enregitrées
        return redirect('/edit_profile');
    }

    //Change password
    public function changePassword(Request $request){
        //Check if user is auth
        if(!auth()->check()){
            //Vous devez être connectés pour effectuer cette action
            return back();
        }

        //Get Auth User
        $user = auth()->user();

        //Validation data
        // request()->validate([
        //     'current_password' => ['required'],
        //     'password' => ['required', 'min:8', 'regex:/^(?=.*[a-z|A-Z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/','confirmed'],
        //     'password_confirmation' => ['required']
        // ]);

        if(Hash::check($request->input('current_password'), $user->password)){
            $user->password = bcrypt($request->input('password'));
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
