<?php 
   use App\Models\Subject;
   ?>
@extends('admin.arch_layouts.layout')
@section('content')
<div class="row mt-0 pt-0">
   <div class="col-lg-12">
       @include('admin.arch_widgets.alert_messanger')
         
      <div class="col-md-12  float-left">
         <div class="main-card mt-0 pt-0 mb-4 pb-4 card">
            <div class="card-header"> {{$page_info['title']}}  </div>
            <div class="card-body">
                 @include('admin.tickets.payment.payment_layout')
            </div>
            <!-- card-body --> 
         </div>
         <!-- main-card --> 
      </div>
      <!-- col-md-7 -->
     
   </div>
   <!-- col-lg-12 --> 
</div>
<!-- row --> 
@endsection
