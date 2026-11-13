<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Mail\ExpedienteMail;
use App\Exports\UserExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;

class ReporteController extends Controller
{
    private function obtenerDatosSanitizados($id)
    {
        return Estudiante::with([
            'carrera',
            'secciones.materia',
            'user:id,name,email'
        ])->findOrFail($id);
    }

    public function index(\Illuminate\Http\Request $request)
    {
        // 1. Obtenemos los estudiantes paginados (paginate en lugar de get)
        $estudiantes = Estudiante::with(['user', 'carrera'])->paginate(10);

        // 2. Inicializamos la variable que pide tu vista
        $estudianteSeleccionado = null;

        // 3. Si se hizo clic en un estudiante, cargamos todos sus datos detallados
        if ($request->filled('estudiante_id')) {
            $estudianteSeleccionado = Estudiante::with([
                'carrera',
                'secciones.materia',
                'user'
            ])->find($request->estudiante_id);
        }

        // 4. Enviamos ambas variables a la vista
        return view('reportes.index', compact('estudiantes', 'estudianteSeleccionado'));
    }

    // --- CORREO DIRECTO SIMPLE ---
    public function enviarCorreo(Request $request, $id)
    {
        $request->validate(['email_destino' => 'required|email']);
        $estudiante = $this->obtenerDatosSanitizados($id);

        Mail::to($request->email_destino)->send(new ExpedienteMail($estudiante));

        return back()->with('success', 'El expediente fue enviado exitosamente por correo.');
    }

    // --- PDF ---
    public function exportarPdf($id)
    {
        $estudiante = $this->obtenerDatosSanitizados($id);
        $pdf = Pdf::loadView('reportes.expediente-pdf', compact('estudiante'))
            ->setPaper('letter', 'portrait');

        return $pdf->download("Expediente_{$estudiante->id}.pdf");
    }

    public function enviarCorreoPdf(Request $request, $id)
    {
        $request->validate(['email_destino' => 'required|email']);
        $estudiante = $this->obtenerDatosSanitizados($id);

        $pdf = Pdf::loadView('reportes.expediente-pdf', compact('estudiante'))
            ->setPaper('letter', 'portrait');

        Mail::to($request->email_destino)->send(
            new ExpedienteMail($estudiante, $pdf->output(), "Expediente_{$estudiante->id}.pdf", "application/pdf")
        );

        return back()->with('success', 'El expediente en formato PDF fue enviado con éxito al correo indicado.');
    }

    // --- EXCEL ---
    public function exportarExcel($id)
    {
        $estudiante = $this->obtenerDatosSanitizados($id);
        return Excel::download(new UserExport($id), "Expediente_{$estudiante->id}.xlsx");
    }

    public function enviarCorreoExcel(Request $request, $id)
    {
        $request->validate(['email_destino' => 'required|email']);
        $estudiante = $this->obtenerDatosSanitizados($id);

        $excelBinary = Excel::raw(new UserExport($id), \Maatwebsite\Excel\Excel::XLSX);

        Mail::to($request->email_destino)->send(
            new ExpedienteMail(
                $estudiante,
                $excelBinary,
                "Expediente_{$estudiante->id}.xlsx",
                "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            )
        );

        return back()->with('success', 'El expediente en formato Excel fue enviado con éxito al correo indicado.');
    }
}
