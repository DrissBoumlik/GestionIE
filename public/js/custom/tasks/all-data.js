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

    let tasks = {
        element: 'tasks',
        elementDT: undefined
    };
    tasks.elementDT = InitDataTable(tasks, data);
    let refreshBtn = $('#refreshAllTasks');
    refreshBtn.on('click', function () {
        if (dates) {
            data.dates = dates.join(',');
        }
        data.refreshMode = true;
        tasks.elementDT = InitDataTable(tasks, data);
    });

    function InitDataTable(object, data) {
        toggleLoader($('#refreshAllTasks').parents('.col-12'));
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
                url: APP_URL + `/api/tasks/EnCours/data`,
                data: data
            },
            columns: [
                {data: 'agent_traitant', title: 'Agent traitant'},
                {data: 'region', title: 'Région'},
                {data: 'Prestataire', title: 'Prestataire'},
                {data: 'nome_tech', title: 'Nom Tech'},
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
                {data: 'cause_report', title: 'Cause du report'},
                {data: 'statut_report', title: 'Statut du report'},
                {data: 'accord_region', title: 'Accord région'},

            ],
            initComplete: function (settings, response) {
                toggleLoader(refreshBtn.parents('.col-12'), true);
            }

        });
    }

});
