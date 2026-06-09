<?php

namespace App\Http\Controllers;

use App\Models\Edificio;
use App\Models\Evento;
use App\Models\Personal;
use Illuminate\Http\Request;

class MapaController extends Controller
{
    public function index()
    {
        $edificios = Edificio::orderBy('nombre', 'asc')->get();
        $eventos = Evento::with('habitacion')->orderBy('fecha_inicio', 'asc')->get();
        $maestros = Personal::where('tipo', 'Docente')->orderBy('nombre', 'asc')->get();
        $orsApiKey = env('ORS_API_KEY');
        return view('mapa.index', compact('edificios', 'eventos', 'maestros', 'orsApiKey'));
    }
}