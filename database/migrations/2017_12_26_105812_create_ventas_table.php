<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idcliente')->unsigned();
            $table->string('tipo_comprobante',20);
            $table->string('serie_comprobante',7);
            $table->string('num_comprobante',10);
            $table->dateTime('fecha_hora');
            $table->decimal('impuesto', 8, 2);
            $table->string('total_venta', 8, 2);
            $table->string('estado',20);
            $table->timestamps();
            
            $table->foreign('idcliente')->references('id')->on('people');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
