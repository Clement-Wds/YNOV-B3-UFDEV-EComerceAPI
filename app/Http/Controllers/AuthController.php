<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as User;

class AuthController extends Controller
{
    public function login(Request $request){
        //Validation data
        //$request->validate([
            //'email' => ['required', 'email'],
            //'password' => ['required']
        //]);

        //Check and authenticate
        $result = auth()->attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ]);

        if($result){
            //Vous êtes connectés
            return redirect('/');
        }
        //Erreur de connexion
        return redirect('/login');
    }

    public function logout(){
        auth()->logout();
        //Vous êtes déconnectés
        return redirect('/');
    }
}
