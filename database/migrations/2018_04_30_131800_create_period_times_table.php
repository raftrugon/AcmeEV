<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('period_times', function (Blueprint $table) {
            $table->increments('id');
            //0->6 Domingo,Lunes,...,Viernes,Sabado
            $table->integer('day');
            $table->time('start');
            $table->time('end');
            $table->integer('group_id')->unsigned();
            $table->integer('room_id')->unsigned();

            $table->index('id');
            $table->foreign('group_id')->references('id')->on('groups')->delete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->delete('cascade');
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
        Schema::dropIfExists('period_times');
    }
}
