@extends('admin.arch_layouts.layout')
@section('content')
<div class="row mt-0 pt-0">
   <div class="col-md-12">
      @include('admin.arch_widgets.alert_messanger')
      @can('create-new-lenses')
      
      <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
         <div class="card-header">{{$page_info['title']}} </div>
         <div class="card-body">
             <form id="" class="needs-validation" novalidate="" @if(!empty($lense['id'])) action="{{url('admin/add-edit-lenses/'.$lense['id'])}}" @else action="{{url('admin/add-edit-lenses')}} " @endif  method="post" enctype="multipart/formdata">@csrf
            <div class="form-row">
               <div class="col-md-4 mb-3">
                  <label for="title"  style="font-weight: 600">Lense Name </label>
                  <input type="text" name="name" id="billname" class="form-control"  placeholder="Lense Name "  @if(!empty($lense['name'])) value="{{$lense['name']}}" @endif required >
                  <div class="invalid-feedback">
                     Provide Lense Name
                  </div>
               </div> <!-- ./ col-md-3 -->
               
               <div class="col-md-4 mb-3">
                   <label for="code" style="font-weight: 600">Lense Category </label>
                   <select class="form-control" name="categ" required="" >
                       <option value="">...</option>
                       @foreach($categs as $categ)                       
                       <option value="{{$categ['id']}}" @selected($categ['id']==$lense['categ_id'])  >{{$categ['name']}}</option>                       
                       @endforeach
                   </select>
                  <div class="invalid-feedback">
                     Select Lense Category 
                  </div>
               </div>
               
               <div class="col-md-4 mb-3">
                   <label for="" style="font-weight: 600">Lense Type </label>
                   <select class="form-control" name="type" required="" >
                       <option value="">...</option>
                       @foreach($types as $type)                       
                       <option value="{{$type['id']}}" @selected($type['id']==$lense['type_id'])  >{{$type['name']}}</option>                       
                       @endforeach
                   </select>
                  <div class="invalid-feedback">
                     Select Lense Type 
                  </div>
               </div>
              
            </div> <!-- ./ form-row -->
            
            <div class="form-row">
                <div class="col-md-4 mb-3">
                  <label for="title"  style="font-weight: 600"> Purchase Price </label>
                  <input type="text" name="price1" id="price1" class="form-control"  placeholder="Purchase Price "  @if(!empty($lense['purchase_price'])) value="{{$lense['purchase_price']}}" @endif  onkeyup="numberSeperator($(this))" required >
                  <div class="invalid-feedback">
                     Provide Purchase Price
                  </div>
               </div> <!-- ./ col-md-3 -->       
               
                <div class="col-md-4 mb-3">
                  <label for="title"  style="font-weight: 600"> Selling Price </label>
                  <input type="text" name="price2" id="price2" class="form-control"  placeholder="Selling Price "  @if(!empty($lense['sales_price'])) value="{{$lense['sales_price']}}" @endif  onkeyup="numberSeperator($(this))" required >
                  <div class="invalid-feedback">
                     Provide Selling Price
                  </div>
               </div> <!-- ./ col-md-3 -->   
            </div> <!-- ./ form row -->
            
            <div class="form-row">
                <div class="col-md-4 mb-3">
                  <label for="title"  style="font-weight: 600"> Initial Quantity </label>
                  <input readonly="" type="text" name="init_qty" id="init_qty" class="form-control bg-white"  placeholder="Initial Quantity"  @if(!empty($lense['qty_rem'])) value="{{$lense['qty_rem']}}" @else value="{{0}}" @endif  onkeyup="numberSeperator($(this))" required="" >
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
                        <input onchange="toggleSalesPropts()" type="checkbox" id="is_for_sale" name="is_for_sale" value="1" @if($lense['for_sale']==1) checked @endif checked >
                        <span class="slider round"></span>
                    </label> 
            </div>   <!-- ./ col-md-3 -->               
               
               <div class="col-md-4 mb-3 sales_propts">
                  <label for="title"  style="font-weight: 600"> Manufactured Date </label>
                  <input type="text" name="mfc_date" id="mfc_date" class="form-control bg-white datepicker"  placeholder="Manufactured Date"  @if(!empty($lense['mfc_date'])) value="{{$lense['mfc_date']}}" @else value="" @endif  onkeyup="" >
                  <div class="invalid-feedback">
                     Manufactured Date
                  </div>
               </div> <!-- ./ col-md-3 -->               
               
                <div class="col-md-4 mb-3 sales_propts">
                  <label for="title"  style="font-weight: 600">Expiry Date </label>
                  <input type="text" name="exp_date" id="exp_date" class="form-control  bg-white datepicker" placeholder="Expiry Date"  @if(!empty($lense['exp_date'])) value="{{$lense['exp_date']}}" @else value="" @endif   onkeyup="" >
                  <div class="invalid-feedback">
                     Expiry Date
                  </div>
               </div> <!-- ./ col-md-3 -->  
            </div> <!--  ./ form-row -->       
            
            <div class="form-row">
                
                <div class="col-md-8">
                        <div class="img-fluid">
                            <div class="img-thumbnail border-gray-400"><center>
                                @if(Session::get('current_temp_psp'))
                                <img src="{{asset('images/lenses/temp/'.Session::get('current_temp_psp'))}}" class="student-passport img " height="250" width="500" /> <!--rounded-circle  -->

                                @elseif($lense['pix'] !="")
                                 <img src="{{asset('images/lenses/'.$lense['pix'])}}" class="student-passport img rounded-circle" height="250" width="500" />

                                @else
                                <img src="{{asset('images/user.png')}}" class="student-passport img rounded-circle" height="250" width="500" />
                                @endif
                                </center>
                            </div>
                        </div>         
                        <button type="button" onclick="$('#file').click()" class="btn btn-warning w-100 btn-sm font-weight-700"> Upload Lense Image </button>
                        <input onchange="uploadme()" type="file" name="file" id="file" accept="image/*" class="form-control form-control-file" style="visibility:hidden; display:none; " />
                        <?php ## print_r(Session::get('temp_psp')); ?>
                    </div>
                <div class="col-md-2 ml-2">
                    <label>Width:</label>
                    <input type="text" name="pix_height" id="pix_height" class="form-control  bg-white" placeholder="Width : 400"  @if(!empty($lense['pix_width'])) value="{{$lense['pix_width']}}" @else value="" @endif   onkeyup="" >  
                    <label class="mt-3">Height:</label>
                    <input type="text" name="pix_height" id="pix_height" class="form-control  bg-white" placeholder="Height : 200"  @if(!empty($lense['pix_height'])) value="{{$lense['pix_height']}}" @else value="" @endif   onkeyup="" >  
                </div>
                
                <div class="col-md-8 mt-2 font-weight-600"> <div class="picture_loader text-center"></div> </div>
          
            </div><!--  ./ form-row --> 
            
                    
               
               <div class="col-md-10 mb-3">   &nbsp;                        
                  <button class="mt-2 btn btn-primary btn-lg w-100  drug-btn ladda-button" data-style="expand-right" type="submit"> <strong> Save Lense  </strong></button>
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
