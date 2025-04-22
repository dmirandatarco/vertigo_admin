<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agencia_registros', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',250)->nullable();
            $table->string('celular',50)->nullable();
            $table->string('documento',50)->nullable();
            $table->string('numero',50)->nullable();
            $table->string('correo',150)->nullable();
            $table->string('aceptado',1)->nullable();
            $table->string('archivo',250)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agencia_registros');
    }
};
