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
            $table->string('avatar')->nullable();
            $table->string('description')->nullable();
            $table->string('bg_card')->nullable();
            $table->string('bg_font_color')->nullable();
            $table->string('likes')->nullable();
            $table->string('users_online')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
