<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('people_id')->unsigned();
            $table->foreign('people_id')->references('id')->on('people');
            $table->string('type_voucher',20);
            $table->string('serie_voucher',7);
            $table->string('num_voucher',10);
            $table->dateTime('datetime');
            $table->decimal('impost', 8, 2);
            $table->string('status',20);
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
        Schema::dropIfExists('incomes');
    }
}
