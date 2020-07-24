(($) => {
    $(document).on("preInit.dt", function(){
        $(".dataTables_filter input[type='search']").attr("maxlength", 190);
    });
    // Initialization
    const table = $('#ticketsClosed').DataTable( {
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
            "url": `${APP_URL}/b2bSfr/tickets/getTickets/Clôturé`,
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
            {'data' : 'motif_report', 'title':'motif_report' , "name" :'motif_report'},
            {'data' : 'statut_finale', 'title':'statut_finale' , "name" :'statut_finale'},
            {'data' : 'nom_tech', 'title':'nom_tech' , "name" :'nom_tech'},
            {'data' : 'prenom_tech', 'title':'prenom_tech' , "name" :'prenom_tech'},
            {'data' : 'num_tel', 'title':'num_tel', "name" :'num_tel'},
            {'data' : 'adresse_mail', 'title':'adresse_mail', "name" :'adresse_mail'},
            {'data' : 'motif_ko', 'title':'motif_ko', "name" :'motif_ko'},
            {'data' : 'as_j_1', 'title':'as_j_1', "name" :'as_j_1'},
            {'data' : 'statut_ticket', 'title':'statut_ticket', "name" :'statut_ticket'},
            {'data' : 'commentaire', 'title':'commentaire', "name" :'commentaire'}
            /*{
                mRender: function (data, type, row) {
                    return `<div class="d-flex justify-content-center"><div class="btn-group">
                                <button title="Modifer" class="btn btn-outline-primary serviceweb-table-edit" data-id="${row.id}"><i class="fas fa-edit"></i></button>
                                <button title="Supprimer" class="btn btn-outline-secondary serviceweb-table-delete js-swal-serviceweb-confirm" data-id="${row.id}"><i class="fas fa-trash"></i></button>
                                <button class="btn btn-outline-success serviceweb-table-upload" data-id="${row.id}"><i class="fas fa-upload"></i></button>
                                </div></div>`;
                }
            } // Actions*/

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

})(jQuery);

