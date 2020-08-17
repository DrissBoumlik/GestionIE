<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    protected $fillable = [
        'agent_traitant',
        'region',
        'numero_intervention',
        'cdp',
        'num_cdp',
        'type_intervention',
        'client',
        'cp',
        'ville',
        'Sous_type_Inter',
        'date_reception',
        'date_planification',
        'report',
        'motif_report',
        'commentaire_report',
        'statut_finale',
        'nom_tech',
        'prenom_tech',
        'num_tel',
        'adresse_mail',
        'motif_ko',
        'as_j_1',
        'statut_ticket',
        'commentaire'
    ];

    /**
     * Get the user (auth).
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User')->select(array('id', 'lastname'));
    }
}
