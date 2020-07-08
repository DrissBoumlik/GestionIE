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
            $table->string('agent_traitant', 100)->nullable();
            $table->string('region', 100)->nullable();
            $table->string('prestataire', 100)->nullable();
            $table->string('nom_tech', 100)->nullable();
            $table->string('prenom_tech', 100)->nullable();
            $table->date('date')->nullable();
            $table->string('creneaux', 100)->nullable();
            $table->string('type', 100)->nullable();
            $table->string('client', 100)->nullable();
            $table->string('as', 100)->nullable();
            $table->string('code_postal', 100)->nullable();
            $table->string('ville', 100)->nullable();
            $table->string('voie', 100)->nullable();
            $table->string('rue')->nullable();
            $table->string('numero_abo', 100)->nullable();
            $table->string('nom_abo', 100)->nullable();
            $table->string('report_multiple', 100)->nullable();
            $table->string('cause_du_report', 100)->nullable();
            $table->string('statut_du_report', 100)->nullable();
            $table->string('accord_region', 100)->nullable();
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
