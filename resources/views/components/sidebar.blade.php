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
       @can('create user')
     <x-menu-item  name="User"  icon="user" path="users.index"/>

           @endcan
           @hasanyrole('admin|editor')
     <x-menu-item  name="Category"  icon="clipboard-list" path="categories.index"/>
     <x-menu-item  name="Destination"  icon="globe" path="destinations.index"/>
     <x-menu-item  name="Packages"  icon="plane" path="trip-packages.index"/>
     <x-menu-item  name="FAQs"  icon="question" path="faqs.index"/>

     @endhasanyrole
     @role('admin')
     <x-menu-item  name="Roles and Permissions"  icon="clipboard-list" path="permissions.index"/>
           @endrole





    <!-- Nav Item - Users -->
    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
