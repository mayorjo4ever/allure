@extends('admin.arch_layouts.layout')
@section('content')
<div class="row mt-0 pt-0">
   <div class="col-md-12">
      @include('admin.arch_widgets.alert_messanger')
      @can('create-general-bill')
      
      <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
         <div class="card-header">{{$page_info['title']}} </div>
         <div class="card-body">
             <form id="" class="needs-validation" novalidate="" @if(!empty($billtype['id'])) action="{{url('admin/add-edit-bill/'.$billtype['id'])}}" @else action="{{url('admin/add-edit-bill')}} " @endif  method="post" enctype="multipart/formdata">@csrf
            <div class="form-row">
               <div class="col-md-4 mb-3">
                  <label for="title"  style="font-weight: 600">Bill Name </label>
                  <input type="text" name="name" id="billname" class="form-control form-control-lg"  placeholder="Bill Name "  @if(!empty($billtype['name'])) value="{{$billtype['name']}}" @endif required >
                  <div class="invalid-feedback">
                     Provide Bill Name
                  </div>
               </div> <!-- ./ col-md-3 -->
                     
                <div class="col-md-4 mb-3">
                  <label for="price"  style="font-weight: 600"> Amount </label>
                  <input type="text" name="amount" id="amount" class="form-control form-control-lg"  placeholder="Amount"  @if(!empty($billtype['amount'])) value="{{$billtype['amount']}}" @endif  onkeyup="numberSeperator($(this))" required >
                  <div class="invalid-feedback">
                     Provide Bill Amount
                  </div>
               </div> <!-- ./ col-md-3 -->    
                
            </div> <!--  ./ form-row -->       
           
            <div class="col-md-9 mb-3 mt-2">   &nbsp;  
                  <button class=" btn p-3 btn-primary btn-lg w-100 test-btn ladda-button" data-style="expand-right" type="submit"> <strong> Save Bill   </strong></button>
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
