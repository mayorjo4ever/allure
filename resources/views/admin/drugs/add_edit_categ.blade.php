@extends('admin.arch_layouts.layout')
@section('content')
<div class="row mt-0 pt-0">
   <div class="col-md-12">
      @include('admin.arch_widgets.alert_messanger')
      @can('create-drugs-category')
      <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
         <div class="card-header">{{$page_info['title']}} </div>
         <div class="card-body">
             <form id="" class="needs-validation" novalidate="" @if(!empty($drugcateg['id'])) action="{{url('admin/add-edit-drug-category/'.$drugcateg['id'])}}" @else action="{{url('admin/add-edit-drug-category')}} " @endif  method="post">@csrf
            <div class="form-row">
               <div class="col-md-4 mb-3">
                  <label for="title">Category Name </label>
                  <input type="text" name="name" id="categ_name" class="form-control"  placeholder="Category Name "  @if(!empty($drugcateg['name'])) value="{{$drugcateg['name']}}" @endif required >
                  <div class="invalid-feedback">
                     Provide Category Name
                  </div>
               </div>
               
               <div class="col-md-3 mb-3">     &nbsp;                        
                  <button class="mt-2 btn btn-primary btn-lg w-100  subject-btn ladda-button" data-style="expand-right" type="submit"> <strong> Save Drug Category  </strong></button>
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
