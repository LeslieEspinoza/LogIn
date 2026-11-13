<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRol
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRol = (string) auth()->user()->rol_id;

        $rolesPermitidos = [];
        foreach ($roles as $rol) {
            $partes = explode(',', (string) $rol);
            foreach ($partes as $parte) {
                $rolesPermitidos[] = trim($parte);
            }
        }

        if (!in_array($userRol, $rolesPermitidos, false)) {

            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
