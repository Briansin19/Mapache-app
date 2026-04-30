<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioPersonal extends Model
{
    use HasFactory;

    protected $table = 'horarios_personal';

    protected $fillable = [
        'personal_id',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'habitacion_id',
    ];

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class, 'habitacion_id');
    }
}