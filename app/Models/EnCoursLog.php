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

        'user_id',
        'en_cours_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(EnCours::class, 'en_cours_id');
    }
}
