<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta http-equiv="Content-Language" content="en">
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
      <title> {{ $page_info['title']??'Online Stores' }}</title>
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
      <meta name="description" content="This is an example dashboard created using build-in elements and components.">
      <meta name="msapplication-tap-highlight" content="no">      
      <link href="{{asset('template/arch/main.css')}}" rel="stylesheet">
      
      <link href="{{asset('template/arch/assets/css/select2.min.css')}}" rel="stylesheet">
      <link href="{{asset('template/arch/assets/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
      <link rel="stylesheet" href="{{ url('front/css/notyf.min.css')}}">
      <link rel="stylesheet" href="{{ url('front/css/flatpickr.min.css')}}">
      <link rel="stylesheet" href="{{url('front/css/ladda-themeless.css')}}"> 
      @stack('style') 
   </head>
   <body>
      <div class="app-container app-theme-white body-tabs-shadow  fixed-header"> <!--fixed-sidebar-->
         @include('admin.arch_layouts.app_header')
         @php # @include('admin.arch_layouts.theme_settings') @endphp
         <div class="app-main">
            <div class="app-sidebar sidebar-shadow">
               @include('admin.arch_layouts.sidebar')
            </div>
            <div class="app-main__outer">
               <div class="app-main__inner">
                  @include('admin.arch_layouts.page_title')
                  @yield('content')
               </div>
               <div class="app-wrapper-footer">
                  @include('admin.arch_layouts.footer')
               </div>
            </div>
         </div>
      </div>
      <script src="{{url('front/js/jquery-3.3.1.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('template/arch/assets/scripts/main.js')}}"></script>
      <script type="text/javascript" src="{{asset('template/arch/assets/scripts/jquery.dataTables.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('template/arch/assets/scripts/dataTables.bootstrap4.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('template/arch/assets/scripts/sweetalert2.all.min.js')}}"></script>
      
      <script src="{{ url('front/js/notyf.min.js')}}"></script>
      <script type="text/javascript" src="{{asset('template/dist/js/custom.js')}}"></script>
      <script type="text/javascript" src="{{asset('template/dist/js/select2.min.js')}}"></script>
      <script src="{{url('front/js/spin.js')}}"></script>    
      <script src="{{url('front/js/ladda.js')}}"></script>         
      <script type="text/javascript" src="{{asset('template/arch/assets/scripts/bootstrap.bundle.min.js')}}"></script>
     
   
      
      @stack('scripts') 
     @if(in_array(Session::get('subpage'),['bill-template-setup','app_consulting']))      
     <!--<script src="https://cdn.jsdelivr.net/npm/tinymce@6.7.0/tinymce.min.js"></script>-->
   <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/super-build/ckeditor.js"></script>

     <!--<script src="{{url('template/dist/tinymce/js/tinymce/tinymce.min.js')}}"></script>-->
    @endif
     <script src="{{url('front/js/flatpickr.min.js')}}"></script>    
    <script>
                // Example starter JavaScript for disabling form submissions if there are invalid fields
                (function() {
                    'use strict';
                    window.addEventListener('load', function() {
                        // Fetch all the forms we want to apply custom Bootstrap validation styles to
                        var forms = document.getElementsByClassName('needs-validation');
                        // Loop over them and prevent submission
                        var validation = Array.prototype.filter.call(forms, function(form) {
                            form.addEventListener('submit', function(event) {
                                if (form.checkValidity() === false) {
                                    event.preventDefault();
                                    event.stopPropagation();
                                }
                                form.classList.add('was-validated');
                            }, false);
                        });
                    }, false);
                })();
            </script>
     
            </script>
       @if(in_array(Session::get('subpage'),['customer-add','families',
       'admin-staff','app_consulting']))
        @include('admin.arch_widgets.modals')
       @endif
        
        
   </body>
</html>
