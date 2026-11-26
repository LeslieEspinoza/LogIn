<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminEstudianteController extends Controller
{
    public function index()
    {
        $estudiantes = Estudiante::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.estudiantes.index', compact('estudiantes'));
    }

    public function aprobarExpediente(Estudiante $estudiante)
    {
        // Actualizamos el nuevo campo booleano a true
        $estudiante->update([
            'expediente_aprobado' => true
        ]);

        return redirect()->route('admin.estudiantes.index')
            ->with('success', 'El expediente de ' . $estudiante->user->name . ' ha sido aprobado.');
    }

    public function kardex(Estudiante $estudiante)
    {
        $fecha = now()->format('d/m/Y');

        $pdf = Pdf::loadView('estudiantes.pdf.kardex', compact('estudiante', 'fecha'));

        return $pdf->download('Kardex_' . $estudiante->documento_identidad . '.pdf');
    }

    public function resetPassword(Estudiante $estudiante)
    {
        $nuevaPassword = Str::random(8);

        $cuenta = $estudiante->user ?? $estudiante->user;

        $cuenta->update([
            'password' => Hash::make($nuevaPassword)
        ]);

        return redirect()->route('admin.estudiantes.index')
            ->with('success', 'Contraseña restablecida correctamente.')
            ->with('credenciales', [
                'nombre'   => $cuenta->name,
                'email'    => $cuenta->email,
                'password' => $nuevaPassword,
            ]);
    }
}
