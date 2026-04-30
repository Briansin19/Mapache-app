<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Edificio;
use App\Models\TipoHabitacion;
use Illuminate\Http\Request;

class HabitacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:ver-habitaciones|crear-habitaciones|editar-habitaciones|borrar-habitaciones', ['only' => ['index', 'show']]);
        $this->middleware('permission:crear-habitaciones', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-habitaciones', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-habitaciones', ['only' => ['destroy']]);
    }

    public function index()
    {
        $habitaciones = Habitacion::paginate(5);
        return view('habitaciones.index', compact('habitaciones'));
    }

    public function create()
    {
        $edificios = Edificio::all();
        $tiposHabitaciones = TipoHabitacion::all();
        return view('habitaciones.crear', compact('edificios', 'tiposHabitaciones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'edificio_id' => 'required|exists:edificios,id',
            'tipo_habitacion_id' => 'required|exists:tipos_habitaciones,id',
        ]);

        Habitacion::create($request->all());
        return redirect()->route('habitaciones.index')->with('success', 'Habitación creada exitosamente.');
    }

    public function edit(Habitacion $habitacion)
    {
        $edificios = Edificio::all();
        $tiposHabitaciones = TipoHabitacion::all();
        return view('habitaciones.editar', compact('habitacion', 'edificios', 'tiposHabitaciones'));
    }

    public function update(Request $request, Habitacion $habitacion)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'edificio_id' => 'required|exists:edificios,id',
            'tipo_habitacion_id' => 'required|exists:tipos_habitaciones,id',
        ]);

        $habitacion->update($request->all());
        return redirect()->route('habitaciones.index')->with('success', 'Habitación actualizada exitosamente.');
    }

    public function destroy(Habitacion $habitacion)
    {
        $habitacion->delete();
        return redirect()->route('habitaciones.index')->with('success', 'Habitación eliminada exitosamente.');
    }
}