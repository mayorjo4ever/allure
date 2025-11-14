@extends('admin.arch_layouts.layout')
@section('content')
<div class="row mt-0 pt-0">
   <div class="col-md-12">
      @include('admin.arch_widgets.alert_messanger')
     
      
      <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
         <div class="card-header">{{$page_info['title']}} </div>
         <div class="card-body">
               <form action="{{ url('admin/tests/investigation-result/'.$investigation->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        @foreach($investigation->template->fields as $field)
                            @include('admin.tests.result_fields', [
                                'field' => $field,  
                                'existing' => $resultsByField[$field->id] ?? null])
                        @endforeach
                    </div> 
                    <button class="btn btn-primary btn-lg w-100 p-3 mt-3">Save Result</button>
                </form>
            
         <!-- ./ card-body -->              
      </div>
      
   </div>
     
      
   </div>
</div>
@endsection
