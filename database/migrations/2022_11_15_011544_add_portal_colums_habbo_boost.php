<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habbo_boosts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->constrained()->references('id')->on('users');
            $table->string('habbo_id')->constrained()->references('id')->on('habbos');
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
        Schema::dropIfExists('habbos');
    }
};
