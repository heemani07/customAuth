
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">


    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-archway"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Let's Travel</div>
    </a>


    <hr class="sidebar-divider my-0">


    <x-menu-item name="Dashboard" icon="tachometer-alt" path="dashboard" />


    @can('read user')
        <x-menu-item name="Users" icon="user" path="users.index" />
    @endcan

    @can('read category')
        <x-menu-item name="Categories" icon="clipboard-list" path="categories.index" />
    @endcan


    @can('read destination')
        <x-menu-item name="Destinations" icon="globe" path="destinations.index" />
    @endcan


    @can('read package')
        <x-menu-item name="Packages" icon="plane" path="trip-packages.index" />
    @endcan


    @can('read faq')
        <x-menu-item name="FAQs" icon="question" path="faqs.index" />
    @endcan

    @can('read package')
        <x-menu-item name="Roles & Permissions" icon="lock" path="permissions.index" />
    @endcan


    <hr class="sidebar-divider d-none d-md-block">


    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

