<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Carrera;
use Illuminate\Support\Facades\Auth;
use App\Models\Pago;
use App\Models\Seccion;
use Illuminate\Support\Str;

class OnboardingController extends Controller
{
    public function showPerfilSelection()
    {
        $user = Auth::user();

        // Garantizar que siempre exista la fila en estudiantes para el usuario autenticado
        $estudiante = Estudiante::firstOrCreate(
            ['user_id' => $user->id],
            [
                'correo_institucional' => $user->email,
                'paso_actual'          => 1,
                'completado'           => false,
            ]
        );

        // Si ya tiene un nivel académico seleccionado, redirige a su paso correspondiente
        if ($estudiante->nivel_academico) {
            return redirect()->route('onboarding.paso', ['paso' => $estudiante->paso_actual]);
        }

        return view('onboarding.seleccionar_perfil');
    }

    // Guardar el nivel académico seleccionado
    public function savePerfilSelection(Request $request)
    {
        $request->validate([
            'nivel_academico' => 'required|in:pregrado,posgrado,educacion_continua'
        ]);

        Estudiante::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'nivel_academico' => $request->nivel_academico,
                'paso_actual' => 1
            ]
        );

        return redirect()->route('onboarding.paso', ['paso' => 1]);
    }

    public function showStep($paso)
    {
        $user = Auth::user();
        $estudiante = $user->estudiante;

        if (!$estudiante) {
            return redirect()->route('onboarding.perfil');
        }

        if ((int)$paso === 2) {
            // Obtener carreras que coincidan con el nivel académico seleccionado
            $carreras = Carrera::where('nivel', $estudiante->nivel_academico)->get();

            // Obtener secciones disponibles de la carrera seleccionada (o todas las activas)
            $carreraId = $estudiante->carrera_id ?? $carreras->first()?->id;
            $secciones = Seccion::when($carreraId, function ($query) use ($carreraId) {
                return $query->where('carrera_id', $carreraId);
            })->get();

            return view('onboarding.paso2_carrera', compact('estudiante', 'carreras', 'secciones'));
        }

        return match ((int)$paso) {
            1 => view('onboarding.paso1_documentos', compact('estudiante')),
            3 => view('onboarding.paso3_pago', compact('estudiante')),
            4 => view('onboarding.paso4_confirmacion', compact('estudiante')),
            default => redirect()->route('dashboard'),
        };
    }

    public function guardarPaso1(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nombres' => 'required|string|max:255',
            'documento_identidad' => 'required|string|max:50|unique:estudiantes,documento_identidad,' . ($user->estudiante->id ?? 'NULL'),
        ]);


        $estudiante = Estudiante::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'documento_identidad' => $request->documento_identidad,
                'correo_institucional' => $user->email,
                'paso_actual' => 2,
            ]
        );

        return redirect()->route('onboarding.paso', ['paso' => 2]);
    }

    public function guardarPaso2(Request $request)
    {
        $user = Auth::user();
        $estudiante = $user->estudiante;

        $request->validate([
            'carrera_id'  => 'required|exists:carreras,id',
            'secciones'   => 'nullable|array',
            'secciones.*' => 'exists:secciones,id',
        ]);


        $estudiante->update([
            'carrera_id'  => $request->carrera_id,
            'paso_actual' => 3,
        ]);


        if ($request->has('secciones')) {
            $estudiante->secciones()->sync($request->secciones);
        }
        return redirect()->route('onboarding.paso', ['paso' => 3]);

    }

    public function guardarPaso3(Request $request)
    {
        $user = Auth::user();
        $estudiante = $user->estudiante;

        // 1. Validación condicional de campos
        $request->validate([
            'monto' => 'required|numeric',
            'metodo_pago' => 'required|in:tarjeta,transferencia',

            // 'referencia' solo es obligatoria e única si el método es 'transferencia'
            'referencia' => 'nullable|required_if:metodo_pago,transferencia|string|unique:pagos,referencia',

            // Validaciones opcionales/condicionales si deseas validar datos de la tarjeta recibida
            'card_holder' => 'required_if:metodo_pago,tarjeta|nullable|string',
            'card_number' => 'required_if:metodo_pago,tarjeta|nullable|string',
            'card_expiry' => 'required_if:metodo_pago,tarjeta|nullable|string',
            'card_cvv'    => 'required_if:metodo_pago,tarjeta|nullable|string',
        ]);

        // 2. Determinar la referencia a guardar
        if ($request->metodo_pago === 'tarjeta') {
            // Si es tarjeta, generas una referencia/transacción automática (ej. TRX-CARD-12345678)
            $referencia = 'TRX-CARD-' . strtoupper(Str::random(10));
        } else {
            // Si es transferencia, usas la referencia ingresada por el usuario
            $referencia = $request->referencia;
        }

        // 3. Registrar el pago
        Pago::create([
            'user_id'     => $user->id,
            'monto'       => $request->monto,
            'metodo_pago' => $request->metodo_pago,
            'estado'      => $request->metodo_pago === 'tarjeta' ? 'aprobado' : 'pendiente', // Opcional: aprobar tarjeta inmediatamente
            'referencia'  => $referencia,
        ]);

        // 4. Actualizar el estado del estudiante
        $estudiante->update([
            'paso_actual'        => 4,
            'completado'         => true,
            'estatus_financiero' => true,
        ]);

        return redirect()->route('onboarding.paso', ['paso' => 4])
            ->with('success', 'Pago registrado exitosamente.');
    }

}
