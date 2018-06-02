<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_checks', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('description');
            $table->timestamp('date')->useCurrent();
            $table->boolean('is_submittable');
            $table->double('weight');
            $table->double('minimum_mark');
            $table->integer('room_id')->unsigned();
            $table->integer('subject_instance_id')->unsigned();

            $table->index('room_id');
            $table->index('subject_instance_id');

            $table->foreign('room_id')->references('id')->on('rooms');
            $table->foreign('subject_instance_id')->references('id')->on('subject_instances');

            $table->softDeletes();
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
        Schema::dropIfExists('control_checks');
    }
}
