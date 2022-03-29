<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as User;

class AuthController extends Controller
{
    public function login(){
        //Validation data
        request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        //Check and authenticate
        $result = auth()->attempt([
            'email' => request('email'),
            'password' => request('password')
        ]);

        if($result){
            //Vous êtes connectés
            return redirect('/');
        }
        //Erreur de connexion
        return back();
    }

    public function logout(){
        auth()->lougout();
        //Vous êtes déconnectés
        return redirect('/');
    }
}
