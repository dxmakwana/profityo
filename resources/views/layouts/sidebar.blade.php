
@php($adminRoute = config('global.superAdminURL'))
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
      <img src="{{url('public/dist/img/logo.png')}}" alt="Profityo Logo" class="brand-image">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-3">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item {{ (url()->current() == url("/".$adminRoute."/dashboard")) ? 'side_shape' : '' }}">
            <a href="{{ route('dashboard') }}" class="nav-link {{ (url()->current() == url("/".$adminRoute."/dashboard")) ? 'active' : '' }}" >
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="business-list.html" class="nav-link">
              <i class="nav-icon fas fa-regular fa-building"></i>
              <p>
                Business
              </p>
            </a>
          </li>
          <li class="nav-item {{ (url()->current() == url("/".$adminRoute."/plans")) ? 'side_shape' : '' }}">
            <a href="{{ route('plans.index') }}" class="nav-link {{ (url()->current() == url("/".$adminRoute."/plans")) ? 'active' : '' }}">
              <i class="nav-icon fas fa-solid fa-trophy"></i>
              <p>
                Subscription Plans
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>