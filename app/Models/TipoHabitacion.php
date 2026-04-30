<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoHabitacion extends Model
{
    use HasFactory; // Permite el uso de fábricas para crear instancias del modelo TipoHabitacion en pruebas y seeding.

    // Define los atributos que se pueden asignar en masa.
    // Esto es útil para proteger contra la asignación masiva no deseada.
    protected $fillable = ['nombre', 'descripcion'];

    // Especifica el nombre de la tabla
    protected $table = 'tipos_habitaciones';

    // Relación con el modelo Habitacion
    public function habitaciones()
    {
        return $this->hasMany(Habitacion::class);
    }
}