<?php

namespace App\Exports;

use App\Models\Estudiante;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UserExport implements FromView, ShouldAutoSize
{
    protected $estudianteId;

    public function __construct($estudianteId)
    {
        $this->estudianteId = $estudianteId;
    }

    public function view(): View
    {
        $estudiante = Estudiante::with([
            'carrera',
            'secciones.materia',
            'user:id,name,email'
        ])->findOrFail($this->estudianteId);

        return view('reportes.expediente-excel', compact('estudiante'));
    }
}
