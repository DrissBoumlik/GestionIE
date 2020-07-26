@extends('layouts.backend')

@section('page-title')
    list des tickets {{$status ?? ''}}
@endsection

@section('js_after')
    <!-- Page JS Code -->
    <script src="{{ asset('js/custom/tickets/ticket_index_page.js') }}"></script>
@endsection

@section('content')
    <div class="dashboard-rc">
            <div class="content">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <h3 class="flex-sm-fill h3 font-weight-bolder ">Faire une recherche</h3>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="block block-link-pop border-primary border-rc" style="margin-bottom: 0;">
                            <div class="block-content" style="padding-bottom: 2px;">
                                <form id="success-form" method="POST" action="{{ route('b2bSfr.tickets',['status' => $status]) }}">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="type_intervention">Type d'intervention</label>
                                            {!! Form::select('type_intervention', ['S1' => 'S1',
                                                                                   'S2' => 'S2',
                                                                                   'IMES STIT' => 'IMES STIT',
                                                                                   'IMES Extranet' => 'IMES Extranet'
                                                                                   ],
                                                            $type_intervention ?? '', ["class" => "form-control", "id" => "type_intervention", "placeholder" => "choisissez une type d'intervention"] ) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="statut_finale">Statut Final</label>
                                            {!! Form::select('statut_finale', ['ok' => 'ok',
                                                                               'ko' => 'ko',
                                                                               ],
                                                            $statut_finale ?? '', ["class" => "form-control", "id" => "statut_finale", "placeholder" => "choissisez un statut"] ) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="motif_ko">Motif KO</label>
                                            {!! Form::select('motif_ko', ['Circet' => 'Circet',
                                                                          'Client' => 'Client',
                                                                          'SFR'    => 'SFR',
                                                                          'Opérateurs TIERS' => 'Opérateurs TIERS'

                                                                               ],
                                                            $motif_ko ?? '', ["class" => "form-control", "id" => "motif_ko", "placeholder" => "choissisez un motif"] ) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="motif_report">Motif Report</label>
                                            {!! Form::select('motif_report', ['Demande CDP' => 'Demande CDP',
                                                                              'Demande Client' => 'Demande Client',
                                                                              'ABS Tech'    => 'ABS Tech',
                                                                              'Priorisation SAV' => 'Priorisation SAV'

                                                                               ],
                                                            $motif_report ?? '', ["class" => "form-control", "id" => "motif_report", "placeholder" => "choissisez un motif de report"] ) !!}
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="as_j_1">AS J-1</label>
                                            {!! Form::select('as_j_1', ['oui' => 'oui',
                                                                        'non' => 'non',
                                                                        ],
                                                            $as_j_1 ?? '', ["class" => "form-control", "id" => "as_j_1", "placeholder" => ""] ) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="start-date">Date début</label>
                                            <input type="date" class="form-control" id="start-date" name="start-date" value="{{ old('start-date') }}" placeholder="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="end-date">Date fin</label>
                                            <input type="date" class="form-control" id="end-date" name="end-date" value="{{ old('end-date') }}" placeholder="">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for=""></label>
                                            <button type="submit" id="filter-btn" class="btn btn-primary form-control" style="margin-top: 5px;">Rechercher</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
    </div>
    <div class="block" id="tickets_list_block" style="background-color: transparent;">
        <div class="content" id="tickets_list_wrapper">
            @include('b2bsfr.ajax.index')
        </div>
    </div>
@endsection

