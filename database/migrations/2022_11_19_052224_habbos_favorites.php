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
        Schema::create('habbos_favorites', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned()->foreignId('user_id')->constrained('users');
            $table->integer('habbo_id')->unsigned()->foreignId('habbo_id')->constrained('habbos');
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
        Schema::dropIfExists('habbos_favorites');
    }
};
