<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStudentOnboarding
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Si no hay usuario en sesión, dejar que el middleware 'auth' lo redirija a login
        if (auth()->check() && in_array(auth()->user()->rol_id, [1, 2])) {
            return $next($request);
        }

        $user = auth()->user();

        // 2. LIBERACIÓN INMEDIATA: Si NO es estudiante (1: Admin, 2: Docente), no se evalúa onboarding
        if ((int) $user->rol_id !== 3) {
            return $next($request);
        }

        // 3. Evaluación exclusiva para Estudiantes (rol_id === 3)
        $estudiante = $user->estudiante;

        if (!$estudiante || !$estudiante->completado) {
            if (!$request->routeIs('onboarding.*')) {
                return redirect()->route('onboarding.perfil');
            }
        }

        return $next($request);
    }
}
