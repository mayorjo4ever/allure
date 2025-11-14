@extends('admin.arch_layouts.layout')
@section('content')
<div class="row mt-0 pt-0">
        <div class="col-md-12"> 
            
        @include('admin.arch_widgets.alert_messanger')
        @can('view-bill-template')   
        <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">            
            <div class="card-header"> Select result Type </div>
          <form id="bill_template_setup" method="post" action="javascript:void(0)"> @csrf
                <input type="hidden" name="bill_type" value="{{$bill_sample['id']}}" />
                <input type="hidden" name="temp_id" value="{{$temp_id}}" />
            <div class="form-row">
                <div class="col-md-4">
                     <div class="custom-radio custom-control mt-2 ml-3">
                         <input type="radio" id="paramType" value="param_form" @if($bill_sample['template_type']=="param_form") checked="" @endif name="result_temp" class="custom-control-input result_temp mb-3">
                           <label class="custom-control-label" for="paramType">
                       Parameterized Type  ( Inputting values / Figures )</label></div>
                </div>
                <div class="col-md-4 ">                     
                   <div class="custom-radio custom-control mt-2 ml-3">
                       <input type="radio" id="textType" value="text_form"  @if($bill_sample['template_type']=="text_form") checked="" @endif name="result_temp" class="custom-control-input  result_temp mb-3">
                           <label class="custom-control-label" for="textType">
                       Raw Text (Words) Type </label> </div>
                </div>
                <div class="col-md-3 mt-2">
                    <button class="btn btn-primary btn-lg w-50 font-weight-bold start-bill-template-btn ladda-button" data-style="expand-right" > Continue  </button>
                </div>
            </div><!-- ./ form-row-->        
           </form>
        </div><!-- ./ main card -->
        
        @endcan
        
         <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
            <div class="card-header">Fill the Result template form </div>
            <div class="card-body">
                 <span class="ajaxLoader bg-dark h2 ladda-button" data-style="expand-right"></span>
                <div class="body-form">
                    
                </div>
            </div>         

        </div> <!-- ./ main card -->
    </div>
</div>

@endsection 