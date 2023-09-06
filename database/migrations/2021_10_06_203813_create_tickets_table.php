<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->references('id')->on('users');
            $table->string('seller_name');
            $table->foreignId('creator_id')->references('id')->on('users');
            $table->string('creator_name');
            $table->foreignId('designer_id')->nullable()->references('id')->on('users');
            $table->string('designer_name')->nullable();
            $table->foreignId('priority_id')->constrained();
            $table->foreignId('type_id')->constrained();
            $table->foreignId('status_id')->constrained();
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
        Schema::dropIfExists('tickets');
    }
}
