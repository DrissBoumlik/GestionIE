@extends('layouts.backend')

@section('page-title')
    Reporting
@endsection
@section('css_after')
    <!-- DataTables -->
    <link rel="stylesheet" href={{ asset("/plugins/datatables/css/dataTables.bootstrap4.css") }}>
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('/plugins/sweetalert2/sweetalert2.min.css') }}">

@endsection

@section('js_after')
    <!-- DataTables -->
    <script src={{ asset("/plugins/datatables/js/jquery.dataTables.js") }}></script>
    <script src={{ asset("/plugins/datatables/js/dataTables.bootstrap4.js") }}></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script src="{{ asset("/plugins/sweetalert2/sweetalert2.all.min.js") }}"></script>

    <script src="{{ asset("/plugins/tree-view/tree.js") }}"></script>

    <script src="{{ asset('/js/custom/reporting/all-data.js') }}"></script>


@endsection

@section('content')
    <div class="block-content font-size-sm">
        <div class="container-fluid">
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
                                <button type="button" id="refreshInstance"
                                        class="btn btn-primary float-right btn-flex-star d-none">
                                    <span class="btn-field font-weight-normal position-relative">Rafraîchir</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body table-responsive">
                                <table id="instance"
                                       class="table table-striped table-bordered p-5">
                                    <tr>
                                        <th>RESSOURCE</th>
                                        <th>Numero de l'appel / Référence SFR</th>
                                        <th>date de rendez vous</th>
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
                                <div id="instance-zone-filter-02" class="tree-zone-view d-inline-flex"></div>
                                <button type="button" id="refreshEnCours"
                                        class="btn btn-primary float-right btn-flex-star d-none">
                                    <span class="btn-field font-weight-normal position-relative">Rafraîchir</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body table-responsive">
                                <table id="enCours"
                                       class="table table-striped table-bordered p-5">
                                    <tr>
                                        <th>RESSOURCE</th>
                                        <th>AS</th>
                                        <th>date</th>
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
                                <div id="instance-zone-filter-03" class="tree-zone-view d-inline-flex"></div>
                                <button type="button" id="refreshGlobal"
                                        class="btn btn-primary float-right btn-flex-star d-none">
                                    <span class="btn-field font-weight-normal position-relative">Rafraîchir</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-body table-responsive">
                                <table id="global"
                                       class="table table-striped table-bordered p-5">
                                    <tr>
                                        <th>RESSOURCE</th>
                                        <th>Numero de l'appel / Référence SFR //AS</th>
                                        <th>date</th>
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
        </div>
    </div>
@endsection
