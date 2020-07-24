<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ticket_id');
            $table->integer('agent_traitant');
            $table->string('motif_report',20)->nullable();
            $table->text('commentaire_report')->nullable();
            $table->string('statut_finale',20);
            $table->string('motif_ko',20)->nullable();
            $table->string('as_j_1',5);
            $table->string('statut_ticket',20);
            $table->text('commentaire');
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
        Schema::dropIfExists('tickets_logs');
    }
}
