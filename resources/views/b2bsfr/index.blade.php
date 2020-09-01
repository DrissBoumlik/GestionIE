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
            <div class="modal fade" id="modal-edit-ticket" tabindex="-1" role="dialog"
                 aria-labelledby="modal-edit-ticket" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-dialog-ticket modal-xl" role="document">
                    <div class="modal-content">
                        <div class="block block-themed block-transparent mb-1">
                            <div class="block-header bg-primary-dark">
                                <h3 class="block-title">Modifier le ticket</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <form id="tickets-edit-form">
                                @csrf
                                <div class="block-content font-size-sm">
                                    <div class="row mb-2 mb-2">
                                        <div class="col-md-12">
                                            <input type="hidden" name="id" id="id" >
                                            <label for="agent_traitant">Agent traitant</label>
                                            <input type="text" class="form-control" id="agent_traitant" name="agent_traitant" placeholder="agent_traitant" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4">
                                            <label for="statut_finale">Statut Final</label>
                                            {!! Form::select('statut_finale', ['ok' => 'ok',
                                                                               'ko' => 'ko',
                                                                               ],
                                                            $statut_finale ?? '', ["class" => "form-control", "id" => "statut_finale", "placeholder" => "choissisez un statut"] ) !!}
                                        </div>
                                        <div class="col-md-4 motif_handler d-none">
                                            <label for="motif_ko">Motif KO</label>
                                            {!! Form::select('motif_ko', ['Circet' => 'Circet',
                                                                          'Client' => 'Client',
                                                                          'SFR'    => 'SFR',
                                                                          'Opérateurs TIERS' => 'Opérateurs TIERS'

                                                                               ],
                                                            $motif_ko ?? '', ["class" => "form-control", "id" => "motif_ko", "placeholder" => "choissisez un motif"] ) !!}
                                        </div>
                                        <div class="col-md-4 motif_handler d-none">
                                            <label for="motif_report">Motif Report</label>
                                            {!! Form::select('motif_report', ['Demande CDP' => 'Demande CDP',
                                                                              'Demande Client' => 'Demande Client',
                                                                              'ABS Tech'    => 'ABS Tech',
                                                                              'Priorisation SAV' => 'Priorisation SAV'

                                                                               ],
                                                            $motif_report ?? '', ["class" => "form-control", "id" => "motif_report", "placeholder" => "choissisez un motif de report"] ) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="commentaire_report">Commentaire Report</label>
                                        <textarea class="form-control" id="commentaire_report" name="commentaire_report" rows="4" placeholder="Commentaire...">{{ old('commentaire_report') }}</textarea>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label for="as_j_1">AS J-1</label>
                                            {!! Form::select('as_j_1', ['oui' => 'oui',
                                                                        'non' => 'non',
                                                                        ],
                                                            $as_j_1 ?? '', ["class" => "form-control", "id" => "as_j_1", "placeholder" => ""] ) !!}
                                        </div>
                                        <div class="col-md-6">
                                            <label for="statut_ticket">Statut Ticket</label>
                                            {!! Form::select('statut_ticket', ['En cours' => 'En cours',
                                                                        'Validé' => 'Validé',
                                                                        'Clôturé' => 'Clôturé'
                                                                        ],
                                                            $statut_ticket ?? '', ["class" => "form-control", "id" => "statut_ticket", "placeholder" => "choissisez un statut", 'required'] ) !!}

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="commentaire">Commentaire</label>
                                        <textarea class="form-control" id="commentaire" name="commentaire" rows="4" placeholder="Commentaire..." required>{{ old('commentaire') }}</textarea>
                                    </div>
                                    <button class="btn btn-square btn-warning btn-wdth-rc" type="submit" name="submit-tickets" id="submit-ticket-form">
                                        Modifier le ticket
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-ticket-history" tabindex="-1" role="dialog"
                 aria-labelledby="modal-ticket-history" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-dialog-ticket modal-xl" role="document">
                    <div class="modal-content">
                        <div class="block block-themed block-transparent mb-1">
                            <div class="block-header bg-primary-dark">
                                <h3 class="block-title">Visualiser l'historique</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                        <i class="fa fa-fw fa-times"></i>
                                    </button>
                                </div>
                            </div>
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
                                                                <th>motif_report</th>
                                                                <th>statut_finale</th>
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
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.row -->
        </div>
        <!-- END Stats -->
    </div>
@endsection
