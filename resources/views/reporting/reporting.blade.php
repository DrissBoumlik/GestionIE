@include('reporting.layouts.global_date_filter')
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title d-inline-block">Les instances</h3>
                            <hr>
                            <div class="refresh-form">
                                <div id="tree-view-01" class="tree-view d-inline-flex btn-flex-star"></div>
                                <div id="instance-zone-filter-01" class="tree-zone-view d-inline-flex"></div>
                                <div id="instance-vile-filter-01" class="tree-vile-view d-inline-flex"></div>
                                <div id="instance-cdp-filter-01" class="tree-cdp-view d-inline-flex"></div>
                                <button type="button" id="refreshInstance"
                                        class="btn btn-primary float-right btn-flex-star d-none">
                                    <span class="btn-field font-weight-normal position-relative">Rafraîchir</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body table-responsive">
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
                            <div class="refresh-form">
                                <div id="tree-view-02" class="tree-view d-inline-flex"></div>
                                <div id="enCours-zone-filter-02" class="tree-zone-view d-inline-flex"></div>
                                <div id="enCours-vile-filter-02" class="tree-vile-view d-inline-flex"></div>
                                <div id="enCours-cdp-filter-02" class="tree-cdp-view d-inline-flex"></div>
                                <button type="button" id="refreshEnCours"
                                        class="btn btn-primary float-right btn-flex-star d-none">
                                    <span class="btn-field font-weight-normal position-relative">Rafraîchir</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body table-responsive">
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
                            <div class="refresh-form">
                                <div id="tree-view-03" class="tree-view d-inline-flex"></div>
                                <div id="global-zone-filter-03" class="tree-zone-view d-inline-flex"></div>
                                <div id="global-vile-filter-03" class="tree-vile-view d-inline-flex"></div>
                                <div id="global-cdp-filter-03" class="tree-cdp-view d-inline-flex"></div>
                                <button type="button" id="refreshGlobal"
                                        class="btn btn-primary float-right btn-flex-star d-none">
                                    <span class="btn-field font-weight-normal position-relative">Rafraîchir</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body table-responsive">
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

                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>


