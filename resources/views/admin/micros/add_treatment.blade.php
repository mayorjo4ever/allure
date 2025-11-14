<?php use Carbon\Carbon;  ?>
@extends('admin.arch_layouts.layout')
@section('content')

<div class="row mt-0 pt-0">
    <div class="col-md-12">
        @include('admin.arch_widgets.alert_messanger')
        @can('create-microorganism-treatment')
       <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
         <div class="card-header">{{$page_info['title']}} </div>
         <div class="card-body">
             <form class="needs-validation" novalidate="" method="post" action="{{url('admin/add-edit-micro-organism-treatment/')}}"> 
                 @csrf
            <div class="form-row">
               <div class="col-md-4 mb-3">
                  <label for="title">Treatment Name </label>
                  <input type="text" name="treatment_name" id="treatment_name" class="form-control"  placeholder="Treatment Name" required >
                  <input type="hidden" name="treatm_id"  />
                  <div class="invalid-feedback">
                     Provide Treatment Name
                  </div>
               </div>
                  
               <div class="col-md-4 mb-3">     &nbsp;                        
                  <button class="mt-2 btn btn-primary btn-lg w-100  treatment-btn ladda-button" data-style="expand-right" type="submit"> <strong> Save Treatment </strong></button>
               </div>
            </div>
            </form>
         </div>
         <!-- ./ card-body -->              
      </div>
         @else 
            <x-un-authorized-page/>
        @endcan
    </div>
</div>

@endsection 