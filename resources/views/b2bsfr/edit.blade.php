@extends('layouts.backend')

@section('page-title')
    Modifier le ticket
@endsection

@section('css_after')

@endsection

@section('js_after')

    <script>
        $(document).ready(function () {
            selectChange('#statut_finale');
            $('#statut_finale').on('change.select2',function () {
                selectChange(this);
            });
            $('select option:first-child').attr("disabled", "true");
            function selectChange(identifier) {
                let statut = $(identifier).children("option:selected").val();
                if(statut === 'ko'){
                    $('.motif_handler').removeClass("d-none")
                }else{
                    $('.motif_handler').addClass("d-none");
                }
            }
        })
    </script>

    <script>
        $(function () {
            @if($errors->any())
            swal(
                'Error!',
                '{{ $errors->first() }}',
                'error'
            );
            @endif
            @if(session()->has('message'))
            swal(
                'Success!',
                '{{ session()->get('message') }}',
                'success'
            );
            @endif
        })
    </script>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="content status" style="padding-top: 0;padding-bottom: 0;">
        @if($errors->any())
            <div class="alert alert-danger alert-dismissable" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <ul style="margin-bottom: 0;">
                    @foreach ($errors->all() as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                {{ session()->get('message') }}
            </div>
        @endif
    </div>
    <div class="content content-narrow">
        <div class="container-fluid">
            <h3>Modifier le ticket</h3>
            <form id="tickets-edit-form" action="{{route('b2bSfr.tickets.update',['id' => $ticket->id])}}" method="POST">
                @csrf
                <div class="block-content font-size-sm">
                    <div class="row mb-2 mb-2">
                        <div class="col-md-12">
                            <input name="_method" type="hidden" value="PUT">
                            <label for="agent_traitant">Agent traitant</label>
                            <input type="text" class="form-control" id="agent_traitant" name="agent_traitant" value="{{$ticket->agent_traitant}}" readonly>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="statut_finale">Statut Final</label>
                            {!! Form::select('statut_finale', ['ok' => 'ok',
                                                               'ko' => 'ko',
                                                               ],
                                            $ticket->statut_finale ?? '', ["class" => "form-control", "id" => "statut_finale", "placeholder" => "choissisez un statut", 'required'] ) !!}
                        </div>
                        <div class="col-md-4 motif_handler d-none">
                            <label for="motif_ko">Motif KO</label>
                            {!! Form::select('motif_ko', ['Circet' => 'Circet',
                                                          'Client' => 'Client',
                                                          'SFR'    => 'SFR',
                                                          'Opérateurs TIERS' => 'Opérateurs TIERS'

                                                               ],
                                            $ticket->motif_ko ?? '', ["class" => "form-control", "id" => "motif_ko", "placeholder" => "choissisez un motif"] ) !!}
                        </div>
                        <div class="col-md-4 motif_handler d-none">
                            <label for="motif_report">Motif Report</label>
                            {!! Form::select('motif_report', ['Demande CDP' => 'Demande CDP',
                                                              'Demande Client' => 'Demande Client',
                                                              'ABS Tech'    => 'ABS Tech',
                                                              'Priorisation SAV' => 'Priorisation SAV'

                                                               ],
                                            $ticket->motif_report ?? '', ["class" => "form-control", "id" => "motif_report", "placeholder" => "choissisez un motif de report"] ) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="commentaire_report">Commentaire Report</label>
                        <textarea class="form-control" id="commentaire_report" name="commentaire_report" rows="4" placeholder="Commentaire..." required>{{ $ticket->commentaire_report }}</textarea>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label for="as_j_1">AS J-1</label>
                            {!! Form::select('as_j_1', ['oui' => 'oui',
                                                        'non' => 'non',
                                                        ],
                                            $ticket->as_j_1 ?? '', ["class" => "form-control", "id" => "as_j_1", "placeholder" => "", 'required'] ) !!}
                        </div>
                        <div class="col-md-6">
                            <label for="statut_ticket">Statut Ticket</label>
                            {!! Form::select('statut_ticket', ['En cours' => 'En cours',
                                                        'Validé' => 'Validé',
                                                        'Clôturé' => 'Clôturé'
                                                        ],
                                            $ticket->statut_ticket ?? '', ["class" => "form-control", "id" => "statut_ticket", "placeholder" => "choissisez un statut", 'required'] ) !!}

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="commentaire">Commentaire</label>
                        <textarea class="form-control" id="commentaire" name="commentaire" rows="4" placeholder="Commentaire..." required>{{ $ticket->commentaire }}</textarea>
                    </div>
                    <button class="btn btn-square btn-warning btn-wdth-rc" type="submit" name="submit-tickets" id="submit-ticket-form">
                        Modifier le ticket
                    </button>
                </div>
            </form>

        </div>
        <!-- END Stats -->
    </div>
@endsection
