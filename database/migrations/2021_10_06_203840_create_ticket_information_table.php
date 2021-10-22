<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_informations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_id')->constrained();
            $table->foreignId('status_id')->constrained();
            $table->foreignId('technique_id')->constrained();
            $table->foreignId('modifier_id')->references('id')->on('users');
            $table->string('modifier_name');
            $table->string('customer')->nullable();
            $table->string('title')->nullable();
            $table->text('logo')->nullable();
            $table->text('items')->nullable();
            $table->text('product')->nullable();
            $table->string('pantone')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('ticket_information');
    }
}
