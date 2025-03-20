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
        Schema::table('menu_detalles', function (Blueprint $table) {
            $table->BigInteger('ubicacion_id')->unsigned()->nullable()->after('categoria_id');
            $table->foreign('ubicacion_id')->references('id')->on('ubicacions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_detalles', function (Blueprint $table) {
            //
        });
    }
};
