<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link" style="pointer-events:none;">
    <img src="/AdminLTE/dist/img/InternSightLogo.png" alt="InternSight Logo" class="brand-image elevation-3"
      style="opacity: .8">
    <span class="brand-text font-weight-light">InternSight</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <!-- Gambar avatar pengguna -->
        <a href="{{ route('profile.edit') }}">
          <img src="{{ (Auth::user()->avatar && file_exists(public_path('storage/avatars/' . Auth::user()->avatar))) 
            ? asset('storage/avatars/' . Auth::user()->avatar) 
            : asset('AdminLTE/dist/img/user2-160x160.jpg') }}"
            class="img-circle elevation-2"
          alt="User Image">
        </a>
      </div>
      <div class="info">
        <a href="{{ route('profile.edit') }}" class="d-block">{{ Auth::user()->name }}</a>
      </div>
    </div>


    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Dashboard -->
        <li class="nav-item">
          <a href="{{ route('home') }}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Data Guru -->
        <li class="nav-item">
          <a href="{{ route('guru.index') }}" class="nav-link">
            <i class="nav-icon fas fa-chalkboard-teacher"></i>
            <p>List Guru</p>
          </a>
        </li>

        <!-- Data Jurusan -->
        <li class="nav-item">
          <a href="{{route('jurusan.index')}}" class="nav-link">
            <i class="nav-icon fas fa-scroll"></i>
            <p>List Jurusan</p>
          </a>
        </li>

        <!-- Data Murid -->
        <li class="nav-item">
          <a href="{{route('murid.index')}}" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>List Murid</p>
          </a>
        </li>
        <!-- Data Dudika -->
        <li class="nav-item">
          <a href="{{route('dudika.index')}}" class="nav-link">
            <i class="nav-icon fas fa-briefcase"></i>
            <p>List Dudika</p>
          </a>
        </li>

        <!-- Data Magang -->
        <li class="nav-item">
          <a href="{{ route('magang.index') }}" class="nav-link">
            <i class="nav-icon fas fa-building"></i>
            <p>List Magang</p>
          </a>
        </li>


      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>