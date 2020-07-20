<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstanceLog extends Model
{
    //

    protected $fillable = [
        'agent_traitant',
        'statut_du_report',
        'statut_final'
    ];
}
