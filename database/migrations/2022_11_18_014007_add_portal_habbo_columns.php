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
        Schema::table('habbos', function (Blueprint $table) {
            $table->string('players')->nullable();
            $table->string('staff_vacancy')->nullable();
            $table->string('image')->nullable();
            $table->string('events_time')->nullable();
            $table->dateTime('inauguration_date')->nullable();
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
