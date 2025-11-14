<form id="param_temp_form" class="needs-validation"  novalidate="" method="post" action="javascript:void(0)"> @csrf
    <input type="hidden" name="bill_type_id" value="{{$bill_type_id}}"/>
    <input type="hidden" name="temp_id" value="{{$editTemp['id']}}"/>
    <div class="row">
    <div class="col-lg-12">
        <div class="form-row">
            <div class="col-md-4">
                <label class="font-weight-600">Result Name </label>
                <input type="text" name="name" value="{{$editTemp['name']}}" class="form-control" placeholder="Result Name " required="" />                 
                <span class="temp_name_error error-text text-danger font-weight-600"></span> 
                    
                 <label class="font-weight-600 mt-3">This Template Belongs To </label>
                  <div>
                    <div class="custom-radio custom-control custom-control-inline">
                        <input type="radio" value="infant" @if($editTemp['age_range']=="infant") checked="" @endif name="towhom" id="infant_temp" class="custom-control-input">
                        <label class="custom-control-label font-weight-600" for="infant_temp">Infants</label>
                    </div> 
                    <div class="custom-radio custom-control custom-control-inline">
                        <input type="radio" value="youth"  @if($editTemp['age_range']=="youth") checked="" @endif  name="towhom" id="child_temp" class="custom-control-input">
                        <label class="custom-control-label font-weight-600" for="child_temp">Youths</label>
                    </div> 
                    <div class="custom-radio custom-control custom-control-inline">
                        <input type="radio" name="towhom" value="adult"  @if($editTemp['age_range']=="adult") checked="" @endif   id="adult_temp" class="custom-control-input">
                        <label class="custom-control-label font-weight-600" for="adult_temp">Adults</label>
                    </div>
                </div>
                 <span class="temp_towhom_error error-text text-danger font-weight-600"></span> 
            </div> <!--./ col-md-3 -->
            
            <div class="col-md-4 mb-3">
                <div>
                  <div class="custom-checkbox custom-control custom-control-inline  mb-1">
                      <input name="has_unit" value="yes" type="checkbox" @if($editTemp['has_unit']==1) checked="" @endif id="has_unit" class="custom-control-input">
                          <label class="custom-control-label font-weight-600" for="has_unit">Has Unit </label>
                  </div>
                 </div>
                <textarea rows="1" id="unit" name="unit" class="form-control-plaintext" style="font-size: 16px; width:auto">{{$editTemp['unit']}}</textarea>
                 <span class="temp_unit_error error-text text-danger font-weight-600"></span> 
            </div><!--./ col-md-4 -->
            
            <div class="col-md-4 mb-3">
                <div>
                  <div class="custom-checkbox custom-control custom-control-inline  mb-1">
                      <input name="has_ref" value="yes" type="checkbox" @if($editTemp['has_ref_val']==1) checked="" @endif id="has_ref" class="custom-control-input">
                          <label class="custom-control-label font-weight-600" for="has_ref">Has Reference / Range value </label>
                  </div>
                 </div>
                <input type="text" name="ref_value" id="ref_value" value="{{$editTemp['ref_val']}}" class="form-control mt-1" placeholder="Reference Value" >
                <span class="mb-4 temp_ref_value_error error-text text-danger font-weight-600"></span> 
                <label class="mt-2">&nbsp;</label>
                 <button name="" style="font-weight: 700" type="submit" class="btn btn-primary btn-lg ladda-button w-100 param-template-submit-btn" data-style="expand-right"> {{ empty($editTemp['id'])?"Create New Template" : "Update Template # " .$editTemp['id'] }} </button> 
            </div>
                         
        </div><!--./ form-row -->
    </div>
</div>
    <hr/>
</form>

@include('admin.billings.param_template_list_ajax')