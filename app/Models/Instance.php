<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{
    //
    protected $table = 'instance';

    protected $fillable = [
        'numero_de_labonne_reference_client',
        'station_de_modulation_Ville',
        'zone_region',
        'stit',
        'commune',
        'code_postal',
        'numero_de_lappel_reference_sfr',
        'libcap_typologie_inter',
        'date_de_rendez_vous',
        'code_md_code_echec',
        'agent_traitant',
        'statut_du_report',
        'statut_final'
    ];
}
