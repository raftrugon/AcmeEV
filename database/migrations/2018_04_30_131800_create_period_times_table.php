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
            $table->enum('day',['L','M','X','J','V','S','D']);
            $table->time('start');
            $table->time('end');
            $table->integer('group_id')->unsigned()->nullable();
            $table->integer('pas_id')->unsigned()->nullable();

            $table->index('id');
            $table->foreign('group_id')->references('id')->on('groups')->delete('cascade');
            $table->foreign('pas_id')->references('id')->on('users')->delete('cascade');
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
