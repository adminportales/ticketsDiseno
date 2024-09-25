<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamDisenoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_diseno_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_diseno_id')->references('id')->on('team_disenos')->onDelete('cascade');
            $table->integer('user_id');
            // $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Schema::create('team_user', function (Blueprint $table) {
        //     $table->foreignId('team_id')->constrained();
        //     $table->foreignId('user_id')->constrained();

        //     $table->unique(['team_id', 'user_id']);
        // });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_diseno_users');
    }
}
