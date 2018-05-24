<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {


            $table->integer('number');
            $table->integer('subject_instance_id')->unsigned();
            $table->integer('theory_lecturer_id')->unsigned();
            $table->integer('practice_lecturer_id')->unsigned();

            $table->index('id');
            $table->index('subject_instance_id');
            $table->index('theory_lecturer_id');
            $table->index('practice_lecturer_id');

            $table->foreign('subject_instance_id')->references('id')->on('subject_instances');
            $table->foreign('theory_lecturer_id')->references('id')->on('users');
            $table->foreign('practice_lecturer_id')->references('id')->on('users');


            $table->increments('id');
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
        Schema::dropIfExists('groups');
    }
}
