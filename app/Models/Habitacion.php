<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    use HasFactory; // Permite el uso de fábricas para crear instancias del modelo Habitacion en pruebas y seeding.

    // Define los atributos que se pueden asignar en masa.
    // Esto es útil para proteger contra la asignación masiva no deseada.
    protected $fillable = ['nombre', 'descripcion', 'edificio_id', 'tipo_habitacion_id'];

    // Especifica el nombre de la tabla
    protected $table = 'habitaciones';

    // Relación con el modelo Edificio
    public function edificio()
    {
        return $this->belongsTo(Edificio::class);
    }

    // Relación con el modelo TipoHabitacion
    public function tipoHabitacion()
    {
        return $this->belongsTo(TipoHabitacion::class);
    }
}