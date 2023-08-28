<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile');
            $table->unsignedBigInteger('country_code');
            $table->unsignedBigInteger('state_code');
            $table->unsignedBigInteger('city_code');
            $table->string('avatar');
            $table->timestamps();

            $table->foreign('country_code')->references('id')->on('user_countries')->onDelete('cascade');
            $table->foreign('state_code')->references('id')->on('user_states')->onDelete('cascade');
            $table->foreign('city_code')->references('id')->on('user_cities')->onDelete('cascade');
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
