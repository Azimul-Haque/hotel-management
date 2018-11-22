<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique_key')->unique();
            $table->string('pnr')->unique();
            $table->datetime('date');
            $table->datetime('timelimit');
            $table->string('room_name');
            $table->string('reservation_status');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('price');
            $table->string('discount');
            $table->string('advance');
            $table->string('due');
            $table->string('booked_by');
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
        Schema::drop('reservations');
    }
}
