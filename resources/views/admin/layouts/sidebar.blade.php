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
                <a href="{{ route($last[1] . '.dashboard.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route($last[1] . '.profile.edit1') }}" class="nav-link">
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
                        Users
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route($last[1] . '.users.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route($last[1] . '.users.create') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create</p>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="nav-item">
                <a href="/admins/adminpackages/1/edit" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Admin Packages
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>

            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Packages
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route($last[1] . '.packages.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route($last[1] . '.packages.create') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create</p>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Payments
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route($last[1] . '.payments.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{ route($last[1].'.payments.create') }}" class="nav-link">
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
                        Bets
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route($last[1] . '.bets.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
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

            <?php /*
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Teams
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route($last[1].'.teams.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{ route($last[1].'.teams.create') }}" class="nav-link">
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
                        Sports
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route($last[1].'.sports.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{ route($last[1].'.sports.create') }}" class="nav-link">
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
                        Odds
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route($last[1].'.odds.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{ route($last[1].'.odds.create') }}" class="nav-link">
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
                        Leagues
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route($last[1].'.leagues.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{ route($last[1].'.leagues.create') }}" class="nav-link">
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
                        Games
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route($last[1].'.games.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{ route($last[1].'.games.create') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create</p>
                        </a>
                    </li> --}}

                </ul>
            </li>
            */
            ?>

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
                        <a href="{{ route($last[1] . '.complains.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{ route($last[1].'.complains.create') }}" class="nav-link">
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
                        Referral Codes
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route($last[1] . '.referralcodes.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route($last[1] . '.referralcodes.create') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create</p>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Blog Categories
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route($last[1] . '.blogcategories.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route($last[1] . '.blogcategories.create') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create</p>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Blogs
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route($last[1] . '.blogs.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route($last[1] . '.blogs.create') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create</p>
                        </a>
                    </li>

                </ul>
            </li>


            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Bulk Mail
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route($last[1] . '.bulkmails.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route($last[1] . '.bulkmails.create') }}?type=specific" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Send to Specific</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route($last[1] . '.bulkmails.create') }}?type=handicappers" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Send to Handicappers</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route($last[1] . '.bulkmails.create') }}?type=bettors" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Send to Bettors</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route($last[1] . '.bulkmails.create') }}?type=all" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Send to All</p>
                        </a>
                    </li>

                </ul>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        CMS
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route($last[1] . '.cmss.index') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>List</p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{ route($last[1].'.cmss.create') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Create</p>
                        </a>
                    </li> --}}

                </ul>
            </li>
            <li class="nav-item">
                <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
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
