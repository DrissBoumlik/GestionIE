(($) => {
    $(document).on("preInit.dt", function(){
        $(".dataTables_filter input[type='search']").attr("maxlength", 190);
    });
    // Initialization
    const table = $('#ticketsEncours').DataTable( {
        "language": {
            "url": `${APP_URL}/json/jquery.dataTables.fr.l10n.json`
        },
        "responsive": true,
        "autoWidth": false,
        "processing": true,
        "serverSide": true,
        "order": [[0, 'desc']],
        "ajax": {
            "type": "POST",
            "url": `${APP_URL}/b2bSfr/tickets/getTickets/En cours`,
            "dataSrc": "data"
        },
        columns: [
            {"data": "id", "title": "id" , "name" : "id"},
            {"data": "agent_traitant", "title": "agent traitant", "name" :"agent_traitant"},
            {'data': 'region','title' :'region' , "name" :"agent_traitant"},
            {'data':'numero_intervention','title' :'numéro intervention' , "name" :'numero_intervention'},
            {'data' : 'cdp' , 'title' : 'cdp' , "name" :'cdp'},
            {'data' : 'num_cdp', 'title':'num cdp' , "name" :'num_cdp'},
            {'data' : 'type_intervention', 'title':'type intervention' , "name" :'type_intervention'},
            {'data' : 'client', 'title':'client' , "name" :'client'},
            {'data' : 'cp', 'title':'cp' , "name" :'cp'},
            {'data' : 'Ville', 'title':'Ville' , "name" :'Ville'},
            {'data' : 'Sous_type_Inter', 'title':'Sous type Inter' , "name" :'Sous_type_Inter'},
            {'data' : 'date_reception', 'title':'date reception' , "name" :'date_reception'},
            {'data' : 'date_planification', 'title':'dateplanification' , "name" :'date_planification'},
            {'data' : 'report', 'title':'report' , "name" :'report'},
            {'data' : 'commentaire_report', 'title':'commentaire_report' , "name" :'commentaire_report'},
            {'data' : 'motif_report', 'title':'motif_report' , "name" :'motif_report'},
            {'data' : 'statut_finale', 'title':'statut_finale' , "name" :'statut_finale'},
            {'data' : 'nom_tech', 'title':'nom_tech' , "name" :'nom_tech'},
            {'data' : 'prenom_tech', 'title':'prenom_tech' , "name" :'prenom_tech'},
            {'data' : 'num_tel', 'title':'num_tel', "name" :'num_tel'},
            {'data' : 'adresse_mail', 'title':'adresse_mail', "name" :'adresse_mail'},
            {'data' : 'motif_ko', 'title':'motif_ko', "name" :'motif_ko'},
            {'data' : 'as_j_1', 'title':'as_j_1', "name" :'as_j_1'},
            {'data' : 'statut_ticket', 'title':'statut_ticket', "name" :'statut_ticket'},
            {'data' : 'commentaire', 'title':'commentaire', "name" :'commentaire'},
            {
                data: null, title: 'Action', className: 'align-middle text-center', orderable: false, searchable: false,
                render: function (data, type, row, meta) {
                    let dropDown = `<div class="dropdown">
                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" id="dropdown-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>`;
                    dropDown += `<div class="dropdown-menu font-size-sm" aria-labelledby="dropdown-default-primary" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">`;
                    dropDown += `<a class="dropdown-item btn-edit" href="javascript:void(0)" data-id="${data.id}"><i class="fa fa-fw fa-pencil-alt"></i> Modifier</a>`;
                    dropDown += `<a class="dropdown-item btn-view-history" data-type="En Cours" data-toggle="modal" data-target="#modal-history" href="javascript:void(0)" data-id="${data.id}"><i class="fa fa-fw fa-history"></i> Visualiser l'Historique</a>`;
                    dropDown += `</div>`;
                    return dropDown;
                }
            }
        ],
        columnDefs: [{
            'targets': [6],
            'orderable': false,
            'searchable': false
        },
            {
                'targets': [0],
                'visible': false
            }
        ],
        "displayLength": 10,

    } );

    $(document).on('click','.btn-edit',function () {
        const $row = $(this).closest('tr');
        const data =  $('#ticketsEncours').DataTable().row($row).data();
        editTicketModal($(this).data('id'), data);
        $('#modal-edit-ticket').modal('show');
    });

    $(document).on('click','.btn-view-history',function () {
        const $row = $(this).closest('tr');
        const data =  $('#ticketsEncours').DataTable().row($row).data();
        getTicketHistorique(data);
        $('#modal-ticket-history').modal('show');
    });

    $(document).on('click','#submit-ticket-form',function (e) {
            let values = $('#tickets-edit-form').serializeArray();
            let formData = values.reduce(function(obj, item) {
                if(item.value){
                    obj[item.name] = item.value;
                }
                return obj;
            }, {});
            if(formData.statut_finale === 'ok'){
                formData.motif_ko =null;
                formData.motif_report=null;
            }
            editTicketService(formData);
    });

    $(document).on('submit', '#tickets-edit-form', (e) => e.preventDefault());

    const editTicketModal = (id, data) =>{
        $('#id').val(data.id);
        $('#agent_traitant').val(data.agent_traitant);
        $('#statut_finale').val(data.statut_finale).trigger('change.select2');
        $('#motif_ko').val(data.motif_ko).trigger('change.select2');
        $('#motif_report').val(data.motif_report).trigger('change.select2');
        $('#as_j_1').val(data.as_j_1).trigger('change.select2');
        $('#statut_ticket').val(data.statut_ticket).trigger('change.select2');
        $('#commentaire_report').text(data.commentaire_report);
        $('#commentaire').text(data.commentaire);
    };

    $('#statut_finale').on('change.select2',function () {

        let statut = $(this).children("option:selected").val();
        if(statut === 'ko'){
            $('.motif_handler').removeClass("d-none")
        }else{
            $('.motif_handler').addClass("d-none");
        }

    });

    $('select option:first-child').attr("disabled", "true");

})(jQuery);

const editTicketService = (data) => {

    let id = data.id;
    let url = `${APP_URL}/b2bSfr/tickets/updateTicket/${id}`;
    let successMessage = `Le ticket est bien modifié.`;
    let failMessage = `Le ticket n'est pas modifié!`;

        $.ajax({
            method: 'PUT',
            url: url,
            data: data,
            success: (data) => {
                Swal.fire({
                    icon: 'success',
                    text: successMessage,
                });
                $('#modal-edit-ticket').modal('hide');
                $('#ticketsEncours').DataTable().ajax.reload(null, false);
            },
            error: (err) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: failMessage,
                });
            }
        });

};


const getTicketHistorique = (data) =>{
    let tabledata = $('#ticketsHistory');
    if($.fn.DataTable.isDataTable(tabledata)){
        tabledata.DataTable().destroy();
    }
    const table = tabledata.DataTable( {
        "language": {
            "url": `${APP_URL}/json/jquery.dataTables.fr.l10n.json`
        },
        "responsive": true,
        "autoWidth": false,
        "processing": true,
        "serverSide": true,
        "order": [[0, 'desc']],
        "ajax": {
            "type": "GET",
            "url": `${APP_URL}/b2bSfr/tickets/getTicketHistory/${data.id}`,
            "dataSrc": "data"
        },
        columns: [
            {"data": "agent_traitant", "title": "agent traitant", "name" :"agent_traitant"},
            {'data' : 'motif_report', 'title':'motif_report' , "name" :'motif_report'},
            {'data' : 'statut_finale', 'title':'statut_finale' , "name" :'statut_finale'},
            {'data' : 'motif_ko', 'title':'motif_ko', "name" :'motif_ko'},
            {'data' : 'commentaire_report', 'title':'commentaire_report' , "name" :'commentaire_report'},
            {'data' : 'as_j_1', 'title':'as_j_1', "name" :'as_j_1'},
            {'data' : 'statut_ticket', 'title':'statut_ticket', "name" :'statut_ticket'},
            {'data' : 'commentaire', 'title':'commentaire', "name" :'commentaire'},
            {'data' : 'created_at', 'title':'quand', "name" :'created_at'},
        ],
    } );
};
