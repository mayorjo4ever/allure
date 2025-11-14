<?php
   #
   ?>
@extends('admin.arch_layouts.download_layout')
@section('content')
<div class="row mt-0 pt-0">
   <div class="col-md-12 col-sm-12">

      <div class="col-md-12 bg-white">
           
          @include('admin.tickets.download.header')

          @include('admin.tickets.download.patient_info')
        
       @if($ticket_info[0]['payment_finalized']=="yes")
        
            @include('admin.tickets.download.report_info')

            @include('admin.tickets.download.body_report')

            @include('admin.tickets.download.comment_footer')
    
      @else 
        
          <x-payment-not-completed></x-payment-not-completed>
        
        @endif
        
      </div>
      <!-- col-md-12 -->

   </div>
   <!-- col-lg-12 -->
</div>
<!-- row -->
@endsection
