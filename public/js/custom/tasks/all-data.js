$(document).ready(function () {
    $('#page-container').addClass('sidebar-mini');

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

    let filterTasks = $('#filter');
    let filterTasksWithStatutFinal=$('#filterStatusFinal');


    $(document).on('change', 'input[name=input-choose]', function () {
        if ($(this).prop('checked')) {
            $(this).prop('checked', false);
            let btnChoose = $('#btn-choose');
            btnChoose.removeAttr('data-id');
            let task_id = $(this).val();
            let data_row = $(this).data('row');
            let data_type = $(this).data('type');
            btnChoose.attr('data-id', task_id);
            btnChoose.attr('data-type', data_type);
            btnChoose.attr('data-row', JSON.stringify(data_row));
            $(`#modal-choose-collaborater`).modal('show');
        } else {
            $(this).prop('checked', true);
            let btnUnaffect = $('#btn-unaffect');
            let task_id = $(this).val();
            let data_row = $(this).data('row');
            let data_type = $(this).data('type');
            let user_id = $(this).data('user_id');
            btnUnaffect.attr('data-id', task_id);
            btnUnaffect.attr('data-row', JSON.stringify(data_row));
            btnUnaffect.attr('data-type', data_type);
            btnUnaffect.attr('data-user_id', user_id);
            $('#modal-unaffect').modal('show');
        }
    });

    $(document).on('click', '#btn-choose', function () {

        let task_id = $(this).attr('data-id');
        let data_row = $(this).data('row');
        let data_type = $(this).data('type');

        $.ajax({
            method: 'POST',
            url: APP_URL + '/api/tasks/' + data_type,
            data: {
                task_id: task_id,
                data_row: data_row,
                user_id: $('#form-choose-collaborater select[name="collaborater"]').val(),
            }, //$('#form-choose-collaborater').serialize(),
            dateType: 'json',
            success: function (data) {
                $('#modal-choose-collaborater').modal('hide');
                let icon = data.success ? 'success' : 'error';
                // tableTasks.datatable.draw(false);
                Swal.fire({
                    // position: 'top-end',
                    type: icon,
                    title: data.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    if (data_type == 'encours') {
                        tasksEncours.elementDT.columns.adjust().draw();
                    } else {
                        tasksInstance.elementDT.columns.adjust().draw();
                    }
                });
            }
        });
    });

    $(document).on('click', '#btn-unaffect', function () {
        let task_id = $(this).attr('data-id');
        let data_row = $(this).data('row');
        let data_type = $(this).data('type');
        let user_id = $(this).data('user_id');
        $.ajax({
            method: 'delete',
            url: APP_URL + '/api/tasks/' + data_type,
            data: {
                task_id: task_id,
                data_row: data_row,
                user_id: user_id,
            },
            dateType: 'json',
            success: function (data) {
                $('#modal-unaffect').modal('hide');
                let icon = data.success ? 'success' : 'error';
                // tableTasks.datatable.draw(false);
                Swal.fire({
                    // position: 'top-end',
                    type: icon,
                    title: data.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    if (data_type == 'encours') {
                        tasksEncours.elementDT.columns.adjust().draw();
                    } else {
                        tasksInstance.elementDT.columns.adjust().draw();
                    }
                });
            }
        });
    });

    $(document).on('click', '.btn-edit', function () {
        let btnUpdateStatut = $('#btn-update-statut');
        let rowData = $(this).closest('tr').find('td:first [name=input-choose]');
        btnUpdateStatut.removeAttr('data-id');
        let task_id = $(this).attr('data-id');
        let data_row = rowData.data('row');
        let data_type = rowData.data('type');
        let data_user_id = rowData.data('user_id');

        btnUpdateStatut.attr('data-id', task_id);
        btnUpdateStatut.attr('data-row', JSON.stringify(data_row));
        btnUpdateStatut.attr('data-type', data_type);
        btnUpdateStatut.attr('data-user_id', data_user_id);

        $('#modal-update').modal('show');
    });

    $(document).on('click', '#btn-update-statut', function () {
        let task_id = $(this).attr('data-id');
        // let statut_final = $('#statut_final').val();
        let data_type = $(this).data('type');
        // let data_row = $(this).data('row');
        let data = {};
        if (data_type == 'encours') {
            let agent_traitant = $('#agent_traitant').val();
            let cause_du_report = $('#cause_du_report').val();
            let statut_du_report = $('#statut_du_report').val();
            let accord_region = $('#accord_region').val();
            let statut_final = $('#statut_final').val();
            data = {...data, agent_traitant, cause_du_report, statut_du_report, accord_region, statut_final};
        } else {
            let agent_traitant = $('#agent_traitant').val();
            let statut_du_report = $('#statut_du_report').val();
            let statut_final = $('#statut_final').val();
            data = {...data, agent_traitant, statut_du_report, statut_final};
        }
        let data_user_id = $(this).data('user_id');
        $.ajax({
            method: 'put',
            url: APP_URL + '/api/tasks/' + data_type,
            data: {
                ...data,
                task_id: task_id,
                user_id: data_user_id
            },
            dateType: 'json',
            success: function (data) {
                $('#modal-update').modal('hide');
                let icon = data.success ? 'success' : 'error';
                // tableTasks.datatable.draw(false);
                Swal.fire({
                    // position: 'top-end',
                    type: icon,
                    title: data.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    if (data_type == 'encours') {
                        tasksEncours.elementDT.columns.adjust().draw();
                    } else {
                        tasksInstance.elementDT.columns.adjust().draw();
                    }
                });
            }
        });
    });

    let TasksEncoursColumns = [
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
        // {data: 'statut_final', title: 'Statut final'},

        {data: 'accord_region', title: 'Accord région'},
        {data: 'task_type', title: 'Type'},
    ];
    let tasksInstanceColumns = [
        {data: 'numero_de_labonne_reference_client', title: 'Numero de l\'abonne / Référence client'},
        {data: 'station_de_modulation_Ville', title: 'Station de Modulation / Ville'},
        {data: 'zone_region', title: 'ZONE / Région'},
        {data: 'stit', title: 'STIT'},
        {data: 'commune', title: 'COMMUNE'},
        {data: 'code_postal', title: 'Code postal'},
        {data: 'numero_de_lappel_reference_sfr', title: 'Numero de l\'appel / Référence SFR'},
        {data: 'libcap_typologie_inter', title: 'LIB_CAP / Typologie Inter'},
        {data: 'date_de_rendez_vous', title: 'Date de rendez-vous'},
        {data: 'code_md_code_echec', title: 'CODE_MD / Code échec'},
        {data: 'agent_traitant', title: 'Agent traitant'},
        {data: 'statut_du_report', title: 'Statut du report'},
        // {data: 'statut_final', title: 'statut final'},
        {data: 'task_type', title: 'Type'},
    ];
   if(filterTasksWithStatutFinal.length){
        TasksEncoursColumns=[
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
            //{data: 'statut_final', title: 'Statut final'},
            {
                data: 'statut_final',
                title: 'Statut final',
                name: 'statut_final',
                className: 'align-middle text-center',
                render: function () {
                    return `<span class="badge badge-success">TRAITE</span>`;
                }
            },
            {data: 'accord_region', title: 'Accord région'},
            {data: 'task_type', title: 'Type'},

        ];
        tasksInstanceColumns = [
            {data: 'numero_de_labonne_reference_client', title: 'Numero de l\'abonne / Référence client'},
            {data: 'station_de_modulation_Ville', title: 'Station de Modulation / Ville'},
            {data: 'zone_region', title: 'ZONE / Région'},
            {data: 'stit', title: 'STIT'},
            {data: 'commune', title: 'COMMUNE'},
            {data: 'code_postal', title: 'Code postal'},
            {data: 'numero_de_lappel_reference_sfr', title: 'Numero de l\'appel / Référence SFR'},
            {data: 'libcap_typologie_inter', title: 'LIB_CAP / Typologie Inter'},
            {data: 'date_de_rendez_vous', title: 'Date de rendez-vous'},
            {data: 'code_md_code_echec', title: 'CODE_MD / Code échec'},
            {data: 'agent_traitant', title: 'Agent traitant'},
            {data: 'statut_du_report', title: 'Statut du report'},
           // {data: 'statut_final', title: 'statut final'},
           {
            data: 'statut_final',
            title: 'Statut final',
            name: 'statut_final',
            className: 'align-middle text-center',
            render: function () {
                return `<span class="badge badge-success">TRAITE</span>`;
            }},
            {data: 'task_type', title: 'Type'},
        ]}
    if (filterTasks.length) {
        TasksEncoursColumns = [
            {
                data: null, className: 'align-middle text-center', orderable: false, searchable: false,
                render: function (data, type, row, meta) {
                    // if (!meta.settings.json.admin && data.acteur && meta.settings.json.acteur !== data.acteur) {
                    //     return '-----';
                    // }
                    let checked = row.statut_final.text != "A effectuer" ? 'checked' : '';
                    let taskLogId = row.taskLog_id ? "data-taskLog_id='" + row.taskLog_id + "'" : '';
                    let userId = row.user ? "data-user_id='" + row.user.id + "'" : '';
                    return "<div class='custom-control custom-switch text-center'>" +
                        "<input data-type='encours' " + taskLogId + " " + userId + " data-row='" + JSON.stringify(row) + "' type='checkbox' class='custom-control-input' " +
                        "value='" + data.id + "' id='input-choose-" + data.id + "' name='input-choose' " + checked + ">" +
                        "<label class='custom-control-label' for='input-choose-" + data.id + "'></label>" +
                        "</div>";
                }
            },
            {
                data: 'user', name: 'user', title: 'Utilisateur',
                render: function (data, type, row, meta) {
                    return data && row.statut_final.text != "A effectuer" ? data.firstname : '';
                }
            },
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
            // {data: 'statut_final', title: 'Statut final'},
            {
                data: 'statut_final',
                title: 'Statut final',
                name: 'statut_final',
                className: 'align-middle text-center',
                render: function (data) {
                    return `<span class="${data.className}">${data.text}</span>`;
                }
            },

            {data: 'accord_region', title: 'Accord région'},
            {data: 'task_type', title: 'Type'},
            {
                data: null, title: 'Action', className: 'align-middle text-center', orderable: false, searchable: false,
                render: function (data, type, row, meta) {
                    if (row.statut_final.text == "A effectuer") {
                        return '<span style="white-space: nowrap">-----</span>';
                    }
                    // if((!meta.settings.json.admin && data.acteur && meta.settings.json.acteur !== data.acteur) || data.statut_eb.id === 'aaffecter') {
                    //     return '-----';
                    // }

                    let dropDown = `<div class="dropdown">
                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" id="dropdown-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>`;
                    dropDown += `<div class="dropdown-menu font-size-sm" aria-labelledby="dropdown-default-primary" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">`;
                    dropDown += `<a class="dropdown-item" href="#"><i class="fa fa-fw fa-download"></i> Télécharger</a>`;
                    dropDown += `<a class="dropdown-item btn-edit" href="javascript:void(0)" data-id="${data.id}"><i class="fa fa-fw fa-pencil-alt"></i> Modifier</a>`;
                    dropDown += `<a class="dropdown-item btn-view-history" data-type="EnCours" data-toggle="modal" data-target="#modal-history" href="javascript:void(0)" data-id="${data.id}"><i class="fa fa-fw fa-history"></i> Visualiser l'Historique</a>`;

                    // if(data.statut_eb.id !== 'encours') {
                    //     dropDown += `<a class="dropdown-item btn-send" href="javascript:void(0)" data-id="${data.id}"><i class="fa fa-fw fa-paper-plane"></i> Envoyer</a>`;
                    // }

                    dropDown += `<a class="dropdown-item btn-delete" href="javascript:void(0)" data-id="${data.id}"><i class="fa fa-fw fa-trash"></i> Supprimer</a></div>`;
                    dropDown += `</div>`;
                    return dropDown;

                    // if (data.statut_eb === 'encours') {
                    //     return `<button type="button" class="btn btn-sm btn-edit btn-outline-primary" data-id="${data.id}"><i class="fa fa-fw fa-pencil-alt"></i></button>`;
                    // }
                    // return `<div class="btn-group btn-group-sm">
                    //     <button type="button" class="btn btn-edit btn-outline-primary" data-id="${data.id}"><i class="fa fa-fw fa-pencil-alt"></i></button>
                    //     <button type="button" class="btn btn-send btn-outline-primary" data-id="${data.id}"><i class="fa fa-fw fa-paper-plane"></i></button>
                    //     </div>`;
                }
            }
        ];
        tasksInstanceColumns = [
            {
                data: null, className: 'align-middle text-center', orderable: false, searchable: false,
                render: function (data, type, row, meta) {
                    // if (!meta.settings.json.admin && data.acteur && meta.settings.json.acteur !== data.acteur) {
                    //     return '-----';
                    // }
                    let checked = row.statut_final.text != "A effectuer" ? 'checked' : '';
                    let taskLogId = row.taskLog_id ? "data-taskLog_id='" + row.taskLog_id + "'" : '';
                    let userId = row.user ? "data-user_id='" + row.user.id + "'" : '';
                    return "<div class='custom-control custom-switch text-center'>" +
                        "<input data-type='instance' " + taskLogId + " " + userId + " data-row='" + JSON.stringify(row) + "' type='checkbox' class='custom-control-input' " +
                        "value='" + data.id + "' id='input-choose-" + data.id + "' name='input-choose' " + checked + ">" +
                        "<label class='custom-control-label' for='input-choose-" + data.id + "'></label>" +
                        "</div>";
                }
            },
            {
                data: 'user', name: 'user', title: 'Utilisateur',
                render: function (data, type, row, meta) {
                    return data && row.statut_final.text != "A effectuer" ? data.firstname : '';
                }
            },
            {data: 'numero_de_labonne_reference_client', title: 'Numero de l\'abonne / Référence client'},
            {data: 'station_de_modulation_Ville', title: 'Station de Modulation / Ville'},
            {data: 'zone_region', title: 'ZONE / Région'},
            {data: 'stit', title: 'STIT'},
            {data: 'commune', title: 'COMMUNE'},
            {data: 'code_postal', title: 'Code postal'},
            {data: 'numero_de_lappel_reference_sfr', title: 'Numero de l\'appel / Référence SFR'},
            {data: 'libcap_typologie_inter', title: 'LIB_CAP / Typologie Inter'},
            {data: 'date_de_rendez_vous', title: 'Date de rendez-vous'},
            {data: 'code_md_code_echec', title: 'CODE_MD / Code échec'},
            {data: 'agent_traitant', title: 'Agent traitant'},
            {data: 'statut_du_report', title: 'Statut du report'},
            // {data: 'statut_final', title: 'statut final'},
            {
                data: 'statut_final',
                title: 'Statut final',
                name: 'statut_final',
                className: 'align-middle text-center',
                render: function (data) {
                    return `<span class="${data.className}">${data.text}</span>`;
                }
            },
            {data: 'task_type', title: 'Type'},
            {
                data: null, className: 'align-middle text-center', orderable: false, searchable: false,
                render: function (data, type, row, meta) {
                    if (row.statut_final.text == "A effectuer") {
                        return '<span style="white-space: nowrap">-----</span>';
                    }
                    // if((!meta.settings.json.admin && data.acteur && meta.settings.json.acteur !== data.acteur) || data.statut_eb.id === 'aaffecter') {
                    //     return '-----';
                    // }

                    let dropDown = `<div class="dropdown">
                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" id="dropdown-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>`;
                    dropDown += `<div class="dropdown-menu font-size-sm" aria-labelledby="dropdown-default-primary" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">`;
                    dropDown += `<a class="dropdown-item" href="#"><i class="fa fa-fw fa-download"></i> Télécharger</a>`;
                    dropDown += `<a class="dropdown-item btn-edit" href="javascript:void(0)" data-id="${data.id}"><i class="fa fa-fw fa-pencil-alt"></i> Modifier</a>`;
                    dropDown += `<a class="dropdown-item btn-view-history" data-type="Instance" data-toggle="modal" data-target="#modal-history" href="javascript:void(0)" data-id="${data.id}"><i class="fa fa-fw fa-history"></i> Visualiser l'Historique</a>`;

                    // if(data.statut_eb.id !== 'encours') {
                    //     dropDown += `<a class="dropdown-item btn-send" href="javascript:void(0)" data-id="${data.id}"><i class="fa fa-fw fa-paper-plane"></i> Envoyer</a>`;
                    // }

                    dropDown += `<a class="dropdown-item btn-delete" href="javascript:void(0)" data-id="${data.id}"><i class="fa fa-fw fa-trash"></i> Supprimer</a></div>`;
                    dropDown += `</div>`;
                    return dropDown;

                    // if (data.statut_eb === 'encours') {
                    //     return `<button type="button" class="btn btn-sm btn-edit btn-outline-primary" data-id="${data.id}"><i class="fa fa-fw fa-pencil-alt"></i></button>`;
                    // }
                    // return `<div class="btn-group btn-group-sm">
                    //     <button type="button" class="btn btn-edit btn-outline-primary" data-id="${data.id}"><i class="fa fa-fw fa-pencil-alt"></i></button>
                    //     <button type="button" class="btn btn-send btn-outline-primary" data-id="${data.id}"><i class="fa fa-fw fa-paper-plane"></i></button>
                    //     </div>`;
                }
            }

        ];
    }

    let tasksEncours = {
        element: 'tasksEncours',
        elementDT: undefined,
        route: filterTasks.length ? '/api/tasks/filter/' + filterTasks.data('filter') + '/EnCours' : filterTasksWithStatutFinal.length ? '/api/tasks/traite/EnCours' : '/api/tasks/data/EnCours',
        refreshBtn: '#refreshTasksEnCours',
        columns: TasksEncoursColumns,
        history: {
            elementDT: undefined,
            route: filterTasks.length ? '/api/tasks/history/' + filterTasks.data('filter') + '/EnCours' : '/api/tasks/history/EnCours',
            columns: [
                {data: 'agent_traitant', title: 'Agent traitant', name: 'agent_traitant'},
                {data: 'cause_du_report', title: 'Cause du report', name: 'cause_du_report'},
                {data: 'statut_du_report', title: 'Statut du report', name: 'statut_du_report'},
                {data: 'accord_region', title: 'Accord région', name: 'accord_region'},
                {data: 'statut_final', title: 'Statut final', name: 'statut_final'},
                {data: 'updated_at', title: 'Quand', name: 'updated_at'},
            ]
        }
    };

    let tasksInstance = {
        element: 'tasksInstance',
        elementDT: undefined,
        route: filterTasks.length ? '/api/tasks/filter/' + filterTasks.data('filter') + '/Instance': filterTasksWithStatutFinal.length ? '/api/tasks/traite/Instance' : '/api/tasks/data/Instance',
        refreshBtn: '#refreshTasksInstance',
        columns: tasksInstanceColumns,
        history: {
            elementDT: undefined,
            route: filterTasks.length ? '/api/tasks/history/' + filterTasks.data('filter') + '/Instance' : '/api/tasks/history/Instance',
            columns: [
                {data: 'agent_traitant', title: 'Agent traitant', name: 'agent_traitant'},
                {data: 'statut_du_report', title: 'Statut du report', name: 'statut_du_report'},
                {data: 'statut_final', title: 'Statut final', name: 'statut_final'},
                {data: 'updated_at', title: 'Quand', name: 'updated_at'},
                // {
                //     data: 'user', name: 'user', title: 'Utilisateur',
                //     render: function (data, type, row, meta) {
                //         return data ? data.firstname : '';
                //     }
                // }
            ]
        }
    };

    if (elementExists(tasksEncours)) {
        InitDataTable(tasksEncours, data);
        $('#refreshTasksEnCours').on('click', function () {
            refreshDt(tasksEncours, data);
        });
    }
    if (elementExists(tasksInstance)) {
        InitDataTable(tasksInstance, data);
        $('#refreshTasksInstance').on('click', function () {
            refreshDt(tasksInstance, data)
        });
    }

    function refreshDt(object, data) {
        if (dates) {
            data.dates = dates.join(',');
        }
        data.refreshMode = true;
        InitDataTable(object, data);
    }

    function InitDataTable(object, data) {
        if ($.fn.DataTable.isDataTable(object.elementDT)) {
            object.elementDT.destroy();
        }
        toggleLoader($(object.refreshBtn).parents('.col-12'));
        let table = $('#' + object.element);
        // table.DataTable().destroy();
        object.elementDT = table.DataTable({

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

    // let historyData = $('.historyPreview');
    // let historyPreview = $('.btn-view-history');
    $(document).on('click', '.historyPreview', function () {
        let type = $(this).data('type').toLowerCase();
        getHistoryTasks(type === 'encours' ? tasksEncours : tasksInstance);
    });

    $(document).on('click', '.btn-view-history', function () {
        let rowData = $(this).closest('tr').find('td:first [name=input-choose]');
        let type = $(this).data('type').toLowerCase();
        let data_row = rowData.data('row');
        let data_type = rowData.data('type');
        console.log(this, data_row, data_type, type);
        getHistoryTasks(type === 'encours' ? tasksEncours : tasksInstance, {task_id: data_row.id});
    });

    function getHistoryTasks(object, data = null) {
        if ($.fn.DataTable.isDataTable(object.history.elementDT)) {
            object.history.elementDT.destroy();
        }
        // toggleLoader($(object.refreshBtn).parents('.col-12'));
        let table = $('#historyPreview');
        // table.DataTable().destroy();
        object.history.elementDT = table.DataTable({

            destroy: true,
            responsive: true,
            searching: true,

            language: frLang,
            pageLength: 10,
            processing: true,
            serverSide: true,
            ajax: {
                type: 'GET',
                url: APP_URL + object.history.route + '/' + (data ? data.task_id : ''),
            },
            columns: object.history.columns,
            initComplete: function (settings, response) {
                // toggleLoader($(object.refreshBtn).parents('.col-12'), true);
            }

        });
    }

});
