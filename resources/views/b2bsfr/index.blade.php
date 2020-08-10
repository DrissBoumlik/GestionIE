@extends('layouts.backend')

@section('page-title')
    list des tickets {{$status ?? ''}}
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

    <script src="{{ asset('js/custom/tickets/ticket_index_page.js') }}" status= '{{$status ?? ''}}'></script>
@endsection

@section('content-header')
    <div class="bg-image overflow-hidden"
         style="background-image: url('{{ asset('/media/backgrounds/photo3@2x.jpg') }}');">
        <div class="bg-primary-dark-op">
            <div class="content content-narrow content-full">
                <div
                    class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center mt-5 mb-2 text-center text-sm-left">
                    <div class="flex-sm-fill">
                        <h2 class="h4 font-w400 text-white-75 mb-0 invisible" data-toggle="appear" data-timeout="250">
                            Bonjour {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Hero -->
@endsection

@section('content')

    <div class="content content-narrow">

        <!-- Stats -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title d-inline-block">les tickets {{$status ?? ''}}</h3>
                            <hr>
                            <div class="refresh-form">
                                <div id="tree-view-tickets-encours" class="tree-view d-inline-flex"></div>
                                <button type="button" id="refreshticketsEnCours"
                                        class="btn btn-primary">
                                    <span class="btn-field font-weight-normal position-relative">Rafraîchir</span>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="tickets"
                                   class="not-stats-table table table-bordered table-striped table-valign-middle capitalize">
                                <tr>
                                    <th>id</th>
                                    <th>agent_traitant</th>
                                    <th>region</th>
                                    <th>numero_intervention</th>
                                    <th>cdp</th>
                                    <th>num_cdp</th>
                                    <th>type_intervention</th>
                                    <th>client</th>
                                    <th>cp</th>
                                    <th>Ville</th>
                                    <th>Sous_type_Inter</th>
                                    <th>date_reception</th>
                                    <th>date_planification</th>
                                    <th>report</th>
                                    <th>motif_report</th>
                                    <th>statut_finale</th>
                                    <th>nom_tech</th>
                                    <th>prenom_tech</th>
                                    <th>num_tel</th>
                                    <th>adresse_mail</th>
                                    <th>motif_ko</th>
                                    <th>as_j_1</th>
                                    <th>statut_ticket</th>
                                    <th>commentaire</th>
                                </tr>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- END Stats -->
    </div>
@endsection
