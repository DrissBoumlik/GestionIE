<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Custom Parameters
    |--------------------------------------------------------------------------
    |
    | This is a user custom file where you can store values to
    | be used as parameters for the application globally
    */

    /* while importing the table destination choice
    | should be sent with the request so you can
    | just use the index to access the columns
    | you want without if/else conditions
    */
    'tables_data' => [
        0 => [
            'table' => 'instance',
            'class' => 'Instance',
            'id' => 'numero_de_lappel_reference_sfr',
            'date_filter' => 'date_de_rendez_vous',
            'data_columns' => [
                'numero_de_labonnereference_client' => 'Numero de l\'abonne/Référence client',
                'numero_de_lappel_reference_sfr' => 'Numero de l\'appel / Référence SFR',
                'lib_cap_typologie_inter' => 'LIB_CAP / Typologie Inter'
            ],
            'columns' => [
                // columns for the "INSTANCE" table
//            'numero_de_labonne_reference_client',
//            'station_de_modulation_Ville',
//            'zone_region',
//            'stit',
//            'commune',
//            'code_postal',
//            'numero_de_lappel_reference_sfr',
//            'libcap_typologie_inter',
//            'date_de_rendez_vous',
//            'code_md_code_echec',
//            'agent_traitant',
//            'statut_du_report',
//            'statut_final'
                'numero_de_labonnereference_client' => 'numero_de_labonne_reference_client',
                'station_de_modulation_ville' => 'station_de_modulation_Ville',
                'zone_region' => 'zone_region',
                'stit' => 'stit',
                'commune' => 'commune',
                'code_postal' => 'code_postal',
                'numero_de_lappel_reference_sfr' => 'numero_de_lappel_reference_sfr',
                'lib_cap_typologie_inter' => 'libcap_typologie_inter',
                'date_de_rendez_vous' => 'date_de_rendez_vous',
                'code_md_code_echec' => 'code_md_code_echec',
                'agent_traitant' => 'agent_traitant',
                'statut_du_report' => 'statut_du_report',
                'statut_final' => 'statut_final'
            ]

        ],
        1 => [
            'table' => 'en_cours',
            'class' => 'EnCours',
            'id' => 'as',
            'date_filter' => 'date',
            'data_columns' => [
                'prestataire' => 'Prestataire',
                'as' => 'AS',
                'client' => 'Client'
            ],
            'columns' => [
                // columns for the "EN COURS" table
//            'agent_traitant',
//            'region',
//            'prestataire',
//            'nom_tech',
//            'prenom_tech',
//            'date',
//            'creneaux',
//            'type',
//            'client',
//            'as',
//            'code_postal',
//            'ville',
//            'voie',
//            'rue',
//            'numero_abo',
//            'nom_abo',
//            'report_multiple',
//            'cause_du_report',
//            'statut_du_report',
//            'accord_region',
                'agent_traitant' => 'agent_traitant',
                'region' => 'region',
                'prestataire' => 'prestataire',
                'nom_tech' => 'nom_tech',
                'prenom_tech' => 'prenom_tech',
                'date' => 'date',
                'creneaux' => 'creneaux',
                'type' => 'type',
                'client' => 'client',
                'as' => 'as',
                'code_postal' => 'code_postal',
                'ville' => 'ville',
                'voie' => 'voie',
                'rue' => 'rue',
                'numero_abo' => 'numero_abo',
                'nom_abo' => 'nom_abo',
                'report_multiple' => 'report_multiple',
                'cause_du_report' => 'cause_du_report',
                'statut_du_report' => 'statut_du_report',
                'accord_region' => 'accord_region',
            ]
        ]
    ],
];
