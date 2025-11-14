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
               @php
                $leftEyeFields = $templateFields->filter(fn($f) => str_contains(strtolower($f->label), 'left'));
                $rightEyeFields = $templateFields->filter(fn($f) => str_contains(strtolower($f->label), 'right'));
                $otherFields = $templateFields->reject(fn($f) =>
                    str_contains(strtolower($f->label), 'left') || str_contains(strtolower($f->label), 'right')
                );
            @endphp
            
            <div class="row">
            {{-- LEFT EYE --}}
            @if($leftEyeFields->isNotEmpty())
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white fw-bold">
                        LEFT EYE (OS)
                    </div>
                    <div class="card-body">
                        @foreach ($leftEyeFields as $field)
                            @include('admin.tests._result_field', ['field' => $field])
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            
            
            {{-- RIGHT EYE --}}
            @if($rightEyeFields->isNotEmpty())
            <div class="col-md-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white fw-bold">
                        RIGHT EYE (OD)
                    </div>
                    <div class="card-body">
                        @foreach ($rightEyeFields as $field)
                            @include('admin.tests._result_field', ['field' => $field])
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
            
            
        {{-- OTHER FIELDS --}}
        @if($otherFields->isNotEmpty())
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-secondary text-white fw-bold">
                GENERAL TEST NOTES
            </div>
            <div class="card-body">
                @foreach ($otherFields as $field)
                    @include('admin.tests._result_field', ['field' => $field])
                @endforeach
            </div>
        </div>
        @endif

        <div class="text-end">
            <button type="submit" class="btn btn-lg btn-primary">Save Result</button>
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
