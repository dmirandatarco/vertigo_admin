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
        Schema::create('detalle_paquetes', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('paquete_id')-> unsigned();
            $table->foreign('paquete_id')->references('id')->on('paquetes');
            $table->BigInteger('tour_id')-> unsigned();
            $table->foreign('tour_id')->references('id')->on('tours');
            $table->integer('dia');
            $table->text('observacion')->nullable();
            $table->string('estado',1)->default(1);
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
        Schema::dropIfExists('detalle_paquetes');
    }
};
