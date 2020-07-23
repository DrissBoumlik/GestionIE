@extends('layouts.backend')

@section('page-title')
    Dashboard
@endsection

@section('css_after')

@endsection

@section('js_after')

    <script>
        $(document).ready(function () {
            $('#statut_finale').on('change',function () {

                let statut = $(this).children("option:selected").val();
                if(statut === 'ko'){
                    $('.motif_handler').removeClass("d-none")
                }else{
                    $('.motif_handler').addClass("d-none");
                }

            });

            $('select option:first-child').attr("disabled", "true");
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
    </div>
    <div class="content content-narrow">
        <div class="container-fluid">
            <form id="" class="form" method="POST" action="{{route('b2bSfr.store')}}">
                @csrf
                <h3>Ajouter une nouvelle ticket</h3>
                <div class="row mb-2 mb-2">
                <div class="col-md-6">
                    <label for="agent_traitant">Agent traitant</label>
                    <input type="text" class="form-control" id="agent_traitant" name="agent_traitant" value="{{ auth()->user()->id }}" placeholder="agent_traitant" readonly>
                </div>
                    <div class="col-md-6">
                        <label for="region">Région</label>

                        {!! Form::select('region', ['CE'     => 'CE',
                                                    'IDF'    => 'IDF',
                                                     'SE'    => 'SE',
                                                     'SO'    => 'SE',
                                                     'CORSE' => 'CORSE'
                                                     ],
                                        $region ?? '', ["class" => "form-control", "id" => "region", "placeholder" => "choisissez une region", 'required'] ) !!}

                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4">
                        <label for="numero_intervention">Numéro d'intervention </label>
                        <input type="text" class="form-control" id="numero_intervention" name="numero_intervention" value="{{old('numero_intervention')}}" placeholder="Numéro d'intervention" required>
                    </div>
                    <div class="col-md-4">
                        <label for="cdp">CDP </label>
                        <input type="text" class="form-control" id="cdp" name="cdp" value="{{old('cdp')}}" placeholder="CDP" required>
                    </div>
                    <div class="col-md-4">
                        <label for="num_cdp">Num CDP </label>
                        <input type="text" class="form-control" id="num_cdp" name="num_cdp" value="{{old('num_cdp')}}" placeholder="Num CDP" required>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="type_intervention">Type d'intervention</label>
                        {!! Form::select('type_intervention', ['S1' => 'S1',
                                                               'S2' => 'S2',
                                                               'IMES STIT' => 'IMES STIT',
                                                               'IMES Extranet' => 'IMES Extranet'
                                                               ],
                                        $type_intervention ?? '', ["class" => "form-control", "id" => "type_intervention", "placeholder" => "choisissez une type d'intervention", 'required'] ) !!}
                    </div>
                    <div class="col-md-6">
                        <label for="Sous_type_Inter">Sous-type intervention</label>
                        <input type="text" class="form-control" id="Sous_type_Inter" name="Sous_type_Inter" value="{{old('Sous_type_Inter')}}" placeholder="Sous-type intervention" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <label for="client">Client</label>
                        <input type="text" class="form-control" id="client" name="client" value="{{old('client')}}" placeholder="Client" required>
                    </div>
                    <div class="col-md-4">
                        <label for="cp">CP</label>
                        {!! Form::select('cp', [ '01' => '01',
                                                 '03' => '03',
                                                 '15' => '15',
                                                 '18' => '18',
                                                 '19' => '19',
                                                 '21' => '21',
                                                 '25' => '25',
                                                 '36' => '36',
                                                 '39' => '39',
                                                 '43' => '43',
                                                 '58' => '58',
                                                 '70' => '70',
                                                 '71' => '71',
                                                 '73' => '73',
                                                 '74' => '74',
                                                 '75' => '75',
                                                 '89' => '89',
                                                 '91' => '91',
                                                 '92' => '92',
                                                 '93' => '93',
                                                 '94' => '94',
                                                 '95' => '95',
                                               ],
                                        $cp ?? '', ["class" => "form-control", "id" => "cp", "placeholder" => "choisissez un code postal", 'required'] ) !!}
                    </div>
                    <div class="col-md-4">
                        <label for="ville">Ville</label>
                        <input type="text" class="form-control" id="ville" name="ville" value="{{old('ville')}}" placeholder="Ville" required>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3">
                        <label for="date_reception">Date Réception Ticket</label>
                        <input type="datetime-local" class="form-control" name="date_reception" id="date_reception" value="{{'date_reception'}}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="date_planification">Date planification</label>
                        <input type="datetime-local" class="form-control" name="date_planification" id="date_planification" value="{{'date_planification'}}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="report">Report</label>
                        <input type="datetime-local" class="form-control" name="report" id="report" value="{{'report'}}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="motif_report">Motif Report</label>
                        <input type="text" class="form-control" name="motif_report" id="motif_report" value="{{old('motif_report')}}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="commentaire_report">Commentaire Report</label>
                    <textarea class="form-control" id="commentaire_report" name="commentaire_report" rows="4" placeholder="Commentaire..." required>{{ old('commentaire_report') }}</textarea>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="statut_finale">Statut Final</label>
                        {!! Form::select('statut_finale', ['ok' => 'ok',
                                                           'ko' => 'ko',
                                                           ],
                                        $statut_finale ?? '', ["class" => "form-control", "id" => "statut_finale", "placeholder" => "choissisez un statut", 'required'] ) !!}
                    </div>
                    <div class="col-md-6 motif_handler d-none">
                        <label for="motif_ko">Motif KO</label>
                        {!! Form::select('motif_ko', ['Circet' => 'Circet',
                                                      'Client' => 'Client',
                                                      'SFR'    => 'SFR',
                                                      'Opérateurs TIERS' => 'Opérateurs TIERS'

                                                           ],
                                        $motif_ko ?? '', ["class" => "form-control", "id" => "motif_ko", "placeholder" => "choissisez un motif"] ) !!}
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3">
                        <label for="nom_tech">Nom Tech</label>
                        <input type="text" class="form-control" id="nom_tech" name="nom_tech" value="{{old('nom_tech')}}" placeholder="Nom Tech" required>
                    </div>
                    <div class="col-md-3">
                        <label for="prenom_tech">Prénom Tech</label>
                        <input type="text" class="form-control" id="prenom_tech" name="prenom_tech" value="{{old('prenom_tech')}}" placeholder="Prénom Tech" required>
                    </div>
                    <div class="col-md-3">
                        <label for="num_tel">Num Tél</label>
                        <input type="tel" class="form-control" id="num_tel" name="num_tel" value="{{old('num_tel')}}"
                               placeholder="Num Tél " pattern="[0-9]{10}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="adresse_mail">Adresse Mail</label>
                        <input type="email" class="form-control" id="adresse_mail" name="adresse_mail" value="{{old('adresse_mail')}}" placeholder="Adresse Mail" required>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="as_j_1">AS J-1</label>
                        {!! Form::select('as_j_1', ['oui' => 'oui',
                                                    'non' => 'non',
                                                    ],
                                        $as_j_1 ?? '', ["class" => "form-control", "id" => "as_j_1", "placeholder" => "", 'required'] ) !!}
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
                <button class="btn btn-square btn-warning btn-wdth-rc" type="submit" name="submit-tickets">
                            Ajouter le ticket
                </button>
            </form>

        </div>
        <!-- END Stats -->
    </div>
@endsection
