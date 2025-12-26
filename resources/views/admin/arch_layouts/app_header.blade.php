<div class="app-header header-shadow">
            <div class="app-header__logo">
                <div class="logo-src"></div>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>    <div class="app-header__content">
                <div class="app-header-left">
                    <div class="search-wrapper">
                        <div class="input-holder">
                            <input type="text" class="search-input" placeholder="Type to search">
                            <button class="search-icon"><span></span></button>
                        </div>
                        <button class="close"></button>
                    </div>
                    <ul class="header-menu nav">
                       @can('create-ticket')
                        <li class="nav-item">
                            <a href="{{url('admin/create-ticket')}}" class="nav-link">
                                <i class="nav-link-icon fa fa-database"> </i>
                                <span class="font-weight-600">Create New Ticket</span>
                            </a>
                        </li>@endcan                 

                          @can('view-ticket-payment')
                        <li class="btn-group nav-item">
                            <a href="{{url('admin/ticket-payment')}}" class="nav-link">
                                <i class="nav-link-icon pe-7s-credit pe-2x text-dark"></i>
                                <span class="font-weight-600"> BIll Payment </span>
                            </a>
                        </li>@endcan

                         @can('create-customer')
                        <li class="dropdown nav-item">
                            <a href="{{url('admin/add-edit-customer')}}" class="nav-link ">
                                <i class="nav-link-icon pe-7s-user pe-2x text-dark"></i>
                                <span class="font-weight-600">Create New Customer</span>
                            </a>
                        </li>@endcan
                        
                         @can('view-appointments')
                        <li class="nav-item">
                            <a href="{{url('admin/appointments/completed/recents')}}" class="nav-link">
                                <i class="nav-link-icon fa fa-users"> </i>
                                <span class="font-weight-600">Recent Consultants </span>
                            </a>
                        </li>@endcan
                        
                    </ul>        </div>
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                            <img width="42" class="rounded-circle" src="assets/images/avatars/1.jpg" alt="">
                                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                             <a  href="{{url('portal/logout')}}"  class="dropdown-item">Logout</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-heading">
                                          {{ Auth::guard('admin')->user()->surname." ". Auth::guard('admin')->user()->firstname}}
                                    </div>
                                    <div class="widget-subheading">
                                      {{ ucfirst(Auth::guard('admin')->user()->type)}}
                                    </div>
                                </div>
                                <div class="widget-content-right header-user-info ml-3">
                                    <button type="button" class="btn-shadow p-1 btn btn-primary btn-sm show-toastr-example">
                                        <i class="fa text-white fa-calendar pr-1 pl-1"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>        </div>
            </div>
        </div>
