@extends('admin.arch_layouts.layout')
@section('content')
<div class="row mt-0 pt-0">
   <div class="col-md-12">
      @include('admin.arch_widgets.alert_messanger')
      @can('create-new-account')
      
      <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
         <div class="card-header">{{$page_info['title']}} </div>
         <div class="card-body">
             <form id="" class="needs-validation" novalidate="" @if(!empty($account['id'])) action="{{url('admin/add-edit-account/'.$account['id'])}}" @else action="{{url('admin/add-edit-account')}} " @endif  method="post" enctype="multipart/formdata">@csrf
            <div class="form-row">
               <div class="col-md-4 mb-3">
                  <label for="title"  style="font-weight: 600">Bank Name </label>
                  <input type="text" name="bank" id="bank" class="form-control form-control-lg"  placeholder="Bank Name "  @if(!empty($account['bank'])) value="{{$account['bank']}}" @endif required >
                  <div class="invalid-feedback">
                     Provide Bank Name
                  </div>
               </div> <!-- ./ col-md-3 -->
                     
               <div class="col-md-4 mb-3">
                  <label for="title"  style="font-weight: 600">Account Name </label>
                  <input type="text" name="name" id="name" class="form-control form-control-lg"  placeholder="Account Name "  @if(!empty($account['name'])) value="{{$account['name']}}" @endif required >
                  <div class="invalid-feedback">
                     Provide Account Name
                  </div>
               </div> <!-- ./ col-md-3 -->
                     
                <div class="col-md-4 mb-3">
                  <label for="price"  style="font-weight: 600"> Account Number </label>
                  <input type="text" name="number" id="number" class="form-control form-control-lg"  placeholder="Account Number"  @if(!empty($account['number'])) value="{{$account['number']}}" @endif  required >
                  <div class="invalid-feedback">
                     Provide Account Number
                  </div>
               </div> <!-- ./ col-md-3 -->   
               
               <div class="col-md-3 mb-3"> 
                    <label class="mt-2" style="font-weight: 600"> Is The Primary Account </label> <br/>
                    <label class="switch">  
                        <input  type="checkbox" id="is_main_account" name="is_main_account" value="1" @if($account['active']==1) checked @endif >
                        <span class="slider round"></span>
                    </label> 
                </div>   <!-- ./ col-md-3 -->               
               
                
            </div> <!--  ./ form-row -->       
           
            <div class="col-md-12 mb-3 mt-2">   &nbsp;  
                  <button class=" btn p-3 btn-primary btn-lg w-100 test-btn ladda-button" data-style="expand-right" type="submit"> <strong> Save Bank Account   </strong></button>
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
