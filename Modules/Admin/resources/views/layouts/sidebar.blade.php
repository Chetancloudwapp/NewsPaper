<aside class="main-sidebar sidebar-dark-primary elevation-4"> 
    <a href="{{ url('admin/dashboard')}}" class="brand-link"> 
        <img src="{{ asset('public/assets/images/newspaper.png')}}" alt="NewsPaper Logo" class="brand-image img-circle elevation-3" > 
        <span class="brand-text font-weight-bold"><b>News Paper</b></span> 
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item"> 
                    <a href="{{ url('admin/dashboard')}}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}"> <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p> Dashboard </p>
                    </a>
                </li>
                <li class="nav-item menu-is-opening menu-open"> 
                    <a href="#" class="nav-link {{ Request::is('admin/change_password') || Request::is('admin/view_profile') || Request::is('admin/edit_profile')? 'active' : ''}}"> <i class="fa-solid fa-gear"></i>
                        <p> Settings <i class="fas fa-angle-left right"></i> </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> 
                            <a href="{{ url('admin/change_password')}}" class="nav-link {{ Request::is('admin/change_password') ? 'active' : ''}}"> <i class="far fa-circle nav-icon"></i>
                                <p> Change Password </p>
                            </a> 
                        </li>
                        {{-- <li class="nav-item"> 
                            <a href="{{ url('admin/view_profile')}}" class="nav-link {{ Request::is('admin/view_profile') || Request::is('admin/edit_profile') ? 'active' : ''}}"> <i class="far fa-circle nav-icon"></i>
                                <p> Edit Profile </p>
                            </a> 
                        </li>
                        <li class="nav-item"> 
                            <a href="deactive_account.php" class="nav-link"> <i class="far fa-circle nav-icon"></i>
                                <p> Deactivate Account </p>
                            </a> 
                        </li> --}}
                    </ul>
                </li>
                <li class="nav-item"> 
                    <a href="{{ url('admin/category')}}" class="nav-link {{ Request::is('admin/category') || Request::is('admin/category/add') ? 'active' : ''}}"> <i class="fa-solid fa-layer-group"></i>&nbsp;&nbsp;
                        <p>Categories</p>
                    </a> 
                </li>
                <li class="nav-item"> 
                    <a href="{{ url('admin/tags')}}" class="nav-link {{ Request::is('admin/tags') || Request::is('admin/tags/add') ? 'active' : ''}}"> <i class="fa-solid fa-tag"></i>&nbsp;&nbsp;
                        <p>Tags</p>
                    </a> 
                </li>
                <li class="nav-item"> 
                    <a href="{{ url('admin/users')}}" class="nav-link {{ Request::is('admin/users') || Request::is('admin/users/add') ? 'active' : ''}}"> <i class="fa-solid fa-users"></i>&nbsp;&nbsp;
                        <p>Users</p>
                    </a> 
                </li>
                <li class="nav-item"> 
                    <a href="{{ url('admin/news')}}" class="nav-link {{ Request::is('admin/news') || Request::is('admin/news/add') ? 'active' : ''}}"> <i class="fa-solid fa-newspaper"></i>&nbsp;&nbsp;
                        <p>News</p>
                    </a> 
                </li>
                <li class="nav-item menu-is-opening menu-open"> 
                    <a href="#" class="nav-link {{ Request::is('admin/change_password') || Request::is('admin/view_profile') || Request::is('admin/edit_profile')? 'active' : ''}}"> <i class="fa-solid fa-file"></i>&nbsp;&nbsp;&nbsp;
                        <p> Pages 
                            <i class="fas fa-angle-left right"></i>
                         </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> 
                            <a href="{{ url('admin/privacy-policy')}}" class="nav-link {{ Request::is('admin/privacy-policy') || Request::is('admin/edit-privacy-policy') ? 'active' : ''}}"> <i class="far fa-circle nav-icon"></i>
                                <p> Privacy Policy </p>
                            </a> 
                        </li>
                        <li class="nav-item"> 
                            <a href="{{ url('admin/terms-and-conditions')}}" class="nav-link {{ Request::is('admin/terms-and-conditions') ? 'active' : ''}}"> <i class="far fa-circle nav-icon"></i>
                                <p>Terms and Conditions</p>
                            </a> 
                        </li>
                    </ul>
                </li>
                <li class="nav-item"> 
                    <a href="{{ url('admin/logout')}}" class="nav-link"> <i class="nav-icon fas fa-th"></i>
                        <p> Logout </p>
                    </a> 
                </li>
            </ul>
        </nav>
    </div>
</aside>