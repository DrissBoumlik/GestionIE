@extends('layouts.backend')

@section('page-title')
    Dashboard
@endsection

@section('css_after')
    <!-- DataTables -->
    <link rel="stylesheet" href={{ asset("/add_ons/datatables-bs4/css/dataTables.bootstrap4.css") }}>
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{asset('css/dashboardPrint.css')}}">


    {{--        <link rel="stylesheet" href="https://cdn.metroui.org.ua/v4.3.2/css/metro-all.min.css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <link rel="stylesheet" href="{{ asset("js/plugins/chart.js/Chart.min.css") }}">
@endsection

@section('js_after')
    <!-- DataTables -->
    <script src={{ asset("/add_ons/datatables/jquery.dataTables.js") }}></script>
    <script src={{ asset("/add_ons/datatables-bs4/js/dataTables.bootstrap4.js") }}></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script src="{{ asset("js/plugins/sweetalert2/sweetalert2.all.min.js") }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://unpkg.com/jspdf-autotable@3.2.11/dist/jspdf.plugin.autotable.js"></script>
    <!-- TREE VIEW -->
    {{--        <script src="https://cdn.metroui.org.ua/v4.3.2/js/metro.min.js"></script>--}}
    <script src="{{ asset("/add_ons/tree-view/tree.js") }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
    <script src="{{ asset("js/plugins/chart.js/Chart.min.js") }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>

    <script src="{{ asset("/add_ons/stats/stats.js") }}"></script>
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

@section('content-header')
    <!-- Hero -->
{{--    @if (request()->has('agence_code'))--}}
{{--        <input type="hidden" name="agence_name" id="agence_name" value="{{$agence}}">--}}
{{--    @endif--}}
{{--    @if (request()->has('agent_name'))--}}
{{--        <input type="hidden" name="agent_name" id="agent_name" value="{{$agent}}">--}}
{{--    @endif--}}
    <div class="bg-image overflow-hidden"
         style="background-image: url('{{ asset('/media/backgrounds/photo3@2x.jpg') }}');">
        <div class="bg-primary-dark-op">
            <div class="content content-narrow content-full">
                <div
                    class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center mt-5 mb-2 text-center text-sm-left">
                    <div class="flex-sm-fill">
{{--                        @if (request()->has('agence_code'))--}}
{{--                            <h1 class="font-w600 text-white mb-0 invisible" data-toggle="appear">Tableau de bord--}}
{{--                                Agence {{$agence}}</h1>--}}
{{--                        @elseif(request()->has('agent_name'))--}}
{{--                            <h1 class="font-w600 text-white mb-0 invisible" data-toggle="appear">Tableau de bord--}}
{{--                                Agent {{strtoupper($agent)}}</h1>--}}
{{--                        @else--}}
                            <h1 class="font-w600 text-white mb-0 invisible" data-toggle="appear">Tableau de bord</h1>
{{--                        @endif--}}
                        <h2 class="h4 font-w400 text-white-75 mb-0 invisible" data-toggle="appear" data-timeout="250">
                            Bonjour {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h2>
                    </div>
                    @if (isInAdminGroup())
                        <div class="flex-sm-00-auto mt-3 mt-sm-0 ml-sm-3">
                        <span class="d-inline-block invisible" data-toggle="appear" data-timeout="350">
                            <a class="btn btn-primary px-4 py-2" data-toggle="click-ripple"
                               href="{{ route('tasks.import') }}">
                                <i class="fa fa-plus mr-1"></i> Nouvelle Importation
                            </a>
                        </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- END Hero -->
@endsection
@section('content')
    <!-- Page Content -->
    <div class="content content-narrow">
        <hr class="separator">
        <!-- Stats -->
        <div class="container-fluid">
        </div>
        <!-- END Stats -->
    </div>
@endsection
