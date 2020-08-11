(($) => {

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
                $('.treejs-node .treejs-nodes .treejs-switcher').click();
                $('.refresh-form button').removeClass('d-none');
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    };

    let userObject = {
        filterTree: {dates: [], zoneRows: [],cdpRows:[], datesTreeObject: undefined},
        filterElement: {dates: '#tree-view-00', zoneRows: '',cdpRows:''},
    };

    window.userFilter = function (userObject, isPost = false) {
        let _data = (userObject.filterTree) ? {filter: userObject.filterTree.dates} : '';
        $.ajax({
            url: APP_URL + '/user/filter',
            method: isPost ? 'POST' : 'GET',
            data: _data,
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

    userFilter(userObject);

    let instance = {
        element_dt: undefined,
        element: 'instance',
        refreshBtn :'#refreshInstance',
        columns: [
            {data: 'agent_traitant',title: 'RESSOURCE', name: 'agent_traitant'},
            {data: 'FTTH',title: 'FTTH', name: 'FTTH'},
            {data: 'FTTB', title: 'FTTB', name: 'FTTB'},
            {data: 'total',title: 'total', name: 'total'},
        ],
        data: undefined,
        filterTree: {dates: [], zoneRows: [],cdpRows:[], datesTreeObject: undefined},
        filterElement: {dates: '#tree-view-01', zoneRows: '#instance-zone-filter-01',cdpRows: '#instance-cdp-filter-01',cityRows: '#instance-vile-filter-01',typeRows: '#instance-type-filter-01'},
        route: '/reporting/getInstance',
    };
    if (elementExists(instance)) {
        getData(instance,  {
            refreshMode: false,
        });
        $(instance.refreshBtn).on('click', function () {
            toggleLoader($(instance.refreshBtn).parents('.col-12'));
            getData(instance, {
                refreshMode: true,
            });
        });
    }

    let enCours = {
        element_dt: undefined,
        element: 'enCours',
        refreshBtn :'#refreshEnCours',
        columns: [
            {data: 'agent_traitant',title: 'RESSOURCE', name: 'agent_traitant'},
            {data: 'FTTH',title: 'FTTH', name: 'FTTH'},
            {data: 'FTTB', title: 'FTTB', name: 'FTTB'},
            {data: 'total',title: 'total', name: 'total'},
        ],
        data: undefined,
        filterTree: {dates: [], zoneRows: [],cdpRows:[], datesTreeObject: undefined},
        filterElement: {dates: '#tree-view-02', zoneRows: '#enCours-zone-filter-02', cdpRows: '#enCours-cdp-filter-02',cityRows: '#enCours-vile-filter-02',typeRows: '#enCours-type-filter-02'},
        route: '/reporting/getEnCours',
    };
    if (elementExists(enCours)) {
        getData(enCours,  {
            refreshMode: false,
        });
        $(enCours.refreshBtn).on('click', function () {
            toggleLoader($(enCours.refreshBtn).parents('.col-12'));
            getData(enCours, {
                refreshMode: true,
            });
        });
    }

    let globalData = {
        element_dt: undefined,
        element: 'global',
        refreshBtn :'#refreshGlobal',
        columns: [
            {data: 'agent_traitant',title: 'RESSOURCE', name: 'agent_traitant'},
            {data: 'FTTH',title: 'FTTH', name: 'FTTH'},
            {data: 'FTTB', title: 'FTTB', name: 'FTTB'},
            {data: 'total',title: 'total', name: 'total'},
        ],
        data: undefined,
        filterTree: {dates: [], zoneRows: [],cdpRows:[], datesTreeObject: undefined},
        filterElement: {dates: '#tree-view-03', zoneRows: '#global-zone-filter-03', cdpRows: '#global-cdp-filter-03',cityRows: '#global-vile-filter-03',typeRows: '#global-type-filter-03'},
        route: '/reporting/getGlobalData',
    };
    if (elementExists(globalData)) {
        getData(globalData,  {
            refreshMode: false,
        });
        $(globalData.refreshBtn).on('click', function () {
            toggleLoader($(globalData.refreshBtn).parents('.col-12'));
            getData(globalData, {
                refreshMode: true,
            });
        });
    }

    let globalElements = [userObject,instance,enCours,globalData];

    getDatesFilter(globalElements);

    $("#refreshAll").on('click',function () {
        globalElements.map(function (element) {
            try {
                if ($(element.filterElement.dates).length) {
                    element.filterTree.dates = userObject.filterTree.dates;
                    element.filterTree.datesTreeObject.values = userObject.filterTree.dates;
                }
            } catch (e) {

            }
        });
        userFilter(userObject, true);
        getData(instance, {
            refreshMode: true,
        });
        getData(enCours, {
            refreshMode: true,
        });
        getData(globalData, {
            refreshMode: true,
        });
    });

     function getData(object,data = null, params ={
         refreshMode: false,
     }){
         ajaxRequests++;
         if (params.refreshMode) {
             data = {...data, refreshMode: true};
         }
         if (object.filterTree && object.filterTree.zoneRows) {
             console.log(object.filterTree.zoneRows);
             data = {...data, 'rowzone': object.filterTree.zoneRows};
         }
         if (object.filterTree && object.filterTree.cdpRows) {
             data = {...data, 'rowcdp': object.filterTree.cdpRows};
         }
         if (object.filterTree && object.filterTree.cityRows) {
             data = {...data, 'rowcity': object.filterTree.cityRows};
         }
         if (object.filterTree && object.filterTree.typeRows) {
             data = {...data, 'rowtype': object.filterTree.typeRows};
         }
         if (object.filterTree) {
             data = {...data, 'dates': object.filterTree.dates};
         }
         toggleLoader($('#' + object.element).parents('.col-12'));

         if (data !== null && data !== undefined) {
                 object.element_dt = InitDataTable(object, data,);
         }

    }

    function InitDataTable(object, data) {
        if ($.fn.DataTable.isDataTable(object.elementDT)) {
            object.elementDT.destroy();
        }

        toggleLoader($(object.refreshBtn).parents('.col-12'));
        let table = $('#' + object.element);
        object.elementDT = table.DataTable({
            destroy: false,
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
                if(response.dateFilter){
                    object.filterTree.dates = response.dateFilter;
                }
                if(response.zoneFilter){
                    let rowsFilterData = response.zoneFilter.map(function (d, index) {
                        return {
                            id: d,
                            text: d
                        };
                    });
                    new Tree(object.filterElement.zoneRows, {
                        data: [{id: '-1', text: 'Region', children: rowsFilterData}],
                        closeDepth: 1,
                        loaded: function () {
                            if (response.zoneFilter) {
                                this.values = object.filterTree.zoneRows = (response.checkedZoneFilter) ? response.checkedZoneFilter : response.zoneFilter;
                            }
                        },
                        onChange: function () {
                            object.filterTree.zoneRows = this.values;
                        }
                    });
                }
                if(response.cdpFilter){
                    let rowsFilterData = response.cdpFilter.map(function (d, index) {
                        return {
                            id: d,
                            text: d
                        };
                    });
                    new Tree(object.filterElement.cdpRows, {
                        data: [{id: '-1', text: 'Code Postal', children: rowsFilterData}],
                        closeDepth: 1,
                        loaded: function () {
                            if (response.cdpFilter) {
                                this.values = object.filterTree.cdpRows = (response.checkedCdpFilter) ? response.checkedCdpFilter : response.cdpFilter;
                            }
                        },
                        onChange: function () {
                            object.filterTree.cdpRows = this.values;
                        }
                    });
                }
                if(response.cityFilter){
                    let rowsFilterData = response.cityFilter.map(function (d, index) {
                        return {
                            id: d,
                            text: d
                        };
                    });
                    new Tree(object.filterElement.cityRows, {
                        data: [{id: '-1', text: 'ville', children: rowsFilterData}],
                        closeDepth: 1,
                        loaded: function () {
                            if (response.cityFilter) {
                                this.values = object.filterTree.cityRows = (response.checkedcityFilter) ? response.checkedcityFilter : response.cityFilter;
                            }
                        },
                        onChange: function () {
                            object.filterTree.cityRows = this.values;
                        }
                    });
                }
                if(response.typeFilter){
                    let rowsFilterData = response.typeFilter.map(function (d, index) {
                        return {
                            id: d,
                            text: d
                        };
                    });
                    new Tree(object.filterElement.typeRows, {
                        data: [{id: '-1', text: 'type', children: rowsFilterData}],
                        closeDepth: 1,
                        loaded: function () {
                            if (response.cityFilter) {
                                this.values = object.filterTree.typeRows = (response.checkedtypeFilter) ? response.checkedtypeFilter : response.typeFilter;
                            }
                        },
                        onChange: function () {
                            object.filterTree.typeRows = this.values;
                        }
                    });
                }
                toggleLoader($(object.refreshBtn).parents('.col-12'), true);
            }
        });
    }

})(jQuery);

