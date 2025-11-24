<?php 
   use App\Models\Subject;
   ?>
@extends('admin.arch_layouts.layout')
@section('content')
<div class="row mt-0 pt-0">
   <div class="col-lg-12">
      @include('admin.arch_widgets.alert_messanger')
      @can('create-admin')
      
      <form class="needs-validation" novalidate  id="studentForm" @if(!empty($admin['id'])) action="{{url('admin/add-edit-staff/'.$admin['id'])}}" @else action="{{url('admin/add-edit-staff')}} " @endif  method="post">@csrf
      
      <div class="col-md-12  float-left">
         <div class="main-card mt-0 pt-0 mb-4 pb-4 card">
            <div class="card-header"> {{$page_info['title']}}  </div>
            <div class="card-body">
               
               <div class="form-row">
                 <div class="col-md-3 mb-3">
                     <label for="title">Title  </label>
                     @php $titles = ['Mr.','Mrs.','Miss','Dr.','Dr.(Mrs.)','Prof.']; @endphp 
                     <select name="title" id="user-title" class="form-control">
                         <option value="">...</option>
                         @foreach($titles as $title)
                        <option value="{{$title}}" @if($admin['title']==$title))  selected="" @endif >{{$title}}</option>
                        @endforeach
                     </select>
                     <div class="invalid-feedback">
                        Provide Your Title
                     </div>
                  </div>
                  <!-- col-md-3  -->
                  <div class="col-md-3 mb-3">
                     <label for="title">Surname  </label>
                     <input type="text" @if(!empty($admin['surname'])) value="{{$admin['surname']}}" @endif  name="surname" id="user-surname" class="form-control" required > 
                     <div class="invalid-feedback">
                        Provide Your Surname
                     </div>
                  </div>
                  <!-- col-md-3 -->
                  <div class="col-md-3 mb-3">
                     <label for="title">First Name </label>
                     <input type="text" @if(!empty($admin['firstname'])) value="{{$admin['firstname']}}" @endif  name="firstname" id="user-firstname" class="form-control" required >                        
                     <div class="invalid-feedback">
                        Provide First Name
                     </div>
                  </div>
                  <!-- col-md-3 -->
                  <div class="col-md-3 mb-3">
                     <label for="title">Other Name </label>
                     <input type="text" @if(!empty($admin['othername'])) value="{{$admin['othername']}}" @endif  name="othername" id="user-othername" class="form-control" >                        
                     <div class="invalid-feedback">
                        Provide Other Name
                     </div>
                  </div>
                  <!-- col-md-3 -->
               </div>
               <!-- ./ form-row --> 
               <div class="form-row">                  
                  <div class="col-md-3 mb-3">
                     <label for="title">Email </label>
                     <input type="email"  @if(!empty($admin['email'])) value="{{$admin['email']}}" @endif name="email" id="user-email" class="form-control" required="" >                        
                     <div class="invalid-feedback">
                        Provide Email
                     </div>
                  </div> <!-- col-md-3 -->
                   <div class="col-md-3 mb-3">
                     <label for="title">Mobile Phone </label>
                     <input type="number"  @if(!empty($admin['mobile'])) value="{{$admin['mobile']}}" @endif name="mobile" id="user-mobile" class="form-control" required="" >                        
                     <div class="invalid-feedback">
                        Provide Mobile Phone 
                     </div>
                  </div> <!-- col-md-3 -->
                  
                  <div class="col-md-3 mb-3">
                     <label for="title">Alternative Login ID </label>
                     <input type="text"  @if(!empty($admin['regno'])) value="{{$admin['regno']}}" @endif name="regno" id="user-regno" class="form-control" >                        
                     <div class="invalid-feedback">
                        Provide Alternative Login ID 
                     </div>
                  </div> <!-- col-md-3 -->
                  
                  <div class="col-md-3 mb-3">
                      <div>
                        <div class="custom-checkbox custom-control custom-control-inline  mb-1">
                            <input name="reset_password" value="yes" type="checkbox" id="reset_password" class="custom-control-input">
                             <label class="custom-control-label" for="reset_password">Reset Password To New </label>
                        </div>
                       </div>
                      <input type="text" name="password" id="user-password" class="form-control mt-1" placeholder="New Password" >
                  </div>
               </div>
               <!-- form-row-->
               <div class="form-row">
                  <div class="col-md-12 mb-3"> &nbsp;                        
                     <button class="mt-2 btn btn-primary btn-lg w-100  subject-btn ladda-button" data-style="expand-right" type="submit"> <strong> Save Admin Info  </strong></button>
                  </div>
               </div>
               <!-- form-row-->
             
            </div>
            <!-- card-body --> 
         </div>
         <!-- main-card --> 
      </div> <!-- col-md-7 -->
         
     </form> 
     
        @else 
            <x-un-authorized-page/>
        @endcan
   </div>
   <!-- col-lg-12 --> 
</div>
<!-- row --> 
@endsection
