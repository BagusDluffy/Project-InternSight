<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a href="{{ route('logout') }}" class="btn logout-btn">
                Logout
            </a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

@push('styles')
<style>
    .logout-btn {
        background-color: transparent !important;
        color: #6c757d !important;
        border: none !important;
        padding: 6px 12px !important;
        transition: all 0.3s ease !important;
    }
    .logout-btn:hover {
        background-color: #dc3545 !important;
        color: white !important;
        border-radius: 4px !important;
    }
</style>
@endpush