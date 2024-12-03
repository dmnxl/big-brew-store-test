<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|regex:/[A-Z]/|regex:/[0-9]/|regex:/[\W_]/', // Enforcing password rules
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {

            if(Auth::user()->role == 0){
                return redirect()->intended('pos');
            }
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/'); // Redirect back to the login page
    }
}
