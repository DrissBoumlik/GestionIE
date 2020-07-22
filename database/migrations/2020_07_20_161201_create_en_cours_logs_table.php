<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnCoursLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('en_cours_logs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('agent_traitant', 50)->nullable();
            $table->string('cause_du_report', 50)->nullable();
            $table->string('statut_du_report', 50)->nullable();
            $table->string('accord_region', 50)->nullable();
            $table->string('statut_final', 50)->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('en_cours_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('en_cours_id')->references('id')->on('en_cours');

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
        Schema::dropIfExists('encours_logs');
    }
}
