@extends('admin.arch_layouts.layout')
@section('content')
<div class="row mt-0 pt-0">
   <div class="col-md-12">
      @include('admin.arch_widgets.alert_messanger')
      @can('create-new-lenses')
      
      <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
         <div class="card-header">{{$page_info['title']}} </div>
         <div class="card-body">
             <form id="" class="needs-validation" novalidate="" @if(!empty($template['id'])) action="{{url('admin/add-edit-test/'.$template['id'])}}" @else action="{{url('admin/add-edit-test')}} " @endif  method="post" enctype="multipart/formdata">@csrf
            <div class="form-row">
               <div class="col-md-4 mb-3">
                  <label for="title"  style="font-weight: 600">Test Name </label>
                  <input type="text" name="name" id="testname" class="form-control form-control-lg"  placeholder="Test Name "  @if(!empty($template['name'])) value="{{$template['name']}}" @endif required >
                  <div class="invalid-feedback">
                     Provide Test Name
                  </div>
               </div> <!-- ./ col-md-3 -->
                     
                <div class="col-md-4 mb-3">
                  <label for="price"  style="font-weight: 600"> Bill Price </label>
                  <input type="text" name="price" id="price" class="form-control form-control-lg"  placeholder="Bill Price "  @if(!empty($template['price'])) value="{{$template['price']}}" @endif  onkeyup="numberSeperator($(this))" required >
                  <div class="invalid-feedback">
                     Provide Bill Price
                  </div>
               </div> <!-- ./ col-md-3 -->       
              
                 
               <div class="col-md-3 mb-3" style="display: none; "> 
                <label class="mt-2" style="font-weight: 600"> Requires Image Upload ? </label> <br/>
                <label class="switch">  
                    <input type="checkbox" id="requires_image" name="requires_image" value="1" @if($template['requires_image']==1) checked @endif >
                    <span class="slider round"></span>
                </label> 
            </div>   <!-- ./ col-md-3 -->              
                
            </div> <!--  ./ form-row -->       
            
            <div class="card p-4 mt-3">
                <div class="d-flex justify-content-between mb-3">
                    <h5 class="mb-3 font-weight-bold">Test Fields</h5>
                    <button type="button" id="addFieldBtn" class="btn btn-success btn-lg p-3">
                        <i class="fa fa-plus"></i> Add Field
                    </button>
                </div>

                <div id="fieldsContainer">
                    {{-- Existing fields will be loaded here if editing --}}                    
                        @foreach ($template->fields as $i => $field)
                            <div class="field-row d-flex align-items-center mb-2">
                                 <div class="col-md-4">
                                <input type="text" name="fields[{{ $i }}][label]" class="form-control me-2" 
                                       value="{{ $field->label }}" placeholder="Field Label" required>
                                 </div>  <div class="col-md-4">
                                <select name="fields[{{ $i }}][type]" class="form-control form-control-lg me-1 field-type">
                                    <option value="text" {{ $field->type == 'text' ? 'selected' : '' }}>Text</option>
                                    <option value="number" {{ $field->type == 'number' ? 'selected' : '' }}>Number</option>
                                    <option value="textarea" {{ $field->type == 'textarea' ? 'selected' : '' }}>Textarea</option>
                                    <option value="select" {{ $field->type == 'select' ? 'selected' : '' }}>Select (Dropdown)</option>
                                    <option value="file" {{ $field->type == 'file' ? 'selected' : '' }}>File (Image)</option>
                                </select>
                                 </div>
                                <input type="text" name="fields[{{ $i }}][options]" 
                                       class="form-control form-control-lg w-25 me-2 options-input {{ $field->type != 'select' ? 'd-none' : '' }}" 
                                       value="{{ $field->options ? implode(',', json_decode($field->options, true)) : '' }}" 
                                       placeholder="Options (comma-separated)">

                                <button type="button" class="btn btn-danger btn-md removeFieldBtn">X</button>
                            </div>
                        @endforeach
                  
                </div>
            </div>

            
            
               <div class="col-md-12 mb-3 mt-2">   &nbsp;  
                  <button class=" btn p-3 btn-primary btn-lg w-100 test-btn ladda-button" data-style="expand-right" type="submit"> <strong> Save Test   </strong></button>
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


@push('scripts')
<script>$(document).ready(function() {

    // Add new field dynamically
    $('#addFieldBtn').on('click', function() {
        const index = $('.field-row').length; // get current number of fields
        const newField = `
            <div class="field-row d-flex align-items-center mb-2">
               <div class="col-md-4">
                <input type="text" name="fields[${index}][label]" class="form-control form-control-lg me-2" placeholder="Field Label" required>
               </div> <div class="col-md-4">
                <select name="fields[${index}][type]" class="form-control form-control-lg me-2 field-type">
                    <option value="text">Text</option>
                    <option value="number">Number</option>
                    <option value="textarea">Textarea</option>
                    <option value="select">Select (Dropdown)</option>
                    <option value="file">File (Image)</option>
                </select>
                </div>
                <input type="text" name="fields[${index}][options]" class="form-control form-control-lg w-25 me-2 options-input d-none" placeholder="Options (comma-separated)">

                <button type="button" class="btn btn-danger btn-lg removeFieldBtn">X</button>
            </div>
        `;

        $('#fieldsContainer').append(newField);
    });

    // Toggle options input when type is "select"
    $(document).on('change', '.field-type', function() {
        const optionsInput = $(this).closest('.field-row').find('.options-input');
        if ($(this).val() === 'select') {
            optionsInput.removeClass('d-none');
        } else {
            optionsInput.addClass('d-none');
        }
    });

    // Remove field row
    $(document).on('click', '.removeFieldBtn', function() {
        $(this).closest('.field-row').remove();
    });
});

</script>
@endpush
@endsection
