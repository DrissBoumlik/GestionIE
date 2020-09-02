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
      @if(isInAdminGroup())
      <li class="nav-main-item">
        <a class="nav-main-link{{ request()->is('dashboard') ? ' active' : '' }}" href="{{ route('dashboard') }}">
          <i class="nav-main-link-icon si si-cursor"></i>
          <span class="nav-main-link-name">Tableau de bord</span>
        </a>
      </li>
      @endif
        {{--                <li class="nav-main-item">--}}
        {{--                    <a class="nav-main-link{{ (request()->is('all-stats') || request()->is('all-stats/*')) ? ' active' : '' }}" href="{{ route('tasks.dataView') }}">--}}
        {{--                        <i class="nav-main-link-icon far fa-chart-bar"></i>--}}
        {{--                        <span class="nav-main-link-name">Statistiques</span>--}}
        {{--                    </a>--}}
        {{--                </li>--}}
          @if(isStandarGroup())
        <li class="nav-main-item{{ request()->is('tasks/') || request()->is('tasks/data/*') ? ' open' : '' }}">
          <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true"
             href="#">
            <i class="nav-main-link-icon far fa-chart-bar"></i>
            <span class="nav-main-link-name">Visualisation des données</span>
          </a>
          <ul class="nav-main-submenu">
            <li class="nav-main-item">
              <a
                class="nav-main-link {{ (request()->is('tasks/data/encours') || request()->is('tasks/data/encours/*')) ? ' active' : '' }}"
                href="{{ route('tasks.dataView', 'encours') }}">
                <span class="nav-main-link-name">En Cours</span>
              </a>
            </li>
            <li class="nav-main-item">
              <a
                class="nav-main-link {{ (request()->is('tasks/data/instance') || request()->is('tasks/data/instance/*')) ? ' active' : '' }}"
                href="{{ route('tasks.dataView', 'instance') }}">
                <span class="nav-main-link-name">Instance</span>
              </a>
            </li>
          </ul>
        </li>
        <li
          class="nav-main-item{{ (request()->is('tasks/filter/urgent') || request()->is('tasks/filter/urgent/*')) ? ' open' : '' }}">
          <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true"
             href="#">
            <i class="nav-main-link-icon far fa-chart-bar"></i>
            <span class="nav-main-link-name">Tâches prioritaires</span>
          </a>
          <ul class="nav-main-submenu">
            <li class="nav-main-item">
              <a
                class="nav-main-link {{ (request()->is('tasks/filter/urgent/encours') || request()->is('tasks/filter/urgent/encours/*')) ? ' active' : '' }}"
                href="{{ route('tasks.dataView.filter', ['status'=>'urgent', 'type'=> 'encours']) }}">
                <span class="nav-main-link-name">En Cours</span>
              </a>
            </li>
            <li class="nav-main-item">
              <a
                class="nav-main-link {{ (request()->is('tasks/filter/urgent/instance') || request()->is('tasks/filter/urgent/instance/*')) ? ' active' : '' }}"
                href="{{ route('tasks.dataView.filter', ['status'=>'urgent', 'type'=> 'instance']) }}">
                <span class="nav-main-link-name">Instance</span>
              </a>
            </li>
          </ul>
        </li>
        <li
          class="nav-main-item{{ (request()->is('tasks/filter/a_traiter') || request()->is('tasks/filter/a_traiter/*')) ? ' open' : '' }}">
          <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true"
             href="#">
            <i class="nav-main-link-icon far fa-chart-bar"></i>
            <span class="nav-main-link-name">Tâches à Traitées</span>
          </a>
          <ul class="nav-main-submenu">
            <li class="nav-main-item">
              <a
                class="nav-main-link {{ (request()->is('tasks/filter/a_traiter/encours') || request()->is('tasks/filter/a_traiter/encours/*')) ? ' active' : '' }}"
                href="{{ route('tasks.dataView.filter', ['status'=>'a_traiter', 'type'=> 'encours']) }}">
                <span class="nav-main-link-name">En Cours</span>
              </a>
            </li>
            <li class="nav-main-item">
              <a
                class="nav-main-link {{ (request()->is('tasks/filter/a_traiter/instance') || request()->is('tasks/filter/a_traiter/instance/*')) ? ' active' : '' }}"
                href="{{ route('tasks.dataView.filter', ['status'=>'a_traiter', 'type'=> 'instance']) }}">
                <span class="nav-main-link-name">Instance</span>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-main-item{{ request()->is('tasks/') || request()->is('/tasks/traite/*') ? ' open' : '' }}">
            <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true"
               href="#">
              <i class="nav-main-link-icon far fa-chart-bar"></i>
              <span class="nav-main-link-name">Tâches Clôturée</span>
            </a>
            <ul class="nav-main-submenu">
              <li class="nav-main-item">
                <a
                  class="nav-main-link {{ (request()->is('tasks/traite/encours') || request()->is('tasks/traite/encours/*')) ? ' active' : '' }}"
                  href="{{ route('tasks.dataView.statutF', 'encours') }}">
                  <span class="nav-main-link-name">En Cours</span>
                </a>
              </li>
              <li class="nav-main-item">
                <a
                  class="nav-main-link {{ (request()->is('tasks/traite/instance') || request()->is('tasks/traite/instance/*')) ? ' active' : '' }}"
                  href="{{ route('tasks.dataView.statutF', 'instance') }}">
                  <span class="nav-main-link-name">Instance</span>
                </a>
              </li>
            </ul>
          </li>
          @endif
       @if(isInAdminGroup())
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
          @if(isStandarGroup())
        <li class="nav-main-item{{ request()->is('import/*') ? ' open' : '' }}">
          <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="true"
             href="#">
            <i class="nav-main-link-icon fas fa-upload"></i>
            <span class="nav-main-link-name">Importation</span>
          </a>
          <ul class="nav-main-submenu">
            <li class="nav-main-item">
              <a class="nav-main-link {{ request()->is('import/tasks') ? ' active' : '' }}"
                 href="{{ route('tasks.importView') }}">
                <span class="nav-main-link-name">Importation des données</span>
              </a>
            </li>
          </ul>
        </li>
          @endif
      @if(isB2bSfrGroup())
        <li class="nav-main-item">
          <a class="nav-main-link {{ request()->is('b2bSfr.create')  ? ' active' : '' }}"
             href="{{ route('b2bSfr.create') }}">
            <i class="nav-main-link-icon si si-shield"></i>
            <span class="nav-main-link-name">New Ticket</span>
          </a>
        </li>
        <li class="nav-main-item">
          <a class="nav-main-link {{ request()->is('b2bSfr/tickets/En cours')  ? ' active' : '' }}"
             href="{{ route('b2bSfr.tickets',['status' => 'En cours']) }}">
            <i class="nav-main-link-icon si si-shield"></i>
            <span class="nav-main-link-name">Status encours</span>
          </a>
        </li>
        <li class="nav-main-item">
          <a class="nav-main-link{{ request()->is('b2bSfr/tickets/valid') ? ' active' : '' }}"
             href="{{ route('b2bSfr.tickets',['status' => 'Validé']) }}">
            <i class="nav-main-link-icon si si-shield"></i>
            <span class="nav-main-link-name">Status validé</span>
          </a>
        </li>
        <li class="nav-main-item">
          <a class="nav-main-link{{ request()->is('b2bSfr/tickets/closed') ? ' active' : '' }}"
             href="{{ route('b2bSfr.tickets',['status' => 'Clôturé']) }}">
            <i class="nav-main-link-icon si si-shield"></i>
            <span class="nav-main-link-name">Status clôturé</span>
          </a>
        </li>
      @endif
        @if(isB2bSfrAdmin())
            <li class="nav-main-item">
                <a class="nav-main-link{{ (request()->is('users') || request()->is('users/*')) ? ' active' : '' }}"
                   href="{{ route('users.index') }}">
                    <i class="nav-main-link-icon si si-users"></i>
                    <span class="nav-main-link-name">Utilisateurs</span>
                </a>
            </li>
        @endif
    </ul>
  </div>
  <!-- END Side Navigation -->
</nav>
