<?php
   #
   ?>
@extends('admin.arch_layouts.print_layout')
@section('content')
<div class="row mt-0 pt-0">
   <div class="col-md-12 col-sm-12">
       @include('admin.arch_widgets.alert_messanger')

      <div class="col-md-12 bg-white">
        @include('admin.tickets.printing.header')

        @include('admin.tickets.printing.patient_info')

        @include('admin.tickets.printing.report_info')

        @include('admin.tickets.printing.body_report')

        @include('admin.tickets.printing.comment_footer')

      </div>
      <!-- col-md-12 -->

   </div>
   <!-- col-lg-12 -->
</div>
<!-- row -->
@endsection
