<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    public function index()
    {
        $personal = Personal::paginate(10);
        return view('personal.index', compact('personal'));
    }

    public function create()
    {
        return view('personal.crear');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:personal',
            'tipo' => 'required|in:Docente,Administrativo',
        ]);

        Personal::create($request->all());
        return redirect()->route('personal.index')->with('success', 'Personal creado exitosamente.');
    }

    public function edit(Personal $personal)
    {
        return view('personal.editar', compact('personal'));
    }

    public function update(Request $request, Personal $personal)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|string|email|max:255|unique:personal,correo,' . $personal->id,
            'tipo' => 'required|in:Docente,Administrativo',
        ]);

        $personal->update($request->all());
        return redirect()->route('personal.index')->with('success', 'Personal actualizado exitosamente.');
    }

    public function destroy(Personal $personal)
    {
        $personal->delete();
        return redirect()->route('personal.index')->with('success', 'Personal eliminado exitosamente.');
    }
}