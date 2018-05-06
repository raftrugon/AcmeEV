<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code');
            $table->enum('subjectType',['OBLIGATORY','BASIC','OPTATIVE','EDP']);
            $table->integer('schoolYear');
            $table->boolean('semester');
            $table->integer('department_id')->unsigned();
            $table->integer('degree_id')->unsigned();
            $table->integer('coordinator_id')->unsigned();


            $table->index('id');
            $table->index('department_id');
            $table->index('degree_id');
            $table->index('coordinator_id');

            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('degree_id')->references('id')->on('degrees');
            $table->foreign('coordinator_id')->references('id')->on('users');
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
        Schema::dropIfExists('subjects');
    }
}
