@include('reporting.layouts.global_date_filter')
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title d-inline-block">Les instances</h3>
                            <hr>
                            <div class="refresh-form row">
                                <div id="tree-view-01" class="tree-view d-inline-flex btn-flex-star col-md-2"></div>
                                <div id="instance-zone-filter-01" class="tree-zone-view d-inline-flex col-md-2"></div>
                                <div id="instance-vile-filter-01" class="tree-vile-view d-inline-flex col-md-2"></div>
                                <div id="instance-cdp-filter-01" class="tree-cdp-view d-inline-flex col-md-2"></div>
                                <div id="instance-type-filter-01" class="tree-type-view d-inline-flex col-md-2"></div>
                                <button type="button" id="refreshInstance"
                                        class="btn btn-primary float-right btn-flex-star d-none col-md-2">
                                    <span class="btn-field font-weight-normal position-relative">Rafraîchir</span>
                                </button>
                            </div>
                        </div>
                            <div class="card-body table-responsive">
                                <div class="row justify-content-center">
                                    <div class="col-6 text-center">
                                        <a href="{{route('exportData',['entity' =>'instance'])}}" style="color: #ffffff"
                                           class="btn btn-primary mb-3 capitalize-first-letter bg-orange w-100">
                                            exporter les données au format Excel
                                        </a>
                                    </div>
                                </div>
                                <table id="instance"
                                       class="table table-bordered table-striped table-valign-middle capitalize">
                                    <tr>
                                        <th>RESSOURCE</th>
                                        <th>FTTH</th>
                                        <th>FTTB</th>
                                        <th>Total</th>
                                    </tr>
                                </table>
                            </div>

                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title d-inline-block">Les en cours</h3>
                            <hr>
                            <div class="refresh-form row">
                                <div id="tree-view-02" class="tree-view d-inline-flex col-md-2"></div>
                                <div id="enCours-zone-filter-02" class="tree-zone-view d-inline-flex col-md-2"></div>
                                <div id="enCours-vile-filter-02" class="tree-vile-view d-inline-flex col-md-2"></div>
                                <div id="enCours-cdp-filter-02" class="tree-cdp-view d-inline-flex col-md-2"></div>
                                <div id="enCours-type-filter-02" class="tree-type-view d-inline-flex col-md-2"></div>
                                <button type="button" id="refreshEnCours"
                                        class="btn btn-primary float-right btn-flex-star d-none col-md-2">
                                    <span class="btn-field font-weight-normal position-relative">Rafraîchir</span>
                                </button>
                            </div>
                        </div>
                            <div class="card-body table-responsive">
                                <div class="row justify-content-center">
                                    <div class="col-6 text-center">
                                        <a href="{{route('exportData',['entity' =>'en_cours'])}}" style="color: #ffffff"
                                           class="btn btn-primary mb-3 capitalize-first-letter bg-orange w-100">
                                            exporter les données au format Excel
                                        </a>
                                    </div>
                                </div>
                                <table id="enCours"
                                       class="table table-bordered table-striped table-valign-middle capitalize">
                                    <tr>
                                        <th>RESSOURCE</th>
                                        <th>FTTH</th>
                                        <th>FTTB</th>
                                        <th>Total</th>
                                    </tr>
                                </table>
                            </div>

                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title d-inline-block">Liste globale</h3>
                            <hr>
                            <div class="refresh-form row">
                                <div id="tree-view-03" class="tree-view d-inline-flex col-md-2"></div>
                                <div id="global-zone-filter-03" class="tree-zone-view d-inline-flex col-md-2"></div>
                                <div id="global-vile-filter-03" class="tree-vile-view d-inline-flex col-md-2"></div>
                                <div id="global-cdp-filter-03" class="tree-cdp-view d-inline-flex col-md-2"></div>
                                <div id="global-type-filter-03" class="tree-type-view d-inline-flex col-md-2"></div>
                                <button type="button" id="refreshGlobal"
                                        class="btn btn-primary float-right btn-flex-star d-none col-md-2">
                                    <span class="btn-field font-weight-normal position-relative">Rafraîchir</span>
                                </button>
                            </div>
                        </div>
                            <div class="card-body table-responsive">
                                <div class="row justify-content-center">
                                    <div class="col-6 text-center">
                                        <a href="{{route('exportData',['entity' =>'all'])}}" style="color: #ffffff"
                                           class="btn btn-primary mb-3 capitalize-first-letter bg-orange w-100">
                                            exporter les données au format Excel
                                        </a>
                                    </div>
                                </div>
                                <table id="global"
                                       class="table table-bordered table-striped table-valign-middle capitalize">
                                    <tr>
                                        <th>RESSOURCE</th>
                                        <th>FTTH</th>
                                        <th>FTTB</th>
                                        <th>Total</th>
                                    </tr>
                                </table>
                            </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>


