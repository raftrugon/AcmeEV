<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlCheckInstancesTable extends Migration
{
    public function up()
    {
        Schema::create('control_check_instances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('calification')->nullable();
            $table->integer('control_check_id')->unsigned();
            $table->integer('student_id')->unsigned();
            $table->string('url')->nullable();

            $table->index('control_check_id');
            $table->index('student_id');

            $table->foreign('control_check_id')->references('id')->on('control_checks')->onDelete('cascade');
            $table->foreign('student_id')->references('id')->on('users');
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
        Schema::dropIfExists('control_check_instances');
    }
}
