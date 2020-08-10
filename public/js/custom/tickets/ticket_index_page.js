(($) => {
    $(document).on("preInit.dt", function(){
        $(".dataTables_filter input[type='search']").attr("maxlength", 190);
    });
    // Initialization
    const table = $('#tickets').DataTable( {
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
            "url": `${APP_URL}/b2bSfr/getTickets/byStatus/${document.currentScript.getAttribute('status')}`,
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
            {'data' : 'commentaire', 'title':'commentaire', "name" :'commentaire'},
            {
                data: null, title: 'Action', className: 'align-middle text-center', orderable: false, searchable: false,
                render: function (data, type, row, meta) {
                    let dropDown = `<div class="dropdown">
                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" id="dropdown-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                        </button>`;
                    dropDown += `<div class="dropdown-menu font-size-sm" aria-labelledby="dropdown-default-primary" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">`;
                    dropDown += `<a class="dropdown-item btn-edit" href="${APP_URL}/b2bSfr/tickets/edit/${data.id}"><i class="fa fa-fw fa-pencil-alt"></i> Modifier</a>`;
                    dropDown += `<a class="dropdown-item btn-view-history" href="${APP_URL}/b2bSfr/tickets/showTicketHistoryPage/${data.id}"><i class="fa fa-fw fa-history"></i> Visualiser l'Historique</a>`;
                    dropDown += `</div>`;
                    return dropDown;
                }
            }
        ],

    } );

})(jQuery);
