let data = $('#data-request').data('request');
$('#agents').DataTable({
    language: frLang,
    pageLength: 10,
    processing: true,
    serverSide: true,
    order: [],
    ajax: {
        type: 'GET',
        url: APP_URL + `/agents/get-data`,
        // data: data
    },
    columns: [
        {data: 'pseudo', name: 'pseudo', title: 'Pseudo'},
        {data: 'fullName', name: 'fullName', title: 'Nom Complet'},
        {data: 'hours', name: 'hours', title: 'Heures'},
        // {data: 'imported_at', name: 'imported_at', title: 'Date'},
        {data: 'imported_at_annee', name: 'imported_at_annee', title: 'Année'},
        {data: 'imported_at_mois', name: 'imported_at_mois', title: 'Mois'},
        {data: 'imported_at_semaine', name: 'imported_at_semaine', title: 'Semaine'},
    ]
});
