@extends('admin.arch_layouts.layout')
@section('content')
@push('styles')
<style>
    .font-20 { font-size:20px; }
</style>
@endpush

<div class="row mt-0 pt-0">
        <div class="col-md-9"> 
              @include('admin.arch_widgets.alert_messanger')
        <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
            <div class="card-header">{{$page_info['title']}} </div>
            <div class="card-body">
                <form id="" @if(!empty($questionnaire->id)) action="{{url('admin/add-edit-questionnaire/'.$questionnaire->id)}}"  @else action="{{url('admin/add-edit-questionnaire')}}" @endif method="post">@csrf
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label class="h5">Question</label>
                                <input type="text" name="question" class="form-control p-4" style="font-size:1.2rem;" 
                                       value="{{ old('question', $questionnaire->question ?? '') }}" required>
                            <div class="invalid-feedback">
                               Provide Question
                            </div>
                         </div>
                        <div class="col-md-12 mb-3">
                             <label class="h5" for="title"> Question Type  </label>
                            <select name="type" class="form-control p-2" style="font-size:1.2rem; height: auto" id="typeSelect" required>
                                <option value="" selected >... Select ... </option>
                                <option value="text" {{ (old('type', $questionnaire->type ?? '') == 'text') ? 'selected' : '' }}>Text</option>
                                <option value="boolean" {{ (old('type', $questionnaire->type ?? '') == 'boolean') ? 'selected' : '' }}>Yes/No</option>
                                <option value="choice" {{ (old('type', $questionnaire->type ?? '') == 'choice') ? 'selected' : '' }}>Multiple Choice</option>
                            </select>
                            <div class="invalid-feedback">
                               Provide Choice Answer    
                            </div>
                         </div>
                        
                        <div class="col-md-12 mb-3">
                            <div class="form-group mb-3" id="optionsField" 
                                style="display: {{ (old('type', $questionnaire->type ?? '') == 'choice') ? 'block' : 'none' }};">
                                <label class="h5"> Options (comma separated)</label>
                               <input type="text" 
                                    name="options" 
                                    class="form-control p-4" 
                                    style="font-size:1.2rem;" 
                                    value="{{ old('options') ? implode(',', (array) old('options')) : (isset($questionnaire->options) ? implode(',', json_decode($questionnaire->options, true)) : '') }}">

                            </div>
                         <div class="invalid-feedback">
                               Provide Option Fields
                            </div>
                         </div>
                        
                         <div class="col-md-12 mb-3" id="defaultAnswerField"
                            style="display: {{ (old('type', $questionnaire->type ?? '') == 'text') ? 'block' : 'none' }};">
                            <label class="h5">Default Answer</label>
                            <input type="text" name="default_answer" class="form-control p-4" style="font-size:1.2rem;" 
                                   value="{{ old('default_answer', $questionnaire->default_answer ?? '') }}">
                        </div>
                         <div class="col-md-12 mb-3">     &nbsp;                        
                           <button class="mt-2 btn btn-primary btn-lg w-100  subject-btn ladda-button" data-style="expand-right" type="submit"> <strong> Upload Question </strong></button>
                         </div>
                    </div>
               </form>
            </div>  <!-- ./ card-body -->              
        </div>
    </div>
</div>

@push('scripts')
    <script>
document.getElementById('typeSelect').addEventListener('change', function() {
    let optionsField = document.getElementById('optionsField');
    let defaultAnswerField = document.getElementById('defaultAnswerField');

    if(this.value === 'choice') {
        optionsField.style.display = 'block';
        defaultAnswerField.style.display = 'none';
    } else if(this.value === 'text') {
        optionsField.style.display = 'none';
        defaultAnswerField.style.display = 'block';
    } else {
        optionsField.style.display = 'none';
        defaultAnswerField.style.display = 'none';
    }
});
</script>
@endpush

@endsection 