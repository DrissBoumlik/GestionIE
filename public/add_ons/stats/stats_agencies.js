$(function () {
    let dates = undefined;
    let resultatAppel = undefined;
    let gpmtAppelPre = undefined;
    let codeTypeIntervention = undefined;
    let codeIntervention = undefined;
    let agence_code = '';
    const paramFiltreList = [
        {
            url: 'Resultat_Appel', id: '#stats-regions-filter',
            text: 'Resultat Appel', values: (v) => resultatAppel = v, class: '.tree-region-view'
        },
        {
            url: 'Gpmt_Appel_Pre', id: '#stats-call-regions-filter', class: '.tree-call-region-view',
            text: 'Résultats Appels Préalables par agence', values: (v) => gpmtAppelPre = v
        },
        {
            url: 'Gpmt_Appel_Pre', id: '#stats-weeks-regions-filter', class: '.tree-weeks-region-view',
            text: 'Résultats Appels Préalables par semaine', values: (v) => gpmtAppelPre = v
        },
        {
            url: 'Code_Type_Intervention', id: '#code-type-intervention-filter', class: '.tree-code-type-intervention-view',
            text: 'Type Intervention', values: (v) => codeTypeIntervention = v
        },
        {
            url: 'Code_Intervention', id: '#code-intervention-filter', class: '.tree-code-intervention-view',
            text: 'Intervention', values: (v) => codeIntervention = v
        },
    ];
    const params = window.location.href.split('?')[1];
    const paramsList = params.split('&');
    for (let param of paramsList) {
        const p = param.split('=');
        if (p[0] === 'agence_code') {
            agence_code = p[1];
        }
    }


    $.ajax({
        url: 'agences/dates',
        data: {
            agence_code: agence_code
        },
        method: 'GET',
        success: function (response) {
            let data = response.dates;
            $('.tree-view').each(function (index, item) {
                new Tree('#' + $(this).attr('id'), {
                    data: [{id: '-1', text: 'Dates', children: data}],
                    closeDepth: 2,
                    loaded: function () {
                    },
                    onChange: function () {
                        dates = this.values;
                    }
                });
                // $(this).find('.treejs-switcher').first().parent().first().addClass('treejs-node__close')
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {

        }
    });

    for (let p of paramFiltreList) {
        $.ajax({
            url: `agences/filter/${p.url}`,
            data: {
                agence_code: agence_code
            },
            method: 'GET',
            success: function (response) {
                const data = response.data.map(function (d) {
                    return {
                        id: d,
                        text: d
                    };
                });
                $(p.class).each(function (index, item) {
                    new Tree(p.id, {
                        data: [{id: '-1', text: p.text, children: data}],
                        closeDepth: 1,
                        loaded: function () {
                        },
                        onChange: function () {
                            p.values(this.values);
                        }
                    });
                    // $(this).find('.treejs-switcher').first().parent().first().addClass('treejs-node__close')
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    }
    /// ====================== REGIONS ==========================
    const filterData = () => {
        return {
            dates,
            resultatAppel,
            gpmtAppelPre,
            codeTypeIntervention,
            codeIntervention,
            agence_code
        };
    };
    let statsRegions = {element_dt: undefined, element: $('#statsRegions'), columns: undefined, routeCol: 'agences/regions/columns/Resultat_Appel', routeData: 'agences/regions/Resultat_Appel'};
    let statsRegionsChart = {element_chart: undefined, element_id: 'statsRegionsChart', data: undefined};
    getColumns(statsRegions, statsRegionsChart);
    $('#refreshRegions').on('click', function () {
        statsRegions.element_dt = InitDataTable(statsRegions, filterData());
    });

    /// ====================== CALLS STATS AGENCIES / WEEKS ==========================

    let callsStatesAgencies = {element_dt: undefined, element: $('#callsStatesAgencies'), columns: undefined, routeCol: 'agences/regionsCallState/columns/Nom_Region', routeData: 'agences/regionsCallState/Nom_Region'};
    let callsStatesAgenciesChart = {element_chart: undefined, element_id: 'callsStatesAgenciesChart', data: undefined};
    getColumns(callsStatesAgencies, callsStatesAgenciesChart);
    $('#refreshCallStatesAgencies').on('click', function () {
        callsStatesAgencies.element_dt = InitDataTable(callsStatesAgencies, filterData());
    });


    let callsStatesWeeks = {element_dt: undefined, element: $('#callsStatesWeeks'), columns: undefined, routeCol: 'agences/regionsCallState/columns/Date_Heure_Note_Semaine', routeData: 'agences/regionsCallState/Date_Heure_Note_Semaine'};
    let callsStatesWeeksChart = {element_chart: undefined, element_id: 'callsStatesWeeksChart', data: undefined};
    getColumns(callsStatesWeeks, callsStatesWeeksChart);
    $('#refreshCallStatesWeeks').on('click', function () {
        callsStatesWeeks.element_dt = InitDataTable(callsStatesWeeks, filterData());
    });


    /// ====================== CALL STATS Joignables / Injoignable ==========================

    let statscallsPos = {element_dt: undefined, element: $('#statsCallsPos'), columns: undefined, routeCol: 'agences/clientsByCallState/columns/Joignable', routeData: 'agences/clientsByCallState/Joignable'};
    let statsCallsPosChart = {element_chart: undefined, element_id: 'statsCallsPosChart', data: undefined};
    getColumns(statscallsPos, statsCallsPosChart);
    $('#refreshCallResultPos').on('click', function () {
        statscallsPos.element_dt = InitDataTable(statscallsPos, filterData());
    });

    let statscallsNeg = {element_dt: undefined, element: $('#statsCallsNeg'), columns: undefined, routeCol: 'agences/clientsByCallState/columns/Injoignable', routeData: 'agences/clientsByCallState/Injoignable'};
    let statscallsNegChart = {element_chart: undefined, element_id: 'statscallsNegChart', data: undefined};
    getColumns(statscallsNeg, statscallsNegChart);
    $('#refreshCallResultNeg').on('click', function () {
        statscallsNeg.element_dt = InitDataTable(statscallsNeg, filterData());
    });

    /// ====================== FOLDERS CODE / TYPE ==========================

    let statsFoldersByType = {element_dt: undefined, element: $('#statsTypes'), columns: undefined, routeCol: 'agences/nonValidatedFolders/columns/Code_Type_Intervention', routeData: 'agences/nonValidatedFolders/Code_Type_Intervention'};
    getColumns(statsFoldersByType);
    $('#refreshFoldersByType').on('click', function () {
        statsFoldersByType.element_dt = InitDataTable(statsFoldersByType, filterData());
    });

    let statsFoldersByCode = {element_dt: undefined, element: $('#statsCodes'), columns: undefined, routeCol: 'agences/nonValidatedFolders/columns/Code_Intervention', routeData: 'agences/nonValidatedFolders/Code_Intervention'};
    getColumns(statsFoldersByCode);
    $('#refreshFoldersByCode').on('click', function () {
        statsFoldersByCode.element_dt = InitDataTable(statsFoldersByCode, filterData());
    });

    // getColumns('nonValidatedFoldersColumn', 'nonValidatedFolders', stats, stats_dt);


    /// ====================== FUNCTIONS ==========================
    function dynamicColors() {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        return "rgb(" + r + "," + g + "," + b + ")";
    };

    function getColumns(object, objectChart = null) {
        $.ajax({
            url: object.routeCol,
            data: {
                agence_code: agence_code
            },
            method: 'GET',
            success: function (response) {
                object.columns = response.columns;
                object.element_dt = InitDataTable(object, { agence_code: agence_code});
                if (objectChart !== null && objectChart !== undefined) {
                    let labels = response.columns.map((column) => {
                        return column.name;
                    });
                    let column = labels[0];
                    labels.pop();
                    labels.shift();
                    let datasets = response.data.map((item) => {
                        let regions = Object.values(item.values).map((value) => {
                            return parseFloat(isNaN(value) ? value.replace('%', '') : value);
                        });
                        return {label: item[column], backgroundColor: dynamicColors(), data: regions};
                    });

                    var ctx = document.getElementById(objectChart.element_id).getContext('2d');
                    let barChartData = {labels, datasets};
                    let chart = new Chart(ctx, {
                        type: 'bar',
                        data: barChartData,
                        options: {
                            title: {
                                display: true,
                                text: 'Résultats Appels'
                            },
                            tooltips: {
                                mode: 'index',
                                intersect: true
                            },
                            responsive: true,
                            scales: {
                                xAxes: [{
                                    stacked: false,
                                }],
                                yAxes: [{
                                    stacked: false
                                }]
                            }
                        }
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('error');
            }
        });
    }

    function InitDataTable(object, data = null) {

        if ($.fn.DataTable.isDataTable(object.element_dt)) {
            object.element_dt.destroy();
        }
        return object.element.DataTable({
            responsive: true,
            info: false,
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: object.routeData,
                data: data,
            },
            columns: object.columns
        });
    }

    function feedBack(message, status) {
        swal(
            status.replace(/^\w/, c => c.toUpperCase()) + '!',
            message,
            status
        )
    }
});
