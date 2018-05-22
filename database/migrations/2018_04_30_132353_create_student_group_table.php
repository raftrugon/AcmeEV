<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentGroupTable extends Migration
{
    public function up()
    {
        Schema::create('student_group', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->unsigned();
            $table->integer('student_id')->unsigned();

            $table->index('group_id');
            $table->index('student_id');

            $table->foreign('group_id')->references('id')->on('groups');
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
