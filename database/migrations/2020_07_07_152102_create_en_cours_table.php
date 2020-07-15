<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnCoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('en_cours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('agent_traitant', 50)->nullable();
            $table->string('region', 50)->nullable();
            $table->string('prestataire', 50)->nullable();
            $table->string('nom_tech', 50)->nullable();
            $table->string('prenom_tech', 50)->nullable();
            $table->date('date')->nullable();
            $table->string('creneaux', 50)->nullable();
            $table->string('type', 50)->nullable();
            $table->string('client', 50)->nullable();
            $table->string('as', 50)->nullable();
            $table->string('code_postal', 50)->nullable();
            $table->string('ville', 50)->nullable();
            $table->string('voie', 50)->nullable();
            $table->string('rue', 100)->nullable();
            $table->string('numero_abo', 50)->nullable();
            $table->string('nom_abo', 50)->nullable();
            $table->string('report_multiple', 50)->nullable();
            $table->string('cause_du_report', 50)->nullable();
            $table->string('statut_du_report', 50)->nullable();
            $table->string('accord_region', 50)->nullable();
            $table->boolean('isNotReady')->nullable();
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
        Schema::dropIfExists('encours');
    }
}
