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
            $table->bigIncrements('id');
            $table->integer('agent_traitant');
            $table->string('region',20);
            $table->string('numero_intervention',20);
            $table->string('cdp',50);
            $table->string('num_cdp',20);
            $table->string('type_intervention',20);
            $table->string('client',50);
            $table->string('cp',5);
            $table->string('Ville',50);
            $table->string('Sous_type_Inter',30);
            $table->dateTime('date_reception');
            $table->dateTime('date_planification');
            $table->dateTime('report');
            $table->string('motif_report',20);
            $table->text('commentaire_report');
            $table->string('statut_finale',20);
            $table->string('nom_tech',20);
            $table->string('prenom_tech',20);
            $table->string('num_tel',15);
            $table->string('adresse_mail',30);
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
        Schema::dropIfExists('tickets');
    }
}
