<?php 
   use App\Models\Subject;
   ?>
@extends('admin.arch_layouts.layout')
@section('content')
<div class="row mt-0 pt-0">
   <div class="col-lg-12">
       @include('admin.arch_widgets.alert_messanger')
       @can('create-customer')
        
       <x-admin.card header="Customer Bio-Data">
        <x-admin.customer-basic-form></x-admin.customer-basic-form>         
       </x-admin.card>
        @else 
            <x-un-authorized-page/>
        @endcan
      
   </div>
   <!-- col-lg-12 --> 
  
</div>
<!-- row --> 
@endsection
