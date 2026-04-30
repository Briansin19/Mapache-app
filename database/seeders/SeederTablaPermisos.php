<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SeederTablaPermisos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permisos = [
            // Permisos para roles
            'ver-rol',
            'crear-rol',
            'editar-rol',
            'borrar-rol',

            // Permisos para usuarios
            'ver-usuario',
            'crear-usuario',
            'editar-usuario',
            'borrar-usuario',

            // Permisos para edificios
            'ver-edificio',
            'crear-edificio',
            'editar-edificio',
            'borrar-edificio',

            // Permisos para habitaciones
            'ver-habitaciones',
            'crear-habitaciones',
            'editar-habitaciones',
            'borrar-habitaciones',

            // Permisos para tipos de habitaciones
            'ver-tipo_habitaciones',
            'crear-tipo_habitaciones',
            'editar-tipo_habitaciones',
            'borrar-tipo_habitaciones',

            // Permiso para ver la ubicación de los maestros
            'ver-ubicacion-maestros',
        ];

        // Crear cada permiso en la base de datos si no existe
        foreach ($permisos as $permiso) {
            if (!Permission::where('name', $permiso)->exists()) {
                Permission::create(['name' => $permiso]);
            }
        }
    }
}