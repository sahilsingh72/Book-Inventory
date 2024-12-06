 <!-- sidebar menu area start -->
 @php
     $usr = Auth::guard('admin')->user();
 @endphp
 <div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('backend/assets/images/OKCL-logo1.png') }}" alt="BootstrapBrain Logo" width="175" height="80">
                <h2 class="text-white" style="font-size:25px; margin-top:15px">OKCL</h2> 
                <h2 class="text-white" style="font-size:17px; margin-top:5px">BOOK SYSTEM</h2> 
            </a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">

                    @if ($usr->can('dashboard.view'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-dashboard"></i><span>dashboard</span></a>
                        <ul class="collapse {{ Route::is('admin.dashboard') ? 'in' : '' }}">
                            <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        </ul>
                    </li>
                    @endif

                    @if ($usr->can('book.create') || $usr->can('book.view') ||  $usr->can('book.edit') ||  $usr->can('book.delete') || $usr->can('book.distribution') || $usr->can('book.stock'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-book"></i><span>book</span></a>
                        <ul class="collapse {{ Route::is('admin.book.create') || Route::is('admin.book.index') || Route::is('book-requests.index') || Route::is('book-requests.create') || Route::is('admin.book.edit') || Route::is('admin.book.show') || Route::is('book-requests.alc-distribution') ? 'in' : '' }}">
                            @if($usr->can('book.view'))
                                <li class="{{ Route::is('admin.book.index') ? 'active' : '' }}"><a href="{{ route('admin.book.index') }}">Book</a></li>
                            @endif
                            @if($usr->can('book.stock'))
                                <li class="{{ Route::is('admin.book.stock') ? 'active' : '' }}"><a href="{{ route('admin.book.stock') }}">Book</a></li>
                            @endif
                            @if($usr->can('book.create'))
                                <li class="{{ Route::is('book-requests.create') ? 'active' : '' }}"><a href="{{ route('book-requests.create') }}">Create Request</a></li>
                            @endif
                            @if($usr->can('book.approve'))
                                <li class="{{ Route::is('book-requests.index') ? 'active' : '' }}"><a href="{{ route('book-requests.index') }}">Request arrived</a></li>
                            @endif
                            @if($usr->can('book.distribution'))
                                <li class="{{ Route::is('book-requests.alc-distribution') ? 'active' : '' }}"><a href="{{ route('book-requests.alc-distribution') }}">Book Supply</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    
                    @if ($usr->can('role.create') || $usr->can('role.view') ||  $usr->can('role.edit') ||  $usr->can('role.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-tasks"></i><span>Roles & Permissions </span></a>
                        <ul class="collapse {{ Route::is('admin.roles.create') || Route::is('admin.roles.index') || Route::is('admin.roles.edit') || Route::is('admin.roles.show') ? 'in' : '' }}">
                            @if ($usr->can('role.view'))
                                <li class="{{ Route::is('admin.roles.index')  || Route::is('admin.roles.edit') ? 'active' : '' }}"><a href="{{ route('admin.roles.index') }}">All Roles</a></li>
                            @endif
                            @if ($usr->can('role.create'))
                                <li class="{{ Route::is('admin.roles.create')  ? 'active' : '' }}"><a href="{{ route('admin.roles.create') }}">Create Role</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    @if ($usr->can('admin.create') || $usr->can('admin.view') ||  $usr->can('admin.edit') ||  $usr->can('admin.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-user"></i><span>
                            Admins
                        </span></a>
                        <ul class="collapse {{ Route::is('admin.admins.create') || Route::is('admin.admins.index') || Route::is('admin.admins.edit') || Route::is('admin.admins.show') ? 'in' : '' }}">
                            
                            @if ($usr->can('admin.view'))
                                <li class="{{ Route::is('admin.admins.index')  || Route::is('admin.admins.edit') ? 'active' : '' }}"><a href="{{ route('admin.admins.index') }}">All Admins</a></li>
                            @endif

                            @if ($usr->can('admin.create'))
                                <li class="{{ Route::is('admin.admins.create')  ? 'active' : '' }}"><a href="{{ route('admin.admins.create') }}">Create Admin</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-copy"></i><span>Report</span></a>
                        <ul class="collapse {{ Route::is('challans.index') ? 'in' : '' }}">
                            <li class="{{ Route::is('challans.index') ? 'active' : '' }}"><a href="{{ route('challans.index') }}">challan</a></li>
                        </ul>
                    </li>
                
                </ul>
            </nav>
        </div>
    </div>
</div>
<!-- sidebar menu area end -->