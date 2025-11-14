<form method="post" id="text_temp_form" action="javascript:void(0)"> @csrf
 <input type="hidden" name="bill_type_id" value="{{$bill_type_id}}"/>  
 <input type="hidden" name="temp_id" value="{{$editTemp['id']}}"/>
    
<div class="row">
    <div class="col-lg-10 offset-1">
        <div class="form-row">   
            <div clas="col-lg-12">
              <textarea rows="1" id="result_text" name="result_text" class=" form-control"  style="font-size: 16px; width: auto; max-width: 780px">{{$editTemp['raw_text_val']}}</textarea> 
              <span class="temp_result_text_error error-text text-danger font-weight-600"></span> 
            </div>
            <div class="col-md-6 mt-3">
               <button name="" style="font-weight: 700" type="submit" class="btn btn-primary btn-lg ladda-button w-100 text-template-submit-btn" data-style="expand-right"> {{ empty($editTemp['id'])?"Create New Template" : "Update Template # " .$editTemp['id'] }} </button> 
            </div>
        </div>
    </div>
</div>
</form>
<hr class="pt-3 mb-3"/>

@include('admin.billings.text_template_list_ajax')