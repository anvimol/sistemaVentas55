<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('people_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('type_voucher',20);
            $table->string('serie_voucher',7);
            $table->string('num_voucher',10);
            $table->dateTime('datetime');
            $table->decimal('impost', 8, 2);
            $table->string('sale_total', 8, 2);
            $table->string('status',20);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('people_id')->references('id')->on('people');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
