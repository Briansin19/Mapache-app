<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaHabitaciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habitaciones', function (Blueprint $table) {
            $table->id(); // id INT (PK)
            $table->string('nombre'); // nombre VARCHAR
            $table->text('descripcion')->nullable(); // descripcion TEXT
            $table->unsignedBigInteger('edificio_id'); // relación con edificios
            $table->unsignedBigInteger('tipo_habitacion_id'); // relación con tipos_habitaciones
            $table->timestamps(); // created_at y updated_at

            // Definir las relaciones
            $table->foreign('edificio_id')->references('id')->on('edificios')->onDelete('cascade');
            $table->foreign('tipo_habitacion_id')->references('id')->on('tipos_habitaciones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('habitaciones');
    }
}