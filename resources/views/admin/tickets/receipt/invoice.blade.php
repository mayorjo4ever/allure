
@extends('admin.arch_layouts.receipt_layout')
@section('content')
<div class="row mt-0 pt-0">
   <div class="col-xs-12 col-lg-3 col-sm-12 col-md-3 col-lg-offset-3  col-md-offset-3">
       @include('admin.arch_widgets.alert_messanger')

      <div class="col-md-12 bg-white">
        @include('admin.tickets.receipt.inv_body')


      </div>
      <!-- col-md-12 -->

   </div>
   <!-- col-lg-12 -->
</div>
<!-- row -->
@endsection
