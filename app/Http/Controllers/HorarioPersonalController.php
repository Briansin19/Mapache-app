<?php

namespace App\Http\Controllers;

use App\Models\HorarioPersonal;
use App\Models\Personal;
use Illuminate\Http\Request;
use App\Models\Habitacion;

class HorarioPersonalController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $horarios = HorarioPersonal::with(['personal', 'habitacion'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('personal', function ($q) use ($search) {
                    $q->where('nombre', 'like', "%$search%");
                });
            })
            ->get()
            ->groupBy('personal_id');

        return view('horarios_personal.index', compact('horarios'));
    }

    public function create()
    {
        $personal = Personal::pluck('nombre', 'id');
        $habitaciones = Habitacion::pluck('nombre', 'id');
        return view('horarios_personal.crear', compact('personal', 'habitaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'personal_id' => 'required|exists:personal,id',
            'dia_semana' => 'required|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i',
            'habitacion_id' => 'required|exists:habitaciones,id',
        ]);

        HorarioPersonal::create($request->all());
        return redirect()->route('horarios_personal.index')->with('success', 'Horario creado exitosamente.');
    }

    public function edit(HorarioPersonal $horario)
    {
        $personal = Personal::pluck('nombre', 'id');
        $habitaciones = Habitacion::pluck('nombre', 'id');
        return view('horarios_personal.editar', compact('horario', 'personal', 'habitaciones'));
    }

    public function update(Request $request, HorarioPersonal $horario)
    {
        $request->validate([
            'personal_id' => 'required|exists:personal,id',
            'dia_semana' => 'required|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i',
            'habitacion_id' => 'required|exists:habitaciones,id',
        ]);

        $horario->update($request->all());
        return redirect()->route('horarios_personal.index')->with('success', 'Horario actualizado exitosamente.');
    }

    public function destroy(HorarioPersonal $horario)
    {
        $horario->delete();
        return redirect()->route('horarios_personal.index')->with('success', 'Horario eliminado exitosamente.');
    }

    public function getHorarios(Personal $maestro)
    {
        $horarios = HorarioPersonal::where('personal_id', $maestro->id)->with('habitacion')->get();
        return response()->json($horarios);
    }
}