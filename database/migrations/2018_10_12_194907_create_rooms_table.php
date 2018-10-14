<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('date')->unique();
            $table->string('g1');
            $table->string('g2');
            $table->string('r101');
            $table->string('r102');
            $table->string('r103');
            $table->string('r201');
            $table->string('r202');
            $table->string('r203');
            $table->string('r301');
            $table->string('r302');
            $table->string('r303');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rooms');
    }
}
