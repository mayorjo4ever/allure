@extends('admin.arch_layouts.layout')
@section('content')
<div class="row mt-0 pt-0">
   <div class="col-md-12">
      @include('admin.arch_widgets.alert_messanger')
      
      <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
         <div class="card-header">{{$page_info['title']}} </div>
         <div class="card-body">
             <form id="" class="needs-validation" novalidate="" enctype="multipart/form-data" action="{{url('admin/customers/read-excel')}}" method="post">
               @csrf
               <div class="form-row">
                  <div class="col-md-3 mb-3">
                     <label for="code">Browse Customers ( Excel file) </label>
                     <input type="file" name="file" class="form-control" required >
                     <div class="invalid-feedback">
                        Please Locate the excel file 
                     </div>
                  </div>
                  <div class="col-md-3 mb-3">     &nbsp;                        
                     <button class="mt-2 btn btn-primary btn-lg w-100  subject-btn ladda-button" data-style="expand-right" type="submit"> <strong> Upload Customers </strong></button>
                  </div>
                  <div class="col-md-3 mb-3">     &nbsp;                        
                      <a href="{{asset('resources/customer-imports.xlsx')}}" class="mt-2 btn btn-success btn-lg w-100 text-white subject-btn ladda-button" > <strong> Download Sample &nbsp; <i class="pe-7s-cloud-download"></i> </strong></a>
                  </div>
               </div>
            </form>
         </div>
         <!-- ./ card-body -->              
      </div>
   </div>
</div>
@endsection
