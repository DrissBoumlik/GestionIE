<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnCours extends Model
{
    //

    protected $fillable = [
        'agent_traitant',
        'region',
        'Prestataire',
        'nom_tech',
        'prenom_tech',
        'date',
        'creneaux',
        'type',
        'client',
        'as',
        'code_postal',
        'ville',
        'voie',
        'rue',
        'numero_abo',
        'nom_abo',
        'report_multiple',
        'cause_du_report',
        'statut_du_report',
        'statut_final',
        'accord_region',
        'task_type'
    ];
}
