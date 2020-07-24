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
            'id' => ['numero_de_lappel_reference_sfr','numero_de_lappel','reference_sfr'],
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
                'numero_de_labonne' => 'numero_de_labonne_reference_client',
                'reference_client' => 'numero_de_labonne_reference_client',
                'station_de_modulation_ville' => 'station_de_modulation_Ville',
                'station_de_modulation' => 'station_de_modulation_Ville',
                'ville' => 'station_de_modulation_Ville',
                'zone_region' => 'zone_region',
                'zone' => 'zone_region',
                'region' => 'zone_region',
                'stit' => 'stit',
                'commune' => 'commune',
                'code_postal' => 'code_postal',
                'numero_de_lappel_reference_sfr' => 'numero_de_lappel_reference_sfr',
                'data_columns' => 'numero_de_lappel_reference_sfr',
                'reference_sfr' => 'numero_de_lappel_reference_sfr',
                'lib_cap_typologie_inter' => 'libcap_typologie_inter',
                'lib_cap' => 'libcap_typologie_inter',
                'typologie_inter' => 'libcap_typologie_inter',
                'date_de_rendez_vous' => 'date_de_rendez_vous',
                'code_md_code_echec' => 'code_md_code_echec',
                'code_md' => 'code_md_code_echec',
                'code_echec' => 'code_md_code_echec',
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
                'statut_final' => 'statut_final',
                'accord_region' => 'accord_region',
            ]
        ]
    ],


    'tasks_options' => [
        'encours' => [
            'columns' => [
                'agent_traitant' => [
                    'title' => 'Agent traitant',
                    'values' => []
                ],
                'cause_du_report' => [
                    'title' => 'Cause du report',
                    'values' => [
                        'Panne en cours',
                        'Prévoir binôme, heures, échelle,…',
                        'Tech absent',
                        'Tech en retard',
                        'Zone à risque',
                        'Report en Prestation complémentaire',
                        'Abo non disponible',
                        'Intemperie',
                        'Manque matériel (modem, HD, B4,…)',
                        'Manque temps',
                        'Nacelle',
                    ]
                ],
                'statut_du_report' => [
                    'title' => 'Statut du report',
                    'values' => [
                        'Tel1',
                        'Non',
                        'Report ok',
                        'Résilié',
                        'Mail region',
                        'S8/R2/R3',
                        'Services ok',
                        'Tel2',
                    ]
                ],
                'accord_region' => [
                    'title' => 'Accord region',
                    'values' => [
                        'OUI',
                        'NON ',
                        'MANQUE DE DECHARGE',
                        'X',
                    ]
                ],
                'statut_final' => [
                    'title' => 'Statut final',
                    'values' => [
                        'TRAITE',
                        'EN COURS',
                    ]
                ],
            ]
        ],
        'instance' => [
            'columns' => [
                'agent_traitant' => [
                    'title' => 'Agent traitant',
                    'values' => []
                ],
                'statut_du_report' => [
                    'title' => 'Statut du report',
                    'values' => [
                        'Tel1',
                        'Non',
                        'Report ok',
                        'Résilié',
                        'Mail region',
                        'S8/R2/R3',
                        'Services ok',
                        'Tel2',
                    ]
                ],
                'statut_final' => [
                    'title' => 'Statut final',
                    'values' => [
                        'TRAITE',
                        'EN COURS',
                    ]
                ]
            ]
        ]
    ],
];
