<?php use Carbon\Carbon;  ?>
@extends('admin.arch_layouts.layout')
@section('content')

<div class="row mt-0 pt-0">
    <div class="col-md-12">
        @include('admin.arch_widgets.alert_messanger')
        @can('edit-microorganism')
       <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
         <div class="card-header">{{$page_info['title']}} </div>
         <div class="card-body">
             <form class="needs-validation" novalidate="" method="post" action="{{url('admin/add-edit-micro-organism/'.$micro['id'])}}"> 
                 @csrf
            <div class="form-row">
               <div class="col-md-4 mb-3">
                  <label for="title">Micro-Organism Name </label>
                  <input type="text" value="{{ $micro['name'] }}" name="micro_name" id="micro_name" class="form-control"  placeholder="Micro-Organism Name" required >
                  <input type="hidden" name="micro_id" value="{{$micro['id']}}"  />
                  <div class="invalid-feedback">
                     Provide Micro-Organism Name
                  </div>
               </div>
                
                <div class="col-md-4 mb-3">
                     <?php 
                        $micro_types = ['bacteria','virus','fungi','algae','protozoan']; 
                     ?>
                   <label for="code">Type <small>(Optional)</small> </label>
                   <select name="organism_type" id="organism_type" class="form-control text-capitalize" >
                       <option value="">...</option>
                       @foreach($micro_types as $micro_type)
                       <option value="{{$micro_type}}" @selected($micro['micro_type']==$micro_type) >{{$micro_type}} </option>
                       @endforeach
                   </select>
                  <div class="invalid-feedback">
                     Provide Type of The Organism
                  </div>
                 </div> <?php 
                        $options = explode(',',$micro['treatment']['treatment']); 
                     ?>
                
               <div class="col-md-4 mb-3">
                   <label for="code">Recommended Treatments <small>(Optional)</small> </label>
                   <select multiple="" name="recommends[]" id="recommends" class="form-control select2"  placeholder="Recommended Treatments" >
                       @foreach($treatments as $treatment)
                       <option value="{{$treatment['id']}}" @selected(in_array($treatment['id'],$options)) >{{$treatment['name']}} </option>
                       @endforeach
                   </select>
                  <div class="invalid-feedback">
                     Provide Recommended Treatments
                  </div>
               </div> 
                
               <div class="col-md-6 mb-3">     &nbsp;                        
                  <button class="mt-2 btn btn-primary btn-lg w-100  subject-btn ladda-button" data-style="expand-right" type="submit"> <strong> Save Micro-Organism </strong></button>
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