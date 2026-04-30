<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaTiposHabitaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos_habitaciones', function (Blueprint $table) {
            $table->id(); // id INT (PK)
            $table->string('nombre'); // nombre VARCHAR
            $table->text('descripcion')->nullable(); // descripcion TEXT
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipos_habitaciones');
    }
}