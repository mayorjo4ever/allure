@extends('admin.arch_layouts.layout')
@section('content')
<div class="row mt-0 pt-0">
   <div class="col-md-12">
      @include('admin.arch_widgets.alert_messanger')
      @can('create-new-organization')
      
      <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
         <div class="card-header">{{$page_info['title']}} </div>
         <div class="card-body">
             <form id="" class="needs-validation" novalidate="" @if(!empty($organization->id)) action="{{url('admin/add-edit-organization/'.$organization->id)}}" @else action="{{url('admin/add-edit-organization')}} " @endif  method="post" enctype="multipart/formdata">@csrf
            <div class="form-row">
               <div class="col-md-5 mb-3">
                  <label for="title"  style="font-weight: 600">Organization Name </label>
                  <input type="text" name="name" id="name" class="form-control form-control-lg"  placeholder="Organization Name "  @if(!empty($organization->name)) value="{{$organization->name}}" @endif required >
                  <div class="invalid-feedback">
                     Provide Organization Name
                  </div>
               </div> <!-- ./ col-md-3 -->
                     
               <div class="col-md-5 mb-3">
                  <label for="title"  style="font-weight: 600">Organization Address </label>
                  <input type="text" name="address" id="address" class="form-control form-control-lg"  placeholder="Organization Address"  @if(!empty($organization->address)) value="{{$organization->address}}" @endif required >
                  <div class="invalid-feedback">
                     Provide Organization Address
                  </div>
               </div> <!-- ./ col-md-3 -->
                     
                <div class="col-md-5 mb-3">
                  <label for="price"  style="font-weight: 600"> Contact Email </label>
                  <input type="email" name="email" id="email" class="form-control form-control-lg"  placeholder=" Contact Email"  @if(!empty($organization->email)) value="{{$organization->email}}" @endif  >
                  <div class="invalid-feedback">
                     Provide Contact Email
                  </div>
               </div> <!-- ./ col-md-3 -->   
               
               <div class="col-md-5 mb-3">
                  <label for="price"  style="font-weight: 600"> Contact Number </label>
                  <input type="text" name="number" id="number" class="form-control form-control-lg"  placeholder=" Contact Number"  @if(!empty($organization->phone)) value="{{$organization->phone}}" @endif  >
                  <div class="invalid-feedback">
                     Provide Contact Number
                  </div>
               </div> <!-- ./ col-md-3 -->   
                
                
            </div> <!--  ./ form-row -->       
           
            <div class="col-md-12 mb-3 mt-2">   &nbsp;  
                  <button class=" btn p-3 btn-primary btn-lg w-100 organization-btn ladda-button" data-style="expand-right" type="submit"> <strong> Save Organization Body   </strong></button>
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

@endsection
