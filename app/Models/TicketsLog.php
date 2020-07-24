<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketsLog extends Model
{
    protected $fillable = [
        'agent_traitant',
        'motif_report',
        'commentaire_report',
        'statut_finale',
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
        return $this->belongsTo('App\User');
    }

}
