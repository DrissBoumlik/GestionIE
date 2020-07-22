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

            })
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
                        <select class="form-control" id="region" name="region" required>
                            <option selected="true" disabled="disabled">choisissez une region</option>
                            <option value="CE">CE</option>
                            <option value="IDF">IDF</option>
                            <option value="SE">SE</option>
                            <option value="SO">SO</option>
                            <option value="CORSE">CORSE</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-4">
                        <label for="numero_intervention">Numéro d'intervention </label>
                        <input type="text" class="form-control" id="numero_intervention" name="numero_intervention" value="{{old('numero_intervention')}}" placeholder="Numéro d'intervention">
                    </div>
                    <div class="col-md-4">
                        <label for="cdp">CDP </label>
                        <input type="text" class="form-control" id="cdp" name="cdp" value="{{old('cdp')}}" placeholder="CDP">
                    </div>
                    <div class="col-md-4">
                        <label for="num_cdp">Num CDP </label>
                        <input type="text" class="form-control" id="num_cdp" name="num_cdp" value="{{old('num_cdp')}}" placeholder="Num CDP">
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="type_intervention">Type d'intervention</label>
                        <select class="form-control" name="type_intervention" id="type_intervention">
                            <option selected disabled>choisissez une type d'intervention</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="IMES STIT">IMES STIT</option>
                            <option value="IMES Extranet">IMES Extranet</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="Sous_type_Inter">Sous-type intervention</label>
                        <input type="text" class="form-control" id="Sous_type_Inter" name="Sous_type_Inter" value="{{old('Sous_type_Inter')}}" placeholder="Sous-type intervention">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <label for="client">Client</label>
                        <input type="text" class="form-control" id="client" name="client" value="{{old('client')}}" placeholder="Client">
                    </div>
                    <div class="col-md-4">
                        <label for="cp">CP</label>
                        <select class="form-control" name="cp" id="cp">
                            <option selected disabled>choisissez un code postal</option>
                            <option value="01">01</option>
                            <option value="03">03</option>
                            <option value="15">15</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="21">21</option>
                            <option value="25">25</option>
                            <option value="36">36</option>
                            <option value="39">39</option>
                            <option value="43">43</option>
                            <option value="58">58</option>
                            <option value="70">70</option>
                            <option value="71">71</option>
                            <option value="73">73</option>
                            <option value="74">74</option>
                            <option value="75">75</option>
                            <option value="89">89</option>
                            <option value="91">91</option>
                            <option value="92">92</option>
                            <option value="93">93</option>
                            <option value="94">94</option>
                            <option value="95">95</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="ville">Ville</label>
                        <input type="text" class="form-control" id="ville" name="ville" value="{{old('ville')}}" placeholder="Ville">
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3">
                        <label for="date_reception">Date Réception Ticket</label>
                        <input type="date" class="form-control" name="date_reception" id="date_reception">
                    </div>
                    <div class="col-md-3">
                        <label for="date_planification">Date planification</label>
                        <input type="date" class="form-control" name="date_planification" id="date_planification">
                    </div>
                    <div class="col-md-3">
                        <label for="report">Report</label>
                        <input type="date" class="form-control" name="report" id="report">
                    </div>
                    <div class="col-md-3">
                        <label for="motif_report">Motif Report</label>
                        <input type="text" class="form-control" name="motif_report" id="motif_report" value="{{old('motif_report')}}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="commentaire_report">Commentaire Report</label>
                    <textarea class="form-control" id="commentaire_report" name="commentaire_report" rows="4" placeholder="Commentaire...">{{ old('commentaire_report') }}</textarea>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="statut_finale">Statut Final</label>
                        <select class="form-control" name="statut_finale" id="statut_finale">
                            <option selected disabled>choissisez un statut</option>
                            <option value="ok">ok</option>
                            <option value="ko">ko</option>
                        </select>
                    </div>
                    <div class="col-md-6 motif_handler d-none">
                        <label for="motif_ko">Motif KO</label>
                        <select class="form-control" name="motif_ko" id="motif_ko">
                            <option selected disabled>choissisez un motif</option>
                            <option value="Circet">Circet</option>
                            <option value="Client">Client</option>
                            <option value="SFR">SFR</option>
                            <option value="Opérateurs TIERS">Opérateurs TIERS</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-3">
                        <label for="nom_tech">Nom Tech</label>
                        <input type="text" class="form-control" id="nom_tech" name="nom_tech" value="{{old('nom_tech')}}" placeholder="Nom Tech">
                    </div>
                    <div class="col-md-3">
                        <label for="prenom_tech">Prénom Tech</label>
                        <input type="text" class="form-control" id="prenom_tech" name="prenom_tech" value="{{old('prenom_tech')}}" placeholder="Prénom Tech">
                    </div>
                    <div class="col-md-3">
                        <label for="num_tel">Num Tél</label>
                        <input type="tel" class="form-control" id="num_tel" name="num_tel" value="{{old('num_tel')}}" placeholder="Num Tél">
                    </div>
                    <div class="col-md-3">
                        <label for="adresse_mail">Adresse Mail</label>
                        <input type="tel" class="form-control" id="adresse_mail" name="adresse_mail" value="{{old('adresse_mail')}}" placeholder="Adresse Mail">
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6">
                        <label for="as_j_1">AS J-1</label>
                        <select name="as_j_1" id="as_j_1" class="form-control">
                            <option disabled selected></option>
                            <option value="oui">oui</option>
                            <option value="non">non</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="statut_ticket">Statut Ticket</label>
                        <select name="statut_ticket" id="statut_ticket" class="form-control">
                            <option disabled selected>choissisez un statut</option>
                            <option value="En cours">En cours</option>
                            <option value="Validé">Validé</option>
                            <option value="Clôturé">Clôturé</option>
                        </select>

                    </div>
                </div>

                <div class="form-group">
                    <label for="commentaire">Commentaire</label>
                    <textarea class="form-control" id="commentaire" name="commentaire" rows="4" placeholder="Commentaire...">{{ old('commentaire') }}</textarea>
                </div>
                <button class="btn btn-square btn-warning btn-wdth-rc" type="submit" name="submit-tickets">
                            Ajouter le ticket
                </button>
            </form>

        </div>
        <!-- END Stats -->
    </div>
@endsection
