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
        Schema::create('habbos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('name')->nullable();
            $table->string('mysql_database')->nullable();
            $table->string('mysql_name')->nullable();
            $table->string('mysql_password')->nullable();
            $table->string('domain')->nullable();
            $table->string('emu_port')->nullable();
            $table->string('emu_mus_port')->nullable();
            $table->string('instance_status')->nullable();
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
