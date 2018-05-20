<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->integer('subject_instance_id')->unsigned();
            $table->integer('group_id')->unsigned()->nullable();
            $table->integer('parent_id')->unsigned()->nullable();

            $table->foreign('subject_instance_id')->references('id')->on('subject_instances');
            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('parent_id')->references('id')->on('folders');
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
        Schema::dropIfExists('folders');
    }
}
