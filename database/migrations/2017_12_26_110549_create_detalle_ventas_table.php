<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idventas')->unsigned();
            $table->integer('idarticulo')->unsigned();
            $table->integer('cantidad');
            $table->decimal('precio_venta', 11, 2);
            $table->decimal('descuento', 11, 2);
            $table->timestamps();

            $table->foreign('idventas')->references('id')->on('ventas');
            $table->foreign('idarticulo')->references('id')->on('articles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_ventas');
    }
}
