<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Edificio extends Model
{
    use HasFactory; // Permite el uso de fábricas para crear instancias del modelo Edificio en pruebas y seeding.

    // Define los atributos que se pueden asignar en masa.
    // Esto es útil para proteger contra la asignación masiva no deseada.
    protected $fillable = ['nombre', 'descripcion', 'latitud', 'longitud'];
}