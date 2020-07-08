require('./bootstrap');

let agence_code = '';
let agent_name = '';
let parentAttributName = '';
let parentAttributValue = '';
const params = window.location.href.split('?')[1];

if (params) {
    const paramsList = params.split('&');
    for (let param of paramsList) {
        const p = param.split('=');
        if (p[0] === 'agence_code') {
            agence_code = p[1];
        }
        if (p[0] === 'agent_name') {
            agent_name = p[1];
        }
    }
}

frLang = {
    sEmptyTable: "Aucune donnée disponible dans le tableau",
    sInfo: "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
    sInfoEmpty: "Affichage de l'élément 0 à 0 sur 0 élément",
    sInfoFiltered: "(filtré à partir de _MAX_ éléments au total)",
    sInfoPostFix: "",
    sInfoThousands: ",",
    sLengthMenu: "Afficher _MENU_ éléments",
    sLoadingRecords: "Chargement...",
    sProcessing: "Traitement...",
    sSearch: "Rechercher :",
    sZeroRecords: "Aucun élément correspondant trouvé",
    oPaginate: {
        sFirst: "Premier",
        sLast: "Dernier",
        sNext: "Suivant",
        sPrevious: "Précédent"
    },
    oAria: {
        sSortAscending: ": activer pour trier la colonne par ordre croissant",
        sSortDescending: ": activer pour trier la colonne par ordre décroissant"
    },
    select: {
        rows: {
            0: "Aucune ligne sélectionnée",
            1: "1 ligne sélectionnée",
            _: "%d lignes sélectionnées"
        }
    }
};

(($) => {
    // Default Ajax Configuration
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let willReload = false;
    $(document).ajaxError(function (event, jqXHR, settings, thrownError) {
        try {
            if (jqXHR.status === 401) {
                if (!willReload) {
                    willReload = true;
                    Swal.fire({
                        // position: 'top-end',
                        type: 'error',
                        title: 'Votre session a expirée<br/>Vous devez se reconnecter',
                        showConfirmButton: true,
                        customClass: {
                            confirmButton: 'btn btn-success m-1',
                        },
                        confirmButtonText: 'Ok',
                    });
                    setTimeout(function () {
                        window.location.reload();
                    }, 3000);
                }
            }
        } catch {
        }

    });

    const select = $(document).find('#agent-code');

    select.select2({
        placeholder: 'Selectione un Agent',
        ajax: {
            url: APP_URL + `/agents/list`,
            dataType: 'json',
            data: function (params) {
                // Query parameters will be ?search=[term]&type=public
                return {
                    name: params.term,
                };
            },
            processResults: function (data) {
                // Transforms the top-level key of the response object from 'items' to 'results'
                data = data.map(d => {
                    return {
                        text: d.name.toUpperCase(),
                        id: d.code
                    };
                });
                return {
                    results: data
                };
            }
        }
    });
    const newOption = new Option(agent_name.toUpperCase(), agent_name, true, true);
    select.append(newOption).trigger('change');
    //Events
    $(document).on('change', '#agent-code', (e) => {
        agence_code = $(e.currentTarget).val();
        window.location.href = APP_URL + `/agents?agent_name=${agence_code}`;
    });

    // Handling sidebar events with logo app
    $('#page-header button[data-action=sidebar_toggle]').on('click', function () {
        $('.sidebar-mini .logo').addClass('visible');
    });

    //<editor-fold desc="FUNCTIONS">
    window.getColumns = function (object, data = null, params = {
        removeTotal: true,
        refreshMode: false,
        details: false,
        removeLink: false,
        linkOrder: 0,
        removeTotalColumn: false,
        pagination: false,
        searching: false
    }) {
        ajaxRequests++;
        if (params.refreshMode) {
            data = {...data, refreshMode: true};
        }
        if (object.filterTree && object.filterTree.rows) {
            data = {...data, 'rowFilter': object.filterTree.rows};
        }
        if (object.filterTree) {
            data = {...data, 'dates': object.filterTree.dates};
        }

        toggleLoader($('#' + object.element).parents('.col-12'));

        $.ajax({
            url: APP_URL + '/' + object.routeCol,
            method: 'GET',
            data: data,
            success: function (response) {
                if (object.filterElement) {
                    object.filterTree.dates = response.filter ? response.filter.date_filter : [];
                    if (object.filterTree.datesTreeObject && object.filterTree.dates) {
                        object.filterTree.datesTreeObject.values = object.filterTree.dates;
                        if (object.objDetail) {
                            object.objDetail.filterTree.dates = object.filterTree.dates;
                        }
                    }
                    if (response.rows && response.rows.length) {
                        let rowsFilterData = response.rows.map(function (d, index) {
                            return {
                                id: d,
                                text: d
                            };
                        });
                        new Tree(object.filterElement.rows, {
                            data: [{id: '-1', text: response.rowsFilterHeader, children: rowsFilterData}],
                            closeDepth: 1,
                            loaded: function () {
                                if (response.filter && response.filter.rows_filter) {
                                    this.values = object.filterTree.rows = response.filter.rows_filter;
                                    // console.log(this.values);
                                }
                            },
                            onChange: function () {
                                object.filterTree.rows = this.values;
                                // console.log(this.values);
                            }
                        });
                    }

                    let filters = response.filter;
                    if (filters !== null && filters !== undefined) {
                        object.filterTree.dates = filters.date_filter;
                    }
                }

                if (response.columns.length) {
                    let reformattedColumns = [...response.columns].map(function (column) {

                        return {
                            ...column,
                            render: function (data, type, full, meta) {
                                let newData = data;
                                if (newData !== null && newData !== undefined) {
                                    newData = newData.toString();
                                    if (newData.indexOf('|') !== -1) {
                                        newData = newData.split('|').join('<br/>');
                                        // newData = newData[0] + '<br/>' + newData[1];
                                    }
                                } else {
                                    newData = '';
                                }
                                // let classHasTotalCol = params.removeTotalColumn ? 'hasTotal' : '';
                                // let removeLinkCol = params.removeLink ? 'removeLink' : '';
                                // let rowClass = full.isTotal ? '' : 'pointer detail-data';

                                // let notLink = '';
                                // if (params.linkOrder) {
                                //     if(meta.col >= response.columns.length - params.linkOrder)
                                //         notLink = 'not-link';
                                // }
                                // return '<span class="' + rowClass + ' ' + classHasTotalCol + ' ' + removeLinkCol + ' ' + notLink + '">' + newData + '<\span>';
                                let cellClass = 'clickable d-block';
                                if (column.isLink === false || full.isTotal) {
                                    cellClass = 'd-block';
                                }
                                return '<span class="' + cellClass + '">' + newData + '<\span>';
                            }
                        };
                    });

                    // object.columns = [...response.columns];
                    object.columns = [...reformattedColumns];
                } else {
                    object.columns = [{title: 'Résultats'}];
                }

                if (data !== null && data !== undefined) {
                    try {
                        object.element_dt = InitDataTable(object, data, {
                            removeTotal: params.removeTotal,
                            removeTotalColumn: params.removeTotalColumn,
                            removeLink: params.removeLink,
                            linkOrder: params.linkOrder,
                            details: params.details,
                            pagination: params.pagination,
                            searching: params.searching
                        });
                        if (params.details) {
                            $('#' + object.element).on('click', 'td.details-control', function () {
                                if (object.element === 'globalViewTable') {
                                    let row = object.element_dt.cell(this).index().row + 1;
                                    let _values = $(tableId + " > tbody > tr:nth-child(" + row + ") td:" + (params.details ? "nth-child(2)" : "first-child")).text().split(' / ');
                                    let _cols = object.rowName.split(' / ');
                                    object.objDetail.rowName = ' ' + _cols[0] + ' like "%' + _values[0] + '%" AND ' + _cols[1] + ' like "' + _values[1] + '" AND ' + object.objDetail.rowName;
                                }

                                const tr = $(this).closest('tr');
                                const row = object.element_dt.row(tr);
                                if (row.child.isShown()) {
                                    // This row is already open - close it
                                    destroyChild(row);
                                    tr.removeClass('shown');
                                    object.highlightedRow.splice(object.highlightedRow.indexOf($('#' + object.element + '> tbody > tr').index(tr)));
                                } else {
                                    // Open this row
                                    if (object.highlightedRow && object.rowIndex) {
                                        object.rowIndex.push($('tr').index(tr));
                                        object.highlightedRow.push($('#' + object.element + '> tbody > tr').index(tr));
                                    }
                                    if (object.childneedParentValue && object.childneedParentValue === true) {
                                        let row = object.element_dt.cell(this).index().row + 1;
                                        parentAttributName = object.rowName;
                                        parentAttributValue = $('#' + object.element + " > tbody > tr:nth-child(" + row + ") td:" + (params.details ? "nth-child(2)" : "first-child")).text();
                                    }
                                    data = {...data, key_groupement: tr.find('td:nth-child(2)').text()};
                                    object.objDetail.element = 'details-' + $('tr').index(tr);
                                    createChild(row, object, data); // class is for background colour
                                    tr.addClass('shown');
                                }
                            });
                        }
                        // CELL CLICK
                        let tableId = '#' + object.element;
                        $(tableId + ' tbody').on('click', 'td', function (event) {
                            if (!$(this).hasClass('details-control') && $(this).children('.clickable').length) {
                                event.stopPropagation();
                                let agent_name = $('#agent_name').val();
                                let agence_name = $('#agence_name').val();
                                let col = object.element_dt.cell(this).index().column + 1;
                                let row = object.element_dt.cell(this).index().row + 1;
                                let colText = $(tableId + " > thead > tr > th:nth-child(" + col + ")").text();
                                if (object.element === 'statsValTypeIntervention') {
                                    switch (colText) {
                                        case 'Validé Conforme':
                                            colText = 'Appels clôture - Validé conforme';
                                            break;
                                        case 'Validé Non Conforme' :
                                            colText = 'Appels clôture - CRI non conforme';
                                            break;
                                    }

                                }
                                let rowText = $(tableId + " > tbody > tr:nth-child(" + row + ") td:" + (params.details ? "nth-child(2)" : "first-child")).text();
                                if (object.element === 'statsColturetech') {
                                    switch (rowText) {
                                        case 'superieur un jour':
                                            rowText = ' and TIMESTAMPDIFF(MINUTE,EXPORT_ALL_Date_SOLDE,EXPORT_ALL_Date_VALIDATION) > 1440 ';
                                            break;
                                        case 'Entre 1H et 6h' :
                                            rowText = ' and TIMESTAMPDIFF(MINUTE,EXPORT_ALL_Date_SOLDE,EXPORT_ALL_Date_VALIDATION) between 60 and 360 ';
                                            break;
                                        case 'Entre 30min et 1H':
                                            rowText = ' and TIMESTAMPDIFF(MINUTE,EXPORT_ALL_Date_SOLDE,EXPORT_ALL_Date_VALIDATION) BETWEEN 30 and 60 ';
                                            break;
                                        default:
                                            rowText = ' and TIMESTAMPDIFF(MINUTE,EXPORT_ALL_Date_SOLDE,EXPORT_ALL_Date_VALIDATION) < 30';
                                    }
                                }
                                if (object.element === 'statsGlobalDelay') {
                                    switch (rowText) {
                                        case 'Superieur 15 Jours':
                                            rowText = ' and TIMESTAMPDIFF(DAY,Date_Creation,EXPORT_ALL_Date_VALIDATION) > 15 ';
                                            break;
                                        case 'Entre une semaine et 15 jours' :
                                            rowText = ' and TIMESTAMPDIFF(DAY,Date_Creation,EXPORT_ALL_Date_VALIDATION) between 7 and 15 ';
                                            break;
                                        default:
                                            rowText = ' and TIMESTAMPDIFF(DAY,Date_Creation,EXPORT_ALL_Date_VALIDATION) < 7 ';
                                    }
                                }
                                if (object.element === 'statesRepJoiDepartement' && colText !== '') {
                                    object.filterQuery.queryJoin += 'and nom_agence not REGEXP "^.*[0-9]{2} .[0-9]{2}"';
                                }
                                if (object.columnName === 'Date_Heure_Note_Semaine') {
                                    colText = colText.split('_')[0];
                                }
                                let rowName = object.rowName;
                                if (object.element === 'globalViewTable') {
                                    let _cols = object.rowName.split(' / ');
                                    let _values = rowText.split(' / ');
                                    rowName = _cols[1];
                                    rowText = ' ' + _values[1] + '" AND ' + _cols[0] + ' LIKE "%' + _values[0] + '%';
                                }
                                if (object.parentElement === 'globalViewTable') {
                                    rowText = '%(' + rowText + ')%';
                                }
                                let lastRowIndex = object.element_dt.rows().count();
                                let lastColumnIndex = object.element_dt.columns().count();
                                // if (((params.details && col > 2) || (!params.details && col > 1))
                                //     && ((params.removeTotal && row < lastRowIndex) || (!params.removeTotal && row <= lastRowIndex))
                                //     && ((params.removeTotalColumn && col < lastColumnIndex) || (!params.removeTotalColumn && col <= lastColumnIndex))
                                //     && ((!params.removeLink && col > 1) || (params.removeLink && col < (lastColumnIndex + 1 - params.linkOrder))))
                                if ($(this).find('.clickable').length) {
                                    let dates = object.filterTree.dates;
                                    window.open(APP_URL + '/all-stats?' +
                                        'row=' + (rowName === undefined || rowName === null ? '' : rowName) +
                                        '&rowValue=' + rowText +
                                        '&col=' + (object.columnName === undefined || object.columnName === null ? '' : object.columnName) +
                                        '&colValue=' + colText +
                                        '&agent=' + (agent_name === undefined || agent_name === null ? '' : agent_name) +
                                        '&agence=' + (agence_name === undefined || agence_name === null ? '' : agence_name) +
                                        '&dates=' + (dates === undefined || dates === null ? '' : dates) +
                                        '&queryJoin=' + (object.filterQuery.queryJoin === undefined || object.filterQuery.queryJoin === null ? '' : object.filterQuery.queryJoin) +
                                        '&subGroupBy=' + (object.filterQuery.subGroupBy === undefined || object.filterQuery.subGroupBy === null ? '' : object.filterQuery.subGroupBy) +
                                        '&queryGroupBy=' + (object.filterQuery.queryGroupBy === undefined || object.filterQuery.queryGroupBy === null ? '' : object.filterQuery.queryGroupBy) +
                                        '&appCltquery=' + (object.filterQuery.appCltquery === undefined || object.filterQuery.appCltquery === null ? '' : object.filterQuery.appCltquery) +
                                        '&parentValue= ' + (object.needParentValue === undefined || object.needParentValue === null ? '' : ' and ' + parentAttributName + ' like "%' + parentAttributValue + '%"') +
                                        (object.routeData.includes('nonValidatedFolders') ? '&Resultat_Appel=Appels clôture - CRI non conforme' : ''));
                                }
                            }
                        });
                    } catch (error) {
                        console.log(error);
                        Swal.fire({
                            // position: 'top-end',
                            type: 'error',
                            title: "Vous devez actualiser la page",
                            showConfirmButton: true,
                            customClass: {
                                confirmButton: 'btn btn-success m-1',
                            },
                            confirmButtonText: 'Ok',
                        });
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    };

    window.InitDataTable = function (object, data = null, params = {
        removeTotal: true,
        removeTotalColumn: false,
        details: false,
        pagination: false,
        searching: false,
        linkOrder: 0
    }) {
        let table = $('#' + object.element);
        if ($.fn.DataTable.isDataTable(table)) {
            table.off('click', 'td.details-control');
            table.DataTable().destroy();
            let tableID = object.element;
            let tableParent = table.parents('.card-body');
            table.remove();
            $('#' + tableID + '_wrapper').remove();
            let newTable = object.columns.reduce(function (accumulator, current) {
                return accumulator + '<th>' + current.title + '</th>';
            }, params.details ? '<th></th>' : '');

            newTable = '<table id="' + tableID + '" class="table table-bordered table-striped table-valign-middle capitalize">' +
                '<thead>' + newTable + '</thead><tbody></tbody></table>';
            tableParent.append(newTable);
            table = $('#' + object.element);
        }

        if (params.details) {
            object.objDetail.columns = [...object.columns];
            object.objDetail.columns = object.objDetail.columns.map(function (item, index) {
                if (index === 0) {
                    return {...item, data: 'Resultat_Appel', name: 'Resultat_Appel', title: 'Resultat Appel'};
                }
                return {...item, title: item.name};
            });

            object.columns.unshift({
                className: 'details-control',
                orderable: false,
                data: null,
                defaultContent: '',
                width: '10%'
            });
        }
        let _table_dt = table.DataTable({
            destroy: true,
            language: frLang,
            responsive: true,
            info: false,
            processing: true,
            serverSide: true,
            searching: params.searching,
            // ordering: false,
            bPaginate: params.pagination,
            ajax: {
                url: APP_URL + '/' + object.routeData,
                data: data,
            },
            columns: object.columns,
            initComplete: function (settings, response) {
                ajaxRequests--;
                if (ajaxRequests === 0) {
                    toggleLoader($('#refreshAll').parents('.col-12'), true);
                }
                // if (object.objChart !== null && object.objChart !== undefined) {
                //     try {
                //         InitChart(object.objChart, object.columns, response.data, {
                //             removeTotal: params.removeTotal,
                //             removeTotalColumn: params.removeTotalColumn,
                //             details: params.details,
                //             linkOrder: params.linkOrder
                //         });
                //         let parent = $('#' + object.element).parents('.col-12');
                //         toggleLoader(parent, true);
                //     } catch (error) {
                //         console.log(error);
                //     }
                // }
            }
        });
        // Add loader UI when datatble page links clicked
        $('#' + object.element + '_wrapper').on('click', '.page-link', function () {
            let parent = $('#' + object.element).parents('.col-12');
            toggleLoader(parent);
        });
        _table_dt.on('xhr', function () {
            let response = _table_dt.ajax.json();
            object.data = [...response.data];
            if (object.objChart !== null && object.objChart !== undefined) {
                try {
                    InitChart(object.objChart, object.columns, object.data, {
                        removeTotal: params.removeTotal,
                        removeTotalColumn: params.removeTotalColumn,
                        details: params.details,
                        linkOrder: params.linkOrder
                    });
                    let parent = $('#' + object.element).parents('.col-12');
                    toggleLoader(parent, true);
                } catch (error) {
                    console.log(error);
                }
            }
        });
        return _table_dt;
    };

    window.InitChart = function (objectChart, columns, data, params = {
        removeTotal: true,
        removeTotalColumn: false,
        details: false,
        linkOrder: 0
    }) {
        let labels = [...columns];
        labels = labels.map((column) => {
            return column.data;
        });
        if (params.details) {
            labels.shift();
        }
        let column = labels.shift();

        labels = columns.reduce(function (filteredColumns, column) {
            if (column.isLink === undefined) {
                filteredColumns.push(column.data);
            }
            return filteredColumns;
        }, []);

        // if (params.removeTotalColumn) {
        //     labels.pop();
        // }
        // if(objectChart.element_id === 'statsAgentProdChart'){
        //     labels.shift();
        //     labels = labels.filter(function (label, index) {
        //         return index <= labels.length - params.linkOrder;
        //     });
        // }
        let datasets = [...data];
        if (params.removeTotal) {
            datasets.pop();
        }
        let uniqueColors = [];
        datasets = datasets.map((item) => {
            let regions = item.values.map((value) => {
                return parseFloat(isNaN(value) ? value.replace('%', '') : value);
            });
            let _dataItem = {label: item[column], backgroundColor: dynamicColors(uniqueColors), data: regions};
            // let _dataItem = {label: item[column], backgroundColor: dynamicColors(uniqueColors), data: regions, fill: false, borderColor: dynamicColors(uniqueColors)};
            return _dataItem;
        });

        let chartID = objectChart.element_id;
        let chart = $('#' + chartID);

        if (!detailClick) {
            let chartParent = chart.parents('.col-12');
            chartParent.children('.chartjs-size-monitor').remove();
            chart.remove();
            let newChart = '<canvas id="' + chartID + '">';
            chartParent.append(newChart);
        } else {
            detailClick = false;
        }

        var ctx = document.getElementById(objectChart.element_id).getContext('2d');
        let ChartData = {labels, datasets};
        // if (objectChart.element_chart !== null && objectChart.element_chart !== undefined) {
        //     objectChart.element_chart.destroy();
        // }
        objectChart.element_chart = new Chart(ctx, {
            type: 'bar',
            data: ChartData,
            options: {
                title: {
                    display: true,
                    text: objectChart.chartTitle
                },
                tooltips: {
                    mode: 'index',
                    intersect: true
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        stacked: false,
                    }],
                    yAxes: [{
                        stacked: false
                    }]
                },
                plugins: {
                    // Change options for ALL labels of THIS CHART
                    datalabels: {
                        anchor: 'end',
                        align: 'end',
                        font: {
                            weight: 'bold',
                            // size: 14
                        },
                        rotation: -45,
                        display: function (context) {
                            // if(context.dataset.data.length > 10) {
                            //     return false;
                            // }
                            return context.dataset.data[context.dataIndex] !== 0;
                        }
                    }
                }
            }
        });
    };

    window.getDatesFilter = function (globalElements) {
        $.ajax({
            url: APP_URL + '/dates',
            method: 'GET',
            success: function (response) {
                let treeData = response.dates;

                $('.tree-view').each(function (index, item) {
                    let treeId = '#' + $(this).attr('id');
                    let object = globalElements.filter(function (element) {
                        return element.filterElement.dates === treeId;
                    });
                    new Tree(treeId, {
                        data: [{id: '-1', text: 'Dates', children: treeData}],
                        closeDepth: 1,
                        loaded: function () {
                            // this.values = ['2019-12-02', '2019-12-03'];
                            // console.log(this.selectedNodes);
                            // console.log(this.values);
                            // this.disables = ['0-0-0', '0-0-1', '0-0-2']

                            if (object.length) {
                                object = object[0];
                                object.filterTree.datesTreeObject = this;
                                if (object.filterTree.dates) {
                                    object.filterTree.datesTreeObject.values = object.filterTree.dates;
                                }
                            }
                        },
                        onChange: function () {
                            // dates = this.values;
                            if (object.filterTree) {
                                object.filterTree.dates = this.values;
                            }
                        }
                    });
                });
                // if (datesFilterListExist && datesFilterValuesExist) {
                //     assignFilter(datesFilterList, datesFilterValues);
                // }
                $('.treejs-node .treejs-nodes .treejs-switcher').click();
                $('.refresh-form button').removeClass('d-none');
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    };

    window.userFilter = function (userObject, isPost = false) {
        $.ajax({
            url: APP_URL + '/user/filter',
            method: isPost ? 'POST' : 'GET',
            data: {filter: userObject.filterTree.dates},
            success: function (response) {
                if (response.userFilter) {
                    userObject.filterTree.dates = response.userFilter.date_filter;
                    if (userObject.filterTree.datesTreeObject && userObject.filterTree.dates) {
                        userObject.filterTree.datesTreeObject.values = userObject.filterTree.dates;
                        if (userObject.objDetail) {
                            userObject.objDetail.filterTree.dates = userObject.filterTree.dates;
                        }
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    };

    window.filterSelectOnChange = function (caller, agence_code, agent_name) {
        let agenceParam = agence_code ? 'agence_code=' + agence_code : '';
        let agentParam = agent_name ? 'agent_name=' + agent_name : '';
        let params = agenceParam || agentParam ? ('?' + agenceParam + '&' + agentParam) : '';
        let url = APP_URL + '/' + $(caller).val() + params;
        if ($('#filterDashboard').prop('selectedIndex') && url !== window.location.href) {
            window.location = url;
        }
    };

    window.checkDataCount = function (ImportingReady = true) {
        $('.import_status-wrapper').removeClass('d-none');
        let sendRequestCountData = Boolean(JSON.parse(window.localStorage.getItem('sendRequestCountData')));
        if (sendRequestCountData) {
            let importedDataElement = $('.imported-data');
            let totalImportedData = window.localStorage.getItem('totalImportedData');
            if (importedDataElement.length && ImportingReady) {
                importedDataElement.text(totalImportedData + ' lignes inserées');
            }
            let request_resolved = Boolean(JSON.parse(window.localStorage.getItem('request_resolved')));
            $.ajax({
                method: 'get',
                url: APP_URL + '/import/data/count',
                dateType: 'json',
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.flags) {
                        totalImportedData = data.flags.imported_data;
                        isImporting = data.flags.is_importing;

                        window.localStorage.setItem('totalImportedData', totalImportedData);
                        if (importedDataElement.length) {
                            importedDataElement.text(totalImportedData + ' lignes inserées');
                        }
                        if (request_resolved || isImporting == 2) {
                            window.localStorage.removeItem('sendRequestCountData');
                            // window.localStorage.removeItem('totalImportedData');
                            window.localStorage.removeItem('request_resolved');
                            $('.import_status-wrapper').addClass('d-none');
                            Swal.fire({
                                // position: 'top-end',
                                type: 'success',
                                title: 'Total inserés : ' + totalImportedData + ' enregistrements',
                                showConfirmButton: true,
                                customClass: {
                                    confirmButton: 'btn btn-success m-1',
                                },
                                confirmButtonText: 'Ok',
                            });
                            $('.modal').modal('hide');
                        } else {

                            setTimeout(function () {
                                checkDataCount();
                            }, 4000);
                        }
                    } else {
                        if (importedDataElement.length) {
                            importedDataElement.html('Veuiller patientez, <span style="color:red">Ne rafraîchissez pas la page</span>');
                        }
                        setTimeout(function () {
                            checkDataCount(false);
                        }, 4000);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if (request_resolved || isImporting == 2) {
                        window.localStorage.removeItem('sendRequestCountData');
                        window.localStorage.removeItem('totalImportedData');
                        window.localStorage.removeItem('request_resolved');
                        $('.import_status-wrapper').addClass('d-none');
                        // Swal.fire({
                        //     // position: 'top-end',
                        //     type: 'error',
                        //     title: 'Une erreur est survenue',
                        //     showConfirmButton: true,
                        //     customClass: {
                        //         confirmButton: 'btn btn-success m-1',
                        //     },
                        //     confirmButtonText: 'Ok',
                        // });
                        $('.modal').modal('hide');
                    } else {
                        setTimeout(function () {
                            checkDataCount();
                        }, 4000);
                    }
                }
            });
        }
    };

    //</editor-fold>

    //<editor-fold desc="FUNCTIONS TOOLS">

    window.createChild = function (row, object, data = null) {
        detailClick = true;
        // This is the table we'll convert into a DataTable
        let objectChild = object.objDetail;
        var tableDom = '<table id="' + objectChild.element + '" class="table-details table table-bordered table-valign-middle capitalize"/>';
        var canvasDom = '<div class="col-12"><canvas id="' + objectChild.element + '-Chart"/></div>';
        objectChild.objChart.element_id = objectChild.element + '-Chart';

        let objectChildItem = {...objectChild};
        object.children.push(objectChildItem);

        let createdChild = tableDom;
        // Display it the child row
        row.child($(tableDom)).show();
        let table = $('#' + objectChildItem.element);
        table.after(canvasDom);
        // row.child(objectChild.element).show();
        data = {...data, 'route': object.routeData};
        getColumns(objectChildItem, data, {
            removeTotal: false,
            removeTotalColumn: false,
            removeLink: false,
            linkOrder: 0,
            details: false,
            refreshMode: false,
            pagination: false,
            searching: false
        });
        // InitDataTable(objectChild, data, {removeTotal: false, removeTotalColumn: false, details: false});
    };

    window.destroyChild = function (row) {
        var table = $("table", row.child());
        table.detach();
        table.DataTable().destroy();

        // And then hide the row
        row.child.hide();
    };

    window.toggleLoader = function (parent, remove = false) {
        if (remove) {
            parent.find('.loader_wrapper').remove();
            parent.find('.loader_container').remove();
        } else {
            parent.append('<div class="loader_wrapper"><div class="loader"></div></div>');
            parent.append('<div class="loader_container"></div>');
        }
    };

    window.elementExists = function (object) {
        if (object !== null && object !== undefined) {
            let element = object instanceof jQuery ? object : $('#' + object.element);
            if (element !== null && element !== undefined) {
                return element.length;
            }
            return false;
        }
        return false;
    };

    window.dynamicColors = function (uniqueColors) {
        let color = {
            r: Math.floor(Math.random() * 255),
            g: Math.floor(Math.random() * 255),
            b: Math.floor(Math.random() * 255)
        };
        let exists = false;
        do {
            exists = uniqueColors.some(function (uniqueColor) {
                return uniqueColor.r === color.r &&
                    uniqueColor.g === color.g &&
                    uniqueColor.b === color.b;
            });
        } while (exists);
        uniqueColors.push(color);
        return "rgb(" + color.r + "," + color.g + "," + color.b + ")";
    };

    window.feedBack = function (message, status) {
        swal(
            status.replace(/^\w/, c => c.toUpperCase()) + '!',
            message,
            status
        )
    };
    //</editor-fold>

    let sendRequestCountData = Boolean(JSON.parse(window.localStorage.getItem('sendRequestCountData')));
    if (sendRequestCountData) {
        $('.import_status-wrapper').removeClass('d-none');
        checkDataCount();
    } else {
        $('.import_status-wrapper').addClass('d-none');
    }
})(jQuery);
