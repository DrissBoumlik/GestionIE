<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnCoursLog extends Model
{
    //

    protected $fillable = [
        'agent_traitant',
        'cause_du_report',
        'statut_du_report',
        'accord_region',
        'statut_final',
    ];
}
