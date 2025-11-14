<?php 
   use App\Models\Subject;
   ?>
@extends('admin.arch_layouts.layout')
@section('content')
<div class="row mt-0 pt-0">
   <div class="col-lg-12">
       @include('admin.arch_widgets.alert_messanger')
       @can('create-customer')
      <form  class="needs-validation" novalidate id="studentForm" @if(!empty($student['id'])) action="{{url('admin/add-edit-customer/'.$student['id'])}}" @else action="{{url('admin/add-edit-customer')}} " @endif  method="post">@csrf
       <input type="hidden" name="stud_id" id="stud_id" value="{{base64_encode($student['id'])}}" />
       <input type="hidden" name="family_id" id="family_id" value="{{$student['family_id']}}" />
      <div class="col-md-12  float-left">
         <div class="main-card mt-0 pt-0 mb-4 pb-4 card">
            <div class="card-header"> {{$page_info['title']}}  </div>
            <div class="card-body">
                 @include('admin.customers.customer_basic_info_form')
                 @include('admin.customers.customer_residence_form')
                 @include('admin.customers.customer_nok_form')
            </div>
            <!-- card-body --> 
         </div>
         <!-- main-card --> 
      </div>
      <!-- col-md-7 -->
      </form> 
       
        @else 
            <x-un-authorized-page/>
        @endcan
      
   </div>
   <!-- col-lg-12 --> 
  
</div>
<!-- row --> 
@endsection
