<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstanceLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instance_logs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('agent_traitant', 50)->nullable();
            $table->string('statut_du_report', 50)->nullable();
            $table->string('statut_final', 50)->nullable();


            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('instance_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('instance_id')->references('id')->on('instance');

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
        Schema::dropIfExists('instance_logs');
    }
}
