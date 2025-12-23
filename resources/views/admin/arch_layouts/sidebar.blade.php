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
    </div>
      <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Dashboards</li>
                <li>
                    <a href="{{url('admin/dashboard')}}" @if(Session::get('subpage')=='dashboard')  class="mm-active"  @endif >
                        <i class="metismenu-icon pe-7s-home"></i>
                        Home
                    </a>
                </li>
                  @can('view-my-profile')
                <li>
                    <a href="{{url('admin/my-profile/'.Auth::guard('admin')->user()->id)}}"  @if(Session::get('subpage')=='my_profile')  class="mm-active"  @endif >
                        <i class="metismenu-icon pe-7s-user">
                        </i> My Profile
                    </a>
                </li> @endcan  <!--
                <li>
                    <a href="{{url('admin/update-admin-details')}}" @if(Session::get('subpage')=='update_profile')  class="mm-active"  @endif >
                        <i class="metismenu-icon pe-7s-user">
                        </i>Update Profile
                    </a>
                </li>  -->

                  @can('view-admin')
                <li class="app-sidebar__heading"> System Settings </li>
                <li>
                    <a href="#" @if(Session::get('page')==="admin_mgt") class="mm-active" @endif >
                        <i class="metismenu-icon pe-7s-users"></i>
                        ADMIN MANAGEMENT
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul  @if(Session::get('page')==="admin_mgt") class="mm-show" @endif >
                           @can('view-admin')
                        <li>
                            <a href="{{url('admin/staff')}}" @if(Session::get('subpage')==="admin-staff")  class="mm-active"  @endif >
                                <i class="metismenu-icon"></i>
                                  View Admin Staff
                            </a>
                        </li>  @endcan

                          @can('create-admin')
                        <li>
                            <a href="{{url('admin/add-edit-staff')}}"  @if(Session::get('subpage')==="add-staff")  class="mm-active"  @endif>
                                <i class="metismenu-icon">
                                </i>  Create New Admin Staff
                            </a>
                        </li>  @endcan

                           @can('import-admin')
                        <li>
                            <a href="{{url('admin/staff/import')}}"  @if(Session::get('subpage')==="import-staff")  class="mm-active"  @endif>
                                <i class="metismenu-icon">
                                </i>  Import Admin Staff
                            </a>
                        </li>   @endcan

                            @can('assign-role')
                        <li>
                            <a href="{{url('admin/staff/assign-role')}}" @if(Session::get('subpage')==="assign_role")  class="mm-active"  @endif >
                                <i class="metismenu-icon"></i>
                                  Assign Role For Staff
                            </a>
                        </li>    @endcan
                    </ul>
                </li>   @endcan



                   @can('view-role')
                <li>
                    <a href="#" @if(Session::get('page')==="role_perm") class="mm-active" @endif >
                        <i class="metismenu-icon pe-7s-wristwatch"></i>
                        ROLES AND PERMISSIONS
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul  @if(Session::get('page')==="role_perm") class="mm-show" @endif >
                          @can('view-role')
                        <li>
                            <a href="{{url('admin/roles')}}" @if(Session::get('subpage')==="roles")  class="mm-active"  @endif >
                                <i class="metismenu-icon"></i>
                                  View Roles
                            </a>
                        </li>  @endcan

                        @can('create-role')
                        <li>
                            <a href="{{url('admin/add-edit-role')}}"  @if(Session::get('subpage')==="add_role")  class="mm-active"  @endif>
                                <i class="metismenu-icon">
                                </i>  Create New Role
                            </a>
                        </li>    @endcan

                         @can('view-permission')
                        <li>
                            <a href="{{url('admin/permissions')}}" @if(Session::get('subpage')==="permissions")  class="mm-active"  @endif >
                                <i class="metismenu-icon"></i>
                                  View Permissions
                            </a>
                        </li>   @endcan

                          @can('create-permission')
                        <li>
                            <a href="{{url('admin/add-edit-permission')}}"  @if(Session::get('subpage')==="add_permission")  class="mm-active"  @endif>
                                <i class="metismenu-icon">
                                </i>  Create New Permission
                            </a>
                        </li>   @endcan

                       @can('assign-permission')
                        <li>
                            <a href="{{url('admin/role-permission')}}"  @if(Session::get('subpage')==="assign_role_perm")  class="mm-active"  @endif>
                                <i class="metismenu-icon">
                                </i> Role Permission Setup
                            </a>
                        </li>    @endcan

                    </ul>
                </li>     @endcan



                @can('view-services')
                <li class="app-sidebar__heading">Drugs and Services </li>
                <li>
                    <a href="#" @if(Session::get('page')==="services") class="mm-active" @endif >
                        <i class="metismenu-icon pe-7s-ball"></i>
                        SERVICES
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul  @if(Session::get('page')==="services") class="mm-show" @endif >
                          @can('view-appointments')
                        <li>
                            <a href="{{url('admin/appointments')}}"  @if(Session::get('subpage')==="all_apps")  class="mm-active"  @endif>
                                <i class="metismenu-icon">
                                </i> View Appointments
                            </a>
                        </li> @endcan

                     @can('create-new-appointment')
                        <li>
                            <a href="{{url('admin/appointment/new')}}"  @if(Session::get('subpage')==="new_app")  class="mm-active"  @endif>
                                <i class="metismenu-icon">
                                </i> Make New Appointment
                            </a>
                        </li> @endcan
                        @can('view-confirmed-appointments')
                        <li>
                            <a href="{{url('admin/appointments/confirmed')}}"  @if(Session::get('subpage')==="app_confirmed")  class="mm-active"  @endif>
                                <i class="metismenu-icon">
                                </i> Confirmed Appointments
                            </a>
                        </li>  @endcan
                        @can('view-awaiting-patients')
                        <li>
                            <a href="{{url('admin/appointments/await-doctor')}}"  @if(Session::get('subpage')==="app_waiters")  class="mm-active"  @endif>
                                <i class="metismenu-icon">
                                </i> Awaiting Patients
                            </a>
                        </li>  @endcan
                        
                        @if(Session::get('subpage')==="app_consulting")                        
                        <li>
                            <a href="{{url('admin/appointments/'.Session::get('app_id').'/admitted')}}"  @if(Session::get('subpage')==="app_consulting")  class="mm-active"  @endif>
                                <i class="metismenu-icon">
                                </i> With A Doctor
                            </a>
                        </li> 
                        @endif
                        
                        @can('process-tests')
                         <li>
                            <a href="{{url('admin/appointments/pending-investigations')}}"  @if(Session::get('subpage')==="pending_investigations")  class="mm-active"  @endif>
                                <i class="metismenu-icon">
                                </i> Pending Investigations
                            </a>
                        </li>                         
                        @endcan
                        
                        @can('view-consultation-notes')
                         <li>
                            <a href="{{url('admin/appointments/consultationnotes')}}"  @if(Session::get('subpage')==="consultation_notes")  class="mm-active"  @endif>
                                <i class="metismenu-icon">
                                </i> Consultation Notes
                            </a>
                        </li> 
                        @endcan
                       
                    </ul>
                </li>
                  @endcan

              @can('view-drugs')
                <li>
                    <a href="#" @if(Session::get('page')==="drugs") class="mm-active" @endif >
                        <i class="metismenu-icon fa fa-database"></i>
                        DRUGS
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul  @if(Session::get('page')==="drugs") class="mm-show" @endif>
                          @can('view-drugs')
                        <li>
                            <a href="{{url('admin/drugs')}}"  @if(Session::get('subpage')==="drugs") class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>Our Drugs
                            </a>
                        </li>
                           @endcan
                       @can('view-drugs-category') <li>
                            <a href="{{url('admin/drugs-category')}}"  @if(Session::get('subpage')==="drugs-categ") class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>Drug Categories
                            </a>
                        </li>
                      @endcan
                      @can('create-new-drugs')
                        <li>
                            <a href="{{url('admin/add-edit-drugs')}}"  @if(Session::get('subpage')==="add-drugs")  class="mm-active"  @endif>
                                <i class="metismenu-icon">
                                </i> Create New Drug
                            </a>
                        </li>   @endcan
                    </ul>
                </li>   @endcan

                @can('view-lenses')
                <li>
                    <a href="#" @if(Session::get('page')==="lenses") class="mm-active" @endif >
                        <i class="metismenu-icon pe-7s-camera"></i>
                       LENSES
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul  @if(Session::get('page')==="lenses") class="mm-show" @endif >
                      @can('view-lenses')
                        <li>
                            <a href="{{url('admin/lenses')}}" @if(Session::get('subpage')==="lenses")  class="mm-active"  @endif >
                                <i class="metismenu-icon"></i>
                                All Lenses
                            </a>
                        </li> @endcan 
                        @can('view-lenses-category') <li>
                            <a href="{{url('admin/lense-category')}}"  @if(Session::get('subpage')==="lenses-categ") class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>Lense Categories
                            </a>
                        </li>
                      @endcan
                      @can('view-lenses-types') <li>
                            <a href="{{url('admin/lense-types')}}"  @if(Session::get('subpage')==="lense-types") class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>Lense Types
                            </a>
                        </li>
                      @endcan
                      @can('create-new-lenses')
                        <li>
                            <a href="{{url('admin/add-edit-lenses')}}" @if(Session::get('subpage')==="add-lensess")  class="mm-active"  @endif >
                                <i class="metismenu-icon"></i>
                                 Create New Lense
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
               @endcan     
               
                @can('view-frames')
                <li>
                    <a href="#" @if(Session::get('page')==="frames") class="mm-active" @endif >
                        <i class="metismenu-icon pe-7s-glasses font-weight-700"></i>
                       FRAMES
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul  @if(Session::get('page')==="frames") class="mm-show" @endif >
                      @can('view-frames')
                        <li>
                            <a href="{{url('admin/frames')}}" @if(Session::get('subpage')==="frames")  class="mm-active"  @endif >
                                <i class="metismenu-icon"></i>
                                All Frames
                            </a>
                        </li> @endcan 
                    
                      @can('create-new-frames')
                        <li>
                            <a href="{{url('admin/add-edit-frames')}}" @if(Session::get('subpage')==="add-frames")  class="mm-active"  @endif >
                                <i class="metismenu-icon"></i>
                                 Create New Frames
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
               @endcan    
                  
               @can('view-tests')
                <li>
                    <a href="#" @if(Session::get('page')==="tests") class="mm-active" @endif >
                        <i class="metismenu-icon pe-7s-settings"></i>
                        TESTS 
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul  @if(Session::get('page')==="tests") class="mm-show" @endif>
                          @can('view-tests')
                        <li>
                            <a href="{{url('admin/tests')}}"  @if(Session::get('subpage')==="tests") class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>View All Tests
                            </a>
                        </li>
                        @endcan
                           
                      @can('create-new-tests')
                        <li>
                            <a href="{{url('admin/add-edit-test')}}"  @if(Session::get('subpage')==="add-test")  class="mm-active"  @endif>
                                <i class="metismenu-icon">
                                </i> Create New Test
                            </a>
                        </li>@endcan 
                        <li>
                            <a href="{{url('admin/questionnaires')}}"  @if(Session::get('subpage')==="app_questionnaires")  class="mm-active"  @endif>
                                <i class="metismenu-icon">
                                </i> Questionnaires
                            </a>
                        </li>                         
                    </ul>
                </li>   @endcan
               
                @can('view-general-bill')
                <li>
                    <a href="#" @if(Session::get('page')==="billings") class="mm-active" @endif >
                        <i class="metismenu-icon pe-7s-cash"></i>
                        BILLINGS / PAYMENT  
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul  @if(Session::get('page')==="billings") class="mm-show" @endif>
                          @can('view-general-bill')
                        <li>
                            <a href="{{url('admin/bills')}}"  @if(Session::get('subpage')==="bills") class="mm-active" @endif >
                                <i class="metismenu-icon">
                                </i>View All Billings
                            </a>
                        </li>
                        @endcan
                           
                      @can('create-general-bill')
                        <li>
                            <a href="{{url('admin/add-edit-bill')}}"  @if(Session::get('subpage')==="add_bill_sample")  class="mm-active"  @endif>
                                <i class="metismenu-icon">
                                </i> Create New Bill
                            </a>
                        </li>@endcan  
                        @can('create-general-bill')
                        <li>
                            <a href="{{url('admin/payments-receipts')}}"  @if(Session::get('subpage')==="pending-payments")  class="mm-active"  @endif>
                                <i class="metismenu-icon">
                                </i> Payments & Receipts
                            </a>
                        </li>@endcan 
                       
                        
                        @can('view-accounts')
                        <li>
                            <a href="{{url('admin/accounts')}}"  @if(Session::get('subpage')==="accounts")  class="mm-active"  @endif>
                                <i class="metismenu-icon">
                                </i> Our Bank Accounts
                            </a>
                        </li>@endcan 
                        @can('create-new-account')
<!--                        <li>
                            <a href="{{url('admin/add-edit-account')}}"  @if(Session::get('subpage')==="new_account")  class="mm-active"  @endif>
                                <i class="metismenu-icon">
                                </i> Create New Account
                            </a>
                        </li>-->
                        @endcan 
                    </ul>
                </li>   @endcan
               
             @can('view-organizations')
              <li>
                    <a href="#" @if(Session::get('page')==="organizations") class="mm-active" @endif >
                        <i class="metismenu-icon pe-7s-home"></i>
                       HMO Management
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul  @if(Session::get('page')==="organizations") class="mm-show" @endif>
                       @can('view-organizations')
                        <li>
                            <a href="{{url('admin/organizations')}}"  @if(Session::get('subpage')==="organizations")  class="mm-active"  @endif>
                                <i class="metismenu-icon">
                                </i> List of HMO's
                            </a>
                        </li>@endcan 
                        
                        <li>
                            <a href="{{url('admin/organizations/invoices/unpaid/')}}"  @if(Session::get('subpage')==="unpaid-invoices")  class="mm-active"  @endif>
                                <i class="metismenu-icon">
                                </i> Unpaid HMO Invoices
                            </a>
                        </li>
                        <li>
                            <a href="{{url('admin/organizations/invoices/paid/')}}"  @if(Session::get('subpage')==="paid-invoices")  class="mm-active"  @endif>
                                <i class="metismenu-icon">
                                </i> Paid HMO Invoices
                            </a>
                        </li>
                      
                    </ul>
              </li>
              @endcan
                
                @can('view-reports')
                 <li>
                    <a href="#" @if(Session::get('page')==="reports") class="mm-active" @endif >
                        <i class="metismenu-icon pe-7s-speaker"></i>
                        REPORTS
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul  @if(Session::get('page')==="reports") class="mm-show" @endif >
                       @can('view-daily-reports')
                        <li>
                           <a href="{{url('admin/daily-reports')}}" @if(Session::get('subpage')==="daily") class="mm-active" @endif >
                               <i class="metismenu-icon pe-7s-user"></i>
                               Daily Reports
                           </a>
                       </li>
                       @endcan
                        @can('view-weekly-reports')
                        <li>
                           <a href="{{url('admin/weekly-reports')}}"   @if(Session::get('subpage')==="weekly") class="mm-active" @endif >
                                <i class="metismenu-icon pe-7s-user"></i>
                                Weekly Reports
                            </a>
                        </li> @endcan

                       @can('view-monthly-reports')
                        <li>
                           <a href="{{url('admin/monthly-reports')}}" @if(Session::get('subpage')==="monthly") class="mm-active" @endif >
                               <i class="metismenu-icon pe-7s-user"></i>
                               Monthly Reports
                           </a>
                       </li>
                       @endcan
                       @can('view-all-reports')
                        <li>
                           <a href="{{url('admin/all-reports')}}" @if(Session::get('subpage')==="all_reports") class="mm-active" @endif >
                               <i class="metismenu-icon pe-7s-user"></i>
                               Overall Reports
                           </a>
                       </li>
                       @endcan
                    </ul>
                </li>@endcan
                
                

                @can('view-customers')
                <li class="app-sidebar__heading"> Customers Management </li>
                 <li>
                    <a href="#" @if(Session::get('page')==="customers") class="mm-active" @endif >
                        <i class="metismenu-icon pe-7s-users"></i>
                        Customers
                        <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
                    </a>
                    <ul  @if(Session::get('page')==="customers") class="mm-show" @endif >
                       @can('create-customer')
                        <li>
                           <a href="{{url('admin/add-edit-customer')}}" @if(Session::get('subpage')==="customer-add") class="mm-active" @endif >
                               <i class="metismenu-icon pe-7s-user"></i>
                               Create New Customer
                           </a>
                       </li>
                       @endcan
                        @can('view-customers')
                        <li>
                           <a href="{{url('admin/customers')}}"   @if(Session::get('subpage')==="customers") class="mm-active" @endif >
                                <i class="metismenu-icon pe-7s-user"></i>
                                View All Customers
                            </a>
                        </li> @endcan

                       @can('import-customers')
                        <li>
                           <a href="{{url('admin/customers/import')}}" @if(Session::get('subpage')==="customers-import") class="mm-active" @endif >
                               <i class="metismenu-icon pe-7s-user"></i>
                               Import More Customers
                           </a>
                       </li>
                       @endcan
                       
                       @can('view-families')
                        <li>
                           <a href="{{url('admin/families')}}" @if(Session::get('subpage')==="families") class="mm-active" @endif >
                               <i class="metismenu-icon pe-7s-user"></i>
                               View Families
                           </a>
                       </li>
                       @endcan
                    </ul>
                </li>
                @endcan

                <li class="mb-5 mt-3">
                    <a onclick="return confirm('Do You Want To Logout Now ?')" href="{{url('portal/logout')}}" class=" text-danger font-weight-600" >
                        <i class="metismenu-icon pe-7s-power text-danger font-weight-600"></i>
                        Logout
                    </a>
                </li>

            </ul>
        </div>
</div>
