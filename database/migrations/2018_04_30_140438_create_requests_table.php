<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inscription_id')->unsigned();
            $table->integer('degree_id')->unsigned();
            $table->integer('priority');
            $table->boolean('accepted');

            $table->index('id');
            $table->index('inscription_id');
            $table->index('degree_id');

            $table->foreign('inscription_id')->references('id')->on('inscriptions')->delete('cascade');
            $table->foreign('degree_id')->references('id')->on('degrees')->delete('cascade');

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
        Schema::dropIfExists('requests');
    }
}
