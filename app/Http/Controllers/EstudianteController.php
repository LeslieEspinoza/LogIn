<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EstudianteController extends Controller
{
    // 1. Dashboard Estudiante
    public function dashboard()
    {
        $estudiante = auth()->user()->estudiante;

        // Aquí luego calcularemos el CUM y porcentaje de avance
        $datos = [
            'estudiante' => $estudiante,
            'materiasInscritas' => $estudiante ? $estudiante->secciones()->count() : 0,
        ];

        return view('estudiantes.dashboard', $datos);
    }

    // 2. Horario
    public function horario()
    {
        $estudiante = auth()->user()->estudiante;
        $secciones = $estudiante ? $estudiante->secciones()->with('materia')->get() : collect();

        return view('estudiantes.horario', compact('secciones'));
    }

    // 3. Calificaciones
    public function calificaciones()
    {
        $estudiante = auth()->user()->estudiante;
        return view('estudiantes.calificaciones', compact('estudiante'));
    }

    // 4. Perfil
    public function perfil()
    {
        $usuario = auth()->user();
        return view('estudiantes.perfil', compact('usuario'));
    }

    // 5. Trámites
    public function tramites()
    {
        return view('estudiantes.tramites');
    }

    public function descargarKardex()
    {
        $estudiante = auth()->user()->estudiante;

        // Validamos que el usuario tenga un registro de estudiante asociado
        if (!$estudiante) {
            return back()->with('error', 'No se encontraron datos de estudiante.');
        }

        // Preparamos los datos para la vista del PDF
        $datos = [
            'estudiante' => $estudiante,
            'fecha' => now()->format('d/m/Y - h:i A')
        ];

        // Generamos el PDF apuntando a una nueva vista
        $pdf = Pdf::loadView('estudiantes.pdf.kardex', $datos);

        // Retornamos la descarga directa
        $nombreArchivo = 'Kardex_' . ($estudiante->carnet ?? 'Academico') . '.pdf';
        return $pdf->download($nombreArchivo);
    }

    // 6. Actualizar Perfil
    public function actualizarPerfil(\Illuminate\Http\Request $request)
    {
        $usuario = auth()->user();

        // 1. Validamos los datos recibidos
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'password' => 'nullable|min:8|confirmed',
        ], [
            'email.unique' => 'Este correo ya está en uso por otro usuario.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.'
        ]);

        // 2. Actualizamos el correo
        $usuario->email = $request->email;

        // 3. Si el usuario escribió una nueva contraseña, la encriptamos y la cambiamos
        if ($request->filled('password')) {
            $usuario->password = bcrypt($request->password);
        }

        // 4. Guardamos los cambios en la base de datos
        $usuario->save();

        // 5. Retornamos a la vista anterior con un mensaje de éxito
        return back()->with('success', 'Tus credenciales han sido actualizadas correctamente.');
    }
}
