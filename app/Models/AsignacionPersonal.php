<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionPersonal extends Model
{
    use HasFactory;

    protected $table = 'asignaciones_personal';

    protected $fillable = [
        'personal_id',
        'habitacion_id',
        'descripcion',
        'activo',
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