@extends('admin.arch_layouts.layout')
@section('content')
<div class="row mt-0 pt-0">
   <div class="col-md-12">
      @include('admin.arch_widgets.alert_messanger')
      @can('create-new-drugs')
      
      <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
         <div class="card-header">{{$page_info['title']}} </div>
         <div class="card-body">
             <form id="" class="needs-validation" novalidate="" @if(!empty($drug['id'])) action="{{url('admin/add-edit-drugs/'.$drug['id'])}}" @else action="{{url('admin/add-edit-drugs')}} " @endif  method="post">@csrf
            <div class="form-row">
               <div class="col-md-4 mb-3">
                  <label for="title"  style="font-weight: 600">Drug Name </label>
                  <input type="text" name="name" id="billname" class="form-control"  placeholder="Drug Name "  @if(!empty($drug['name'])) value="{{$drug['name']}}" @endif required >
                  <div class="invalid-feedback">
                     Provide Drug Name
                  </div>
               </div> <!-- ./ col-md-3 -->
               
               <div class="col-md-4 mb-3">
                   <label for="code" style="font-weight: 600">Drug Category </label>
                   <select class="form-control" name="categ" required="" >
                       <option value="">...</option>
                       @foreach($drugcategs as $categ)                       
                       <option value="{{$categ['id']}}" @selected($categ['id']==$drug['categ_id'])  >{{$categ['name']}}</option>                       
                       @endforeach
                   </select>
                  <div class="invalid-feedback">
                     Select Drug Category 
                  </div>
               </div>
              
            </div> <!-- ./ form-row -->
            
            <div class="form-row">
                <div class="col-md-4 mb-3">
                  <label for="title"  style="font-weight: 600"> Purchase Price </label>
                  <input type="text" name="price1" id="price1" class="form-control"  placeholder="Purchase Price "  @if(!empty($drug['purchase_price'])) value="{{$drug['purchase_price']}}" @endif  onkeyup="numberSeperator($(this))" required >
                  <div class="invalid-feedback">
                     Provide Purchase Price
                  </div>
               </div> <!-- ./ col-md-3 -->       
               
                <div class="col-md-4 mb-3">
                  <label for="title"  style="font-weight: 600"> Selling Price </label>
                  <input type="text" name="price2" id="price2" class="form-control"  placeholder="Selling Price "  @if(!empty($drug['sales_price'])) value="{{$drug['sales_price']}}" @endif  onkeyup="numberSeperator($(this))" required >
                  <div class="invalid-feedback">
                     Provide Selling Price
                  </div>
               </div> <!-- ./ col-md-3 -->   
            </div> <!-- ./ form row -->
            
            <div class="form-row">
                <div class="col-md-4 mb-3">
                  <label for="title"  style="font-weight: 600"> Initial Quantity </label>
                  <input readonly="" type="text" name="init_qty" id="init_qty" class="form-control bg-white"  placeholder="Initial Quantity"  @if(!empty($drug['qty_rem'])) value="{{$drug['qty_rem']}}" @else value="{{0}}" @endif  onkeyup="numberSeperator($(this))" required="" >
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
               
            <div class="col-md-3 mb-3"> 
                    <label class="mt-2" style="font-weight: 600"> Is Having Expiry Date </label> <br/>
                    <label class="switch">  
                        <input onchange="toggleSalesPropts()" type="checkbox" id="is_for_sale" name="is_for_sale" value="1" @if($drug['for_sale']==1) checked @endif checked >
                        <span class="slider round"></span>
                    </label> 
            </div>   <!-- ./ col-md-3 -->               
               
               <div class="col-md-4 mb-3 sales_propts">
                  <label for="title"  style="font-weight: 600"> Manufactured Date </label>
                  <input type="text" name="mfc_date" id="mfc_date" class="form-control bg-white datepicker"  placeholder="Manufactured Date"  @if(!empty($drug['mfc_date'])) value="{{$drug['mfc_date']}}" @else value="" @endif  onkeyup="" >
                  <div class="invalid-feedback">
                     Manufactured Date
                  </div>
               </div> <!-- ./ col-md-3 -->               
               
                <div class="col-md-4 mb-3 sales_propts">
                  <label for="title"  style="font-weight: 600">Expiry Date </label>
                  <input type="text" name="exp_date" id="exp_date" class="form-control  bg-white datepicker" placeholder="Expiry Date"  @if(!empty($drug['exp_date'])) value="{{$drug['exp_date']}}" @else value="" @endif   onkeyup="" >
                  <div class="invalid-feedback">
                     Expiry Date
                  </div>
               </div> <!-- ./ col-md-3 -->               
               
               
               <div class="col-md-10 mb-3">   &nbsp;                        
                  <button class="mt-2 btn btn-primary btn-lg w-100  drug-btn ladda-button" data-style="expand-right" type="submit"> <strong> Save Drug  </strong></button>
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
