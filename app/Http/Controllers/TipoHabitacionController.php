<?php

namespace App\Http\Controllers;

use App\Models\TipoHabitacion;
use Illuminate\Http\Request;

class TipoHabitacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:ver-tipo_habitaciones|crear-tipo_habitaciones|editar-tipo_habitaciones|borrar-tipo_habitaciones', ['only' => ['index', 'show']]);
        $this->middleware('permission:crear-tipo_habitaciones', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-tipo_habitaciones', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-tipo_habitaciones', ['only' => ['destroy']]);
    }

    public function index()
    {
        $tiposHabitaciones = TipoHabitacion::paginate(5);
        return view('tipos_habitaciones.index', compact('tiposHabitaciones'));
    }

    public function create()
    {
        return view('tipos_habitaciones.crear');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        TipoHabitacion::create($request->all());
        return redirect()->route('tipos-habitaciones.index')->with('success', 'Tipo de Habitación creado exitosamente.');
    }

    public function edit(TipoHabitacion $tipoHabitacion)
    {
        return view('tipos_habitaciones.editar', compact('tipoHabitacion'));
    }

    public function update(Request $request, TipoHabitacion $tipoHabitacion)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $tipoHabitacion->update($request->all());
        return redirect()->route('tipos-habitaciones.index')->with('success', 'Tipo de Habitación actualizado exitosamente.');
    }

    public function destroy(TipoHabitacion $tipoHabitacion)
    {
        $tipoHabitacion->delete();
        return redirect()->route('tipos-habitaciones.index')->with('success', 'Tipo de Habitación eliminado exitosamente.');
    }
}