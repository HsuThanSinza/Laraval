<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create(){
        return view('auth.login');
    }
    public function store(){
        //validate
        $attribute= request()->validate([
            'email' => ['required'] ,
            'password' => ['required']
        ]);
        //attempt to login (success)
       // Auth::attempt($attribute);

       //if not match email to login
       if(! Auth::attempt($attribute)){
            throw ValidationException::withMessages([
                'email' => 'Sorry,Email does not match.'
            ]);
       }

        //regenerate the session token
        request()->session()->regenerate();

        //redirect
        return redirect('/job');

    }
    public function destroy(){
        Auth::logout();
        return redirect('/');
    }
}
