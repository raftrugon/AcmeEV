<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {

            //Attributes
            $table->string('title');
            $table->string('body');
            $table->date('creation_moment');


            //Relationships
            $table->integer('subject_instance_id')->unsigned();
            $table->foreign('subject_instance_id')->references('id')->on('subject_instances');



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
        Schema::dropIfExists('announcements');
    }
}
