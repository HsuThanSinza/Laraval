<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\RegisteredUserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function create(){
        return view('auth.register');
    }
    public function store(){
        $validatedattribute=request()->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required','email'],
            'password' => ['required', Password::min(5), 'confirmed']
        ]);
        
        //create the user
       $user=User::create($validatedattribute);
       //Login
       Auth::login($user);
       //return
       return redirect('/job');
    }
}
