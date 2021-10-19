<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transmitter_id')->references('id')->on('users');
            $table->string('transmitter_name');
            $table->string('transmitter_role');
            $table->foreignId('receiver_id')->references('id')->on('users');
            $table->string('receiver_name');
            $table->text('message');
            $table->foreignId('ticket_id')->constrained();
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
        Schema::dropIfExists('messages');
    }
}
