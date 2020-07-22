<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstanceLog extends Model
{
    //

    protected $fillable = [
        'agent_traitant',
        'statut_du_report',
        'statut_final',

        'user_id',
        'instance_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Instance::class, 'instance_id');
    }
}
