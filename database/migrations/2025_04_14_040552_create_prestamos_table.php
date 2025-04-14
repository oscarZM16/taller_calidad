<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrestamosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('prestamos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // funcionario que hace el préstamo
        $table->foreignId('insumo_id')->constrained()->onDelete('cascade'); // insumo prestado
        $table->enum('estado', ['pendiente', 'aprobado', 'rechazado', 'finalizado'])->default('pendiente');
        $table->date('fecha_inicio')->nullable();
        $table->date('fecha_fin')->nullable();
        $table->timestamps();
    });
}
}
