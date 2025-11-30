@extends('admin.arch_layouts.layout')
@section('content')
<div class="row mt-0 pt-0">
   <div class="col-md-12">
      @include('admin.arch_widgets.alert_messanger')
      @can('create-new-lenses')
      
      <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
         <div class="card-header">{{$page_info['title']}} </div>
         <div class="card-body">
             <form id="" class="needs-validation" novalidate="" @if(!empty($frame['id'])) action="{{url('admin/add-edit-frames/'.$frame['id'])}}" @else action="{{url('admin/add-edit-frames')}} " @endif  method="post" enctype="multipart/formdata">@csrf
            <div class="form-row">
               <div class="col-md-4 mb-3">
                  <label for="title"  style="font-weight: 600">Frame Name </label>
                  <input type="text" name="name" id="billname" class="form-control"  placeholder="Frame Name "  @if(!empty($frame['name'])) value="{{$frame['name']}}" @endif required >
                  <div class="invalid-feedback">
                     Provide Frame Name
                  </div>
               </div> <!-- ./ col-md-3 -->
               
               
            </div> <!-- ./ form-row -->
            
            <div class="form-row">
                <div class="col-md-4 mb-3">
                  <label for="title"  style="font-weight: 600"> Purchase Price </label>
                  <input type="text" name="price1" id="price1" class="form-control"  placeholder="Purchase Price "  @if(!empty($frame['purchase_price'])) value="{{$frame['purchase_price']}}" @endif  onkeyup="numberSeperator($(this))" required >
                  <div class="invalid-feedback">
                     Provide Purchase Price
                  </div>
               </div> <!-- ./ col-md-3 -->       
               
                <div class="col-md-4 mb-3">
                  <label for="title"  style="font-weight: 600"> Selling Price </label>
                  <input type="text" name="price2" id="price2" class="form-control"  placeholder="Selling Price "  @if(!empty($frame['sales_price'])) value="{{$frame['sales_price']}}" @endif  onkeyup="numberSeperator($(this))" required >
                  <div class="invalid-feedback">
                     Provide Selling Price
                  </div>
               </div> <!-- ./ col-md-3 -->   
            </div> <!-- ./ form row -->
            
            <div class="form-row">
                <div class="col-md-4 mb-3">
                  <label for="title"  style="font-weight: 600"> Initial Quantity </label>
                  <input readonly="" type="text" name="init_qty" id="init_qty" class="form-control bg-white"  placeholder="Initial Quantity"  @if(!empty($frame['qty_rem'])) value="{{$frame['qty_rem']}}" @else value="{{0}}" @endif  onkeyup="numberSeperator($(this))" required="" >
                  <div class="invalid-feedback">
                     Initial Quantity
                  </div>
               </div> <!-- ./ col-md-3 -->               
               
                <div class="col-md-4 mb-3">
                  <label for="title"  style="font-weight: 600"> New Quantity Adding </label>
                  <input type="text" name="new_qty" id="new_qty" class="form-control" value="0"  placeholder="New Quantity Adding"  onkeyup="numberSeperator($(this))" required="" >
                  <div class="invalid-feedback">
                     Provide New Quantity Adding
                  </div>
               </div> <!-- ./ col-md-3 -->  
               
            </div> <!--  ./ form-row -->       
             
               <div class="col-md-10 mb-3">   &nbsp;                        
                  <button class="mt-2 btn btn-primary btn-lg w-100 frame-btn ladda-button" data-style="expand-right" type="submit"> <strong> Save Frame  </strong></button>
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
