<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard') }}">
        <div class="sidebar-brand-icon  ">
            <i class="fas fa-archway"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Let's Travel</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
     <x-menu-item  name="Dashboard"  icon="tachometer-alt" path="dashboard"/>
     <x-menu-item  name="User"  icon="user" path="users.index"/>
     <x-menu-item  name="Category"  icon="clipboard-list" path="categories.index"/>
     <x-menu-item  name="Roles and Permissions"  icon="clipboard-list" path="permissions.index"/>




    <!-- Nav Item - Users -->
    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
