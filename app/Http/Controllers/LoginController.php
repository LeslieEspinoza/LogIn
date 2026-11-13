<?php

namespace App\Http\Controllers;


use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

    class LoginController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            return redirect()->route('home');
        }
        return view('login.index');
    }

        public function login(LoginRequest $request)
        {
            $credentials = [
                'email'    => $request->email,
                'password' => $request->password,
            ];

            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                session()->regenerate();
                return redirect()->intended(route('home'))->with('success', 'Bienvenido de nuevo');
            }

            return redirect()->route('login')->with('error', 'Las credenciales son incorrectas');
        }

  public function logout(Request $request)
  {
      Auth::logout();
     session()->invalidate();
      session()->regenerateToken();
      return redirect()->route('login')-> with('sucess', 'Sesión cerrada');
  }

}

