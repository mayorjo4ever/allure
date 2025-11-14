<?php 
    use Carbon\Carbon;
    use App\Models\Country; 
    $countries = Country::countries();
    // dd($countries); 
?>
<p class="card-title pt-3 mt-3">Next of Kin  Info &nbsp; <button type="button" onclick="toggleShowNok()" class="btn btn-info pull-right">Show NOK </button> </p> <hr> 
<div class="form-row mt-2"> 
       
    <div class="col-md-3 mb-3 nok">
      <label for="title"  class="font-weight-600"> Next of Kin | Name </label>
      <input type="text" @if(!empty($student['nok_name'])) value="{{$student['nok_name']}}" @endif  name="nok_name" id="user-nok-name" class="form-control" placeholder="Name of Next of Kin" >
      <div class="invalid-feedback">
         Provide Name of Next of Kin
      </div>
   </div>
   <!-- col-md-3 -->
   
    <div class="col-md-3 mb-3 nok">
      <label for="title"  class="font-weight-600">Next of Kin | Phone Number </label>
      <input type="text" @if(!empty($student['nok_phone'])) value="{{$student['nok_phone']}}" @endif  name="nok_phone" id="user-nok-phone" class="form-control" placeholder="Next of Kin Phone" >
      <div class="invalid-feedback">
         Provide Next of Kin Phone
      </div>
   </div>
   <!-- col-md-3 -->
   
   <div class="col-md-3 mb-3 nok">
      <label for="title"  class="font-weight-600">Next of Kin | Address </label>
      <input type="text" @if(!empty($student['nok_address'])) value="{{$student['nok_address']}}" @endif  name="nok_address" id="user-nok-address" class="form-control" placeholder="Next of Kin Address" >
      <div class="invalid-feedback">
         Provide Next of Kin Address
      </div>
   </div>
   <!-- col-md-3 -->
       
     <div class="col-md-3 mb-3 nok">
     <?php $relations = ['husband','wife','first_child','second_child','third_child','fourth_child','fifth_child','sixth_child','friend','relative','others']; ?>
      <label for="nok_rel"  class="font-weight-600">Next of Kin | Relationship  </label>
      <input type="text" @if(!empty($student['nok_relationship'])) value="{{$student['nok_relationship']}}" @endif  name="nok_relationship" id="user-nok-relationship" class="form-control" placeholder="Next of Kin Relationship" >
      <div class="invalid-feedback">
         Select Next of Kin Relationship
      </div>
     </div> <!-- col-md-3 -->  
     
     
   <div class="col-md-12 mb-3"> &nbsp;
      <button class="mt-2 btn btn-primary btn-lg w-100  new-student-btn ladda-button" data-style="expand-right" type="submit"> <strong> {{ empty($student['id']) ? " Create New Customer ":"Update Customer " }} </strong></button>
   </div>
     
     
</div>