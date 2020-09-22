<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToEnCoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('en_cours', function (Blueprint $table) {
            $table->dateTime('date_heure_reception')->after('task_type')->nullable();
            $table->string('techno')->after('date_heure_reception')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('en_cours', function (Blueprint $table) {
            $table->dropColumn('date_heure_reception');
            $table->dropColumn('techno');
        });
    }
}
