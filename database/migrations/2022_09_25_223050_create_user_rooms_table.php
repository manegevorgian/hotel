<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('room_id');
            $table->date('date');
            $table->enum('status', ['Booked', 'Cancelled'])->default('Booked');

            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id')->onDelete("CASCADE");;
            $table->foreign('room_id')->on('rooms')->references('id')->onDelete("CASCADE");;

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_rooms');
    }
}
