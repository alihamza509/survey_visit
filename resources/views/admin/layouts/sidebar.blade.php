<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{url('admin/dashboard')}}">
                    {{-- <div class="brand-logo"></div> --}}
                    <img src="{{Storage::url($app_logo)}}" alt="App Logo" width="50">
                    <h2 class="brand-text mb-0">{{ $app_title }}</h2>
                </a></li>
           
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="feather icon-home"></i>
                    <span class="menu-title" data-i18n="Form Layout">Dashboard</span>
                </a>
            </li>
            <li class="nav-item {{ Request::is('admin/user/*') ? 'open' : '' }}">
                <a href="#"><i class="feather icon-user"></i><span class="menu-title" data-i18n="Content">User Management</span></a>
                <ul class="menu-content">
            
                    <li class="{{ Request::is('admin/user/view-admin') ? 'active' : '' }}">
                        <a href="{{ route('admin.user.view-admin') }}">
                            <i class="feather icon-circle"></i><span class="menu-item" data-i18n="View Admin">View Staff</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ Request::is('admin/surveys*') ? 'active' : '' }}">
                <a href="{{ route('surveys.index') }}">
                    <i class="fa fa-list-alt"></i><span class="menu-item" data-i18n="View Surveys">Survey Visit</span>
                </a>
            </li>
                <!-- Sample Orders -->
    <li class="nav-item {{ Request::is('admin/sample-orders*') ? 'active' : '' }}">
        <a href="{{ route('sample-orders.index') }}">
            <i class="fa fa-cube"></i><span class="menu-title" data-i18n="Sample Orders">Sample Orders</span>
        </a>
    </li>
    <li class="nav-item {{ Request::is('admin/follow-ups') ? 'active' : '' }}">
        <a href="{{ route('follow_ups.index') }}">
            <i class="fa fa-cog"></i><span class="menu-item" data-i18n="View Admin">View FollowUp</span>
        </a>
    </li>
    <li class="nav-item {{ Request::is('admin/trial-orders*') ? 'active' : '' }}">
        <a href="{{ route('trial_orders.index') }}">
            <i class="fa fa-clipboard"></i><span class="menu-item" data-i18n="View Trial Orders">Trial Orders</span>
        </a>
    </li>
    
            <li class="nav-item {{ Request::is('admin/expenses*') ? 'active' : '' }}">
                <a href="{{ route('admin.expenses.index') }}">
                    <i class="fa fa-money"></i><span class="menu-item" data-i18n="View Expenses">Expenses</span>
                </a>
            </li>
        
            <li class="nav-item {{ Request::is('admin/setting') ? 'active' : '' }}">
                <a href="{{ route('admin.setting') }}">
                    <i class="fa fa-cog"></i><span class="menu-item" data-i18n="View Admin">Setting</span>
                </a>
            </li>
        </ul>
    </div>
</div>