<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $table = 'personal';

    protected $fillable = [
        'nombre',
        'correo',
        'tipo',
    ];

    public function asignaciones()
    {
        return $this->hasMany(AsignacionPersonal::class, 'personal_id');
    }

    public function horarios()
    {
        return $this->hasMany(HorarioPersonal::class, 'personal_id');
    }
}