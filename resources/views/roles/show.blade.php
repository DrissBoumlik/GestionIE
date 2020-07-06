@extends('layouts.backend')

@section('page-title')
    Role - {{ ucfirst($role->name) }}
@endsection

@section('css_after')
    <!-- DataTables -->
    <link rel="stylesheet"
          href={{ asset("/add_ons/datatables-bs4/css/dataTables.bootstrap4.css") }}>
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
@endsection
@section('js_after')
    <!-- DataTables -->
    <script src={{ asset("/add_ons/datatables/jquery.dataTables.js") }}></script>
    <script src={{ asset("/add_ons/datatables-bs4/js/dataTables.bootstrap4.js") }}></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script src="{{ asset("/add_ons/roles/role.js") }}"></script>
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
        });
    </script>
@endsection
@section('content-header')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div class="flex-sm-fill">
                    <h1 class="h3 my-2 d-inline-block">Rôles</h1>
                </div>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('dashboard') }}">Tableau de bord</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">Rôle</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->
@endsection
@section('content')
    <div class="profile">
        <form method="POST" action="{{ route('roles.update', $role->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="user-profile-box">
                            <div class="profile-wrapper align-center">
                                <div class="profile-header clearfix">
                                    <div class="user-picture">
                                        <img src="//images2.imgbox.com/d2/3c/VpjmQa5y_o.png" id="user-picture"
                                             alt=""
                                             class="round auth-w">
                                    </div>
                                    <div class="user-name mgt-10 text-capitalize">
                                        <h4>{{ $role->name }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 offset-md-1 mt-sm-5 mt-5 mt-lg-0 mt-xl-0">
                        <div class="update-profile">
                            <div class="header">
                                <h2 class="capitalize">Modifé Rôle</h2>
                            </div>
                            <hr>
                            <div class="profile-data">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="firstname">Nom</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" class="form-control form-field capitalize" id="name"
                                                   name="name"
                                                   aria-describedby="emailHelp" placeholder="Role name"
                                                   value="{{ $role->name }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="lastname">Description</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" class="form-control form-field capitalize"
                                                   id="description"
                                                   name="description"
                                                   aria-describedby="emailHelp" placeholder="Role description"
                                                   value="{{ $role->description }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row update-btn mt-lg-5 mt-sm-0">
                                    <div class="col-md-6 mt-3">
                                        <button type="submit" class="btn btn-primary full-w">
                                            <span class="btn-field font-weight-normal pr-4 position-relative">Modifié</span>
                                        </button>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <button class="btn btn-danger full-w delete-role"
                                                data-role="{{ $role->id }}">
                                            <span
                                                class="btn-field font-weight-bold pr-3 position-relative">Supprimer</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
        </form>
    </div>
@endsection
