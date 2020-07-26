@extends('layouts.backend')

@section('page-title')
    l'historique de ticket
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

    <script src="{{ asset('js/custom/tickets/ticket_history_page.js') }}"  ticketId="{{$id}}"></script>
@endsection

@section('content')
<div class="block-content font-size-sm">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title d-inline-block">l'historique de ticket</h3>
                        <hr>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="ticketsHistory"
                                   class="not-stats-table table table-bordered table-striped table-valign-middle capitalize">
                                <tr>
                                    <th>agent_traitant</th>
                                    <th>statut_finale</th>
                                    <th>motif_report</th>
                                    <th>motif_ko</th>
                                    <th>commentaire report</th>
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
        </div>
    </div>
</div>
@endsection
