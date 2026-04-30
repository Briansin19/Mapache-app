<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Habitacion;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::paginate(10);
        return view('eventos.index', compact('eventos'));
    }

    public function create()
    {
        $habitaciones = Habitacion::pluck('nombre', 'id');
        return view('eventos.crear', compact('habitaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'habitacion_id' => 'required|exists:habitaciones,id',
        ]);

        Evento::create($request->all());
        return redirect()->route('eventos.index')->with('success', 'Evento creado exitosamente.');
    }

    public function edit(Evento $evento)
    {
        $habitaciones = Habitacion::pluck('nombre', 'id');
        return view('eventos.editar', compact('evento', 'habitaciones'));
    }

    public function update(Request $request, Evento $evento)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'habitacion_id' => 'required|exists:habitaciones,id',
        ]);

        $evento->update($request->all());
        return redirect()->route('eventos.index')->with('success', 'Evento actualizado exitosamente.');
    }

    public function destroy(Evento $evento)
    {
        $evento->delete();
        return redirect()->route('eventos.index')->with('success', 'Evento eliminado exitosamente.');
    }
}