<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReassignmentTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reassignment_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_id')->references('id')->on('tickets')->onDelete('cascade')->constrained();
            $table->string('designer_id')->references('designer_id')->on('tickets')->onDelete('cascade')->constrained();
            $table->string('designer_name')->references('designer_name')->on('tickets')->onDelete('cascade')->constrained();
            $table->string('designer_receives_id')->nullable();
            $table->string('designer_receives')->nullable();
            $table->date('reception_date')->nullable();
            $table->string('status_type')->nullable();
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
        Schema::dropIfExists('reassignment_tickets');
    }
}
