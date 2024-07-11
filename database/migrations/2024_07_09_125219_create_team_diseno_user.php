<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamDisenoUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_diseno_user', function (Blueprint $table) {
            $table->foreignId('team_diseno_id')->constrained('team_disenos');
            $table->foreignId('user_id')->constrained();
            $table->unique(['team_diseno_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_diseno_user');
    }
}
