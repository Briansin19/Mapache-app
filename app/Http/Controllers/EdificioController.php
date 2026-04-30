<?php

namespace App\Http\Controllers;

use App\Models\Edificio;
use Illuminate\Http\Request;

class EdificioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:ver-edificio|crear-edificio|editar-edificio|borrar-edificio', ['only' => ['index', 'show']]);
        $this->middleware('permission:crear-edificio', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-edificio', ['only' => ['edit', 'update']]);
        $this->middleware('permission:borrar-edificio', ['only' => ['destroy']]);
    }

    public function index()
    {
        $edificios = Edificio::orderBy('nombre', 'asc')->paginate(5);
        return view('edificios.index', compact('edificios'));
    }

    public function create()
    {
        return view('edificios.crear');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'latitud' => 'required|numeric|between:-90,90',
            'longitud' => 'required|numeric|between:-180,180',
        ]);

        Edificio::create($request->all());
        return redirect()->route('edificios.index')->with('success', 'Edificio creado exitosamente.');
    }

    public function edit(Edificio $edificio)
    {
        return view('edificios.editar', compact('edificio'));
    }

    public function update(Request $request, Edificio $edificio)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'latitud' => 'required|numeric|between:-90,90',
            'longitud' => 'required|numeric|between:-180,180',
        ]);

        $edificio->update($request->all());
        return redirect()->route('edificios.index')->with('success', 'Edificio actualizado exitosamente.');
    }

    public function destroy(Edificio $edificio)
    {
        $edificio->delete();
        return redirect()->route('edificios.index')->with('success', 'Edificio eliminado exitosamente.');
    }
}