<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_configs', function (Blueprint $table) {
            $table->increments('id');

            //Integers
            $table->integer('max_summons_number');
            $table->integer('max_annual_summons_number');

            //Times
            $table->time('secretariat_open_time');
            $table->time('secretariat_close_time');

            //Dates
            $table->date('inscriptions_start_date');
            $table->date('first_provisional_inscr_list_date');
            $table->date('second_provisional_inscr_list_date');
            $table->date('final_inscr_list_date');
            $table->date('enrolment_start_date');
            $table->date('enrolment_end_date');
            $table->date('provisional_minutes_date');
            $table->date('final_minutes_date');
            $table->date('academic_year_end_date');

            $table->integer('inscriptions_list_status')->default(0);

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
        Schema::dropIfExists('system_configs');
    }
}
