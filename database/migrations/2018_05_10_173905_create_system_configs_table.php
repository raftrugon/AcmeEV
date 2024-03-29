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
            $table->integer('max_students_per_group');

            //Times
            $table->time('building_open_time');
            $table->time('building_close_time');

            //University Config
            $table->string('name_en');
            $table->string('name_es');
            $table->string('icon')->nullable();
            $table->string('banner')->nullable();


            //STATE MACHINE
            $table->integer('actual_state')->default(0);



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
