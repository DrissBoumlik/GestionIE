(($) => {
    $(document).on("preInit.dt", function(){
        $(".dataTables_filter input[type='search']").attr("maxlength", 190);
    });
    // Initialization
    const table = $('#ticketsHistory').DataTable( {
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
            "url": `${APP_URL}/b2bSfr/tickets/getTicketHistory/${document.currentScript.getAttribute('ticketId')}`,
            "dataSrc": "data"
        },
        columns: [
            {"data": "lastname", "title": "agent traitant", "name" :"lastname"},
            {'data' : 'statut_finale', 'title':'statut_finale' , "name" :'statut_finale'},
            {'data' : 'motif_report', 'title':'motif_report' , "name" :'motif_report'},
            {'data' : 'motif_ko', 'title':'motif_ko', "name" :'motif_ko'},
            {'data' : 'commentaire_report', 'title':'commentaire_report' , "name" :'commentaire_report'},
            {'data' : 'as_j_1', 'title':'as_j_1', "name" :'as_j_1'},
            {'data' : 'statut_ticket', 'title':'statut_ticket', "name" :'statut_ticket'},
            {'data' : 'commentaire', 'title':'commentaire', "name" :'commentaire'},
            {'data' : 'created_at', 'title':'quand', "name" :'created_at'},
        ],
    } );

})(jQuery);

