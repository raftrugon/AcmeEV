<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_calendars', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('start')->useCurrent();
            $table->timestamp('end')->useCurrent();
            $table->integer('pas_id')->unsigned();
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
        Schema::dropIfExists('appointment_calendars');
    }
}
