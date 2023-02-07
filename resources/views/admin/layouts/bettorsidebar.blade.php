<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 text-center">
        {{-- <div class="image">
            <img src="/images/profile/{{ auth()->user()->image }}" class="img-circle elevation-2" alt="User Image" />
        </div> --}}
        <div class="info text-center">
            <a href="#" class="d-block">{{ auth()->user()->name }}</a>
        </div>
    </div>


    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
       with font-awesome or any other icon font library -->

            <li class="nav-item">
                <a href="{{ route('bettorscrm.dashboard.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('bettorscrm.profile.edit1')}}" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        My Profile
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>

            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Email Options
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route($last[1].'.emailoptions.edit',auth()->user()->id) }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Edit</p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{ route($last[1].'.bets.create') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create</p>
                        </a>
                    </li> --}}

                </ul>
            </li>
            {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Users
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('bettorscrm.users.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('bettorscrm.users.create') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create</p>
                        </a>
                    </li>

                </ul>
            </li> --}}
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Subscriptions
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('bettorscrm.packages.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
                        </a>
                    </li>


                </ul>
            </li>
            {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Payments
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('bettorscrm.payments.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
                        </a>
                    </li>


                </ul>
            </li> --}}
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Bets
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('bettorscrm.bets.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{ route('bettorscrm.bets.create') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create</p>
                        </a>
                    </li> --}}

                </ul>
            </li>



            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Complains
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('bettorscrm.complains.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('bettorscrm.complains.create') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create</p>
                        </a>
                    </li>

                </ul>
            </li>

            <li class="nav-item">
                <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    <form method="POST" id="logout-form" action="{{ route('logout') }}">
                        @csrf
                    </form>
                    <i class="fas fa-sign-out-alt nav-icon"></i>

                    {{ __('Log Out') }}
                </a>
            </li>


        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
