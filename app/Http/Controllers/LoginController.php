<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
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

        // Mensaje unificado de seguridad (sin dar pistas)
        $mensajeSeguro = 'Acceso denegado. Las credenciales son incorrectas o la cuenta no tiene permisos activos. Si crees que es un error, contacta a administración.';

        // 1. Intentamos autenticar con correo y contraseña
        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            // 2. Verificamos si la cuenta está suspendida/dada de baja
            if (!Auth::user()->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Disparamos variable de sesión 'error' para el Toast
                return back()->with('error', $mensajeSeguro)->onlyInput('email');
            }

            // 3. Si las credenciales son correctas y está activo, lo dejamos entrar
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('success', 'Bienvenido de nuevo');
        }

        // 4. Si la contraseña o el correo son incorrectos (disparamos el mismo Toast)
        return back()->with('error', $mensajeSeguro)->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Sesión cerrada');
    }
}
