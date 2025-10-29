<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Custom  Auth </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Management
    </div>

    <!-- Nav Item - Users -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-users"></i>
            <a href="{{ route('users.index') }}"><span>Users</span></a>
        </a>
    </li>

    <!-- Nav Item - Settings -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-cogs"></i>
            <span>Settings</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Nav Item - Logout -->
    <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button class="nav-link btn btn-link text-left text-white">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </li>

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
