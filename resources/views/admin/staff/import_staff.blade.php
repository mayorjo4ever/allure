@extends('admin.arch_layouts.layout')
@section('content')
<div class="row mt-0 pt-0">
        <div class="col-md-12"> 
              @include('admin.arch_widgets.alert_messanger')
              @can('import-admin')
        <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
            <div class="card-header">{{$page_info['title']}} </div>
            <div class="card-body">
               <form class="needs-validation" novalidate  id="subjectForm" enctype="multipart/form-data" action="{{url('admin/staff/read-excel')}}" method="post">@csrf
                    <div class="form-row">                       
                        
                        <div class="col-md-3 mb-3">
                            <label for="code">Browse Staff ( Excel file) </label>
                            <input type="file" name="file" class="form-control" required >
                            <div class="invalid-feedback">
                               Please Locate the file 
                            </div>
                         </div>
                         <div class="col-md-3 mb-3">     &nbsp;                        
                           <button class="mt-2 btn btn-primary btn-lg w-100  import-staff-btn ladda-button" data-style="expand-right" type="submit"> <strong> Upload Staff </strong></button>
                         </div>
                    </div>
               </form>
            </div>  <!-- ./ card-body -->              
        </div>
        @else 
            <x-un-authorized-page/>
        @endcan
    </div>
</div>

@endsection 