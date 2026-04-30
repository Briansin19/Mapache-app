<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaEdificios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edificios', function (Blueprint $table) {
            $table->id(); // id INT (PK)
            $table->string('nombre'); // nombre VARCHAR
            $table->text('descripcion'); // descripcion TEXT
            $table->decimal('latitud', 10, 8); // latitud DECIMAL(10, 8)
            $table->decimal('longitud', 11, 8); // longitud DECIMAL(11, 8)
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
        Schema::dropIfExists('edificios');
    }
}