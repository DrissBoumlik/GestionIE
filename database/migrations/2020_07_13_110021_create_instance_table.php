<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numero_de_labonne_reference_client', 50)->nullable();
            $table->string('station_de_modulation_Ville', 50)->nullable();
            $table->string('zone_region', 50)->nullable();
            $table->string('stit', 50)->nullable();
            $table->string('commune', 50)->nullable();
            $table->string('code_postal', 50)->nullable();
            $table->string('numero_de_lappel_reference_sfr', 50)->nullable();
            $table->string('libcap_typologie_inter', 50)->nullable();
            $table->date('date_de_rendez_vous')->nullable();
            $table->string('code_md_code_echec', 50)->nullable();
            $table->string('agent_traitant', 50)->nullable();
            $table->string('statut_du_report', 50)->nullable();
            $table->string('statut_final', 50)->nullable();
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
        Schema::dropIfExists('instances');
    }
}
