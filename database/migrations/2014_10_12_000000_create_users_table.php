<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('password');

            $table->string('surname');
            $table->string('id_number');
            $table->string('address');
            $table->string('phone_number');
            $table->string('personal_email')->unique();

            //RELATIONSHIPS
            $table->integer('department_id')->nullable()->unsigned();
            $table->index('department_id');
            $table->foreign('department_id')->references('id')->on('departments');

            $table->integer('degree_id')->nullable()->unsigned();
            $table->foreign('degree_id')->references('id')->on('degrees');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
