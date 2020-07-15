$(document).ready(function () {

    let dates = undefined;
    /*
    $.ajax({
        url: APP_URL + '/dates',
        method: 'GET',
        success: function (response) {
            let treeData = response.dates;

            $('.tree-view').each(function (index, item) {
                let treeId = '#' + $(this).attr('id');
                new Tree(treeId, {
                    data: [{id: '-1', text: 'Dates', children: treeData}],
                    closeDepth: 1,
                    loaded: function () {
                        let _this = this;
                        if (data.dates) {
                            _this.values = data.dates.split(',')
                        } else {
                            $.ajax({
                                url: APP_URL + '/stats/filter',
                                method: 'GET',
                                success: function (response) {
                                    if (response) {
                                        let allStatsFilter = response.allStatsFilter;
                                        if (allStatsFilter) {
                                            _this.values = allStatsFilter.date_filter || [];
                                        }
                                    }
                                }
                            });
                        }
                    },
                    onChange: function () {
                        dates = this.values;
                    }
                });
            });
            $('.treejs-node .treejs-nodes .treejs-switcher').click();
            $('.refresh-form button').removeClass('d-none');
        },
        error: function (jqXHR, textStatus, errorThrown) {
        }
    });
*/
    let data = $('#data-request').data('request');

    let tasksEncours = {
        element: 'tasksEncours',
        elementDT: undefined,
        route: '/api/tasks/EnCours/data',
        refreshBtn: '#refreshTasksEnCours',
        columns: [
            {data: 'agent_traitant', title: 'Agent traitant'},
            {data: 'region', title: 'Région'},
            {data: 'prestataire', title: 'Prestataire'},
            {data: 'nom_tech', title: 'Nom Tech'},
            {data: 'prenom_tech', title: 'Prénom Tech'},
            {data: 'date', title: 'Date'},
            {data: 'creneaux', title: 'Creneaux'},
            {data: 'type', title: 'Type'},
            {data: 'client', title: 'Client'},
            {data: 'as', title: 'AS'},
            {data: 'code_postal', title: 'Code Postal'},
            {data: 'ville', title: 'Ville'},
            {data: 'voie', title: 'Voie'},
            {data: 'rue', title: 'Rue'},
            {data: 'numero_abo', title: 'Numéro Abo'},
            {data: 'nom_abo', title: 'Nom Abo'},
            {data: 'report_multiple', title: 'Report multiple'},
            {data: 'cause_du_report', title: 'Cause du report'},
            {data: 'statut_du_report', title: 'Statut du report'},
            {data: 'accord_region', title: 'Accord région'},

        ]
    };
    let tasksInstance = {
        element: 'tasksInstance',
        elementDT: undefined,
        route: '/api/tasks/Instance/data',
        refreshBtn: '#refreshTasksInstance',
        columns: [
            {data: 'numero_de_labonne_reference_client', title: 'Numero de l\'abonne / Référence client    '},
            {data: 'station_de_modulation_Ville', title: 'Station de Modulation / Ville'},
            {data: 'zone_region', title: 'ZONE / Région'},
            {data: 'stit', title: 'STIT'},
            {data: 'commune', title: 'COMMUNE'},
            {data: 'code_postal', title: 'Code postal'},
            {data: 'numero_de_lappel_reference_sfr', title: 'Numero de l\'appel / Référence SFR    '},
            {data: 'libcap_typologie_inter', title: 'LIB_CAP / Typologie Inter'},
            {data: 'date_de_rendez_vous', title: 'Date de rendez-vous'},
            {data: 'code_md_code_echec', title: 'CODE_MD / Code échec'},
            {data: 'agent_traitant', title: 'Agent traitant'},
            {data: 'statut_du_report', title: 'Statut du report'},
            {data: 'statut_final', title: 'statut final'},

        ]
    };


    tasksEncours.elementDT = InitDataTable(tasksEncours, data);
    tasksInstance.elementDT = InitDataTable(tasksInstance, data);


    $('#refreshTasksEnCours').on('click', function () {
        refreshDt(tasksEncours, data);
    });
    $('#refreshTasksInstance').on('click', function () {
        refreshDt(tasksInstance, data)
    });

    function refreshDt(object, data) {
        if (dates) {
            data.dates = dates.join(',');
        }
        data.refreshMode = true;
        object.elementDT = InitDataTable(object, data);
    }

    function InitDataTable(object, data) {
        toggleLoader($(object.refreshBtn).parents('.col-12'));
        let table = $('#' + object.element);
        // table.DataTable().destroy();
        return table.DataTable({

            destroy: true,
            responsive: true,
            searching: true,

            language: frLang,
            pageLength: 10,
            processing: true,
            serverSide: true,
            ajax: {
                type: 'POST',
                url: APP_URL + object.route,
                data: data
            },
            columns: object.columns,
            initComplete: function (settings, response) {
                toggleLoader($(object.refreshBtn).parents('.col-12'), true);
            }

        });
    }

});
