<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="content-header bg-white-5">
        <!-- Logo -->
        <a class="font-w600 text-dual" href="{{ URL::to('/') }}">
            <img src="{{ asset('media/logo/circetblack.png') }}" alt="" class="logo">
        </a>
        <!-- END Logo -->

        <!-- Options -->
        <div>
            <!-- Close Sidebar, Visible only on mobile screens -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <a class="d-lg-none text-dual ml-3" data-toggle="layout" data-action="sidebar_close"
               href="javascript:void(0)">
                <i class="fa fa-times"></i>
            </a>
            <!-- END Close Sidebar -->
        </div>
        <!-- END Options -->
    </div>
    <!-- END Side Header -->

    <!-- Side Navigation -->
    <div class="content-side content-side-full">
        <ul class="nav-main">
            <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('dashboard') ? ' active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="nav-main-link-icon si si-cursor"></i>
                    <span class="nav-main-link-name">Tableau de bord</span>
                </a>
            </li>
            @if(isInAdminGroup())
{{--                <li class="nav-main-item">--}}
{{--                    <a class="nav-main-link{{ (request()->is('all-stats') || request()->is('all-stats/*')) ? ' active' : '' }}" href="{{ route('tasks.dataView') }}">--}}
{{--                        <i class="nav-main-link-icon far fa-chart-bar"></i>--}}
{{--                        <span class="nav-main-link-name">Statistiques</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
                <li class="nav-main-item{{ (request()->is('tasks/data') || request()->is('tasks/data/*')) ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                        <i class="nav-main-link-icon far fa-chart-bar"></i>
                        <span class="nav-main-link-name">Visualisation des données</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ (request()->is('tasks/data/encours') || request()->is('tasks/data/encours/*')) ? ' active' : '' }}" href="{{ route('tasks.dataView', 'encours') }}">
                                <span class="nav-main-link-name">En Cours</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ (request()->is('tasks/data/instance') || request()->is('tasks/data/instance/*')) ? ' active' : '' }}" href="{{ route('tasks.dataView', 'instance') }}">
                                <span class="nav-main-link-name">Instance</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link{{ (request()->is('users') || request()->is('users/*')) ? ' active' : '' }}"
                       href="{{ route('users.index') }}">
                        <i class="nav-main-link-icon si si-users"></i>
                        <span class="nav-main-link-name">Utilisateurs</span>
                    </a>
                </li>
            @endif
            @if(isSuperAdmin())
                <li class="nav-main-item">
                    <a class="nav-main-link{{ (request()->is('roles') || request()->is('roles/*')) ? ' active' : '' }}"
                       href="{{ route('roles.index') }}">
                        <i class="nav-main-link-icon si si-shield"></i>
                        <span class="nav-main-link-name">Rôles</span>
                    </a>
                </li>
            @endif
            @if(isInAdminGroup())
                <li class="nav-main-item{{ request()->is('import/*') ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true" href="#">
                        <i class="nav-main-link-icon fas fa-upload"></i>
                        <span class="nav-main-link-name">Importation</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link {{ request()->is('import/tasts') ? ' active' : '' }}" href="{{ route('tasks.importView') }}">
                                <span class="nav-main-link-name">Importation des données</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
    <!-- END Side Navigation -->
</nav>
