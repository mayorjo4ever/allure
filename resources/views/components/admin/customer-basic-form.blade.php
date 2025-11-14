<?php 
    use Carbon\Carbon;
    use App\Models\Country; 
    $countries = Country::countries();
    // dd($countries);     
?>
<form method="post" id="customer_profile"> @csrf
<div class="form-row mt-2">    
    <div class="col-sm-6 mb-3">
      <label for="enrole_no"  class="font-weight-600">Enrole No..for HMO </label>
       <input type="text"  value="" name="enrole_no" id="enrole_no" class="form-control" placeholder="Enrole No.. for HMO" >    
      <div class="invalid-feedback">
         Provide Enrole No.
      </div>
     </div> <!-- col-sm-6 --> 
    
     <div class="col-sm-6 mb-3">
      <label for="account_type"  class="font-weight-600">HMO </label>
       <input type="text"  value="" name="hmo" id="hmo" class="form-control" placeholder="HMO" >    
      <div class="invalid-feedback">
         Provide HMO.
      </div>
     </div> <!-- col-sm-6 --> 
     
    <div class="col-sm-6 mb-3">
      <label for="title"  class="font-weight-600">Registration / Hospital No.  </label>
      <input type="hidden"  value="" name="user_id" id="user_id" class="user_id form-control" placeholder="User ID" >
      <input type="text"  value="" name="regno" id="user-regno" class="form-control" placeholder="Hospital No." required >
      <div class="invalid-feedback">
         Provide Your Identity No.
      </div>
     </div><!-- comment -->
     
   <div class="col-sm-6 mb-3">
      <label for="title"  class="font-weight-600">Surname  </label>
      <input type="text" name="surname" id="user-surname" class="form-control" placeholder="Surname" required >
      <div class="invalid-feedback">
         Provide Your Surname
      </div>
   </div>
   <!-- col-sm-6 -->
   <div class="col-sm-6 mb-3">
      <label for="title"  class="font-weight-600">First Name </label>
      <input type="text"  value=""  name="firstname" id="user-firstname" class="form-control" placeholder="Firstname" required >
      <div class="invalid-feedback">
         Provide First Name
      </div>
   </div>
   <!-- col-sm-6 -->
   <div class="col-sm-6 mb-3">
      <label for="title"  class="font-weight-600">Other Name </label>
      <input type="text" value="" name="othername" id="user-othername" class="form-control" placeholder="Other name" >
      <div class="invalid-feedback">
         Provide Other Name
      </div>
   </div>
   <!-- col-sm-6 -->
   <div class="col-sm-6 mb-3">
       <label for="title" class="font-weight-600">Gender </label>
      <div>
        <div class="custom-radio custom-control custom-control-inline">
            <input type="radio" value="male" name="sex" id="male_sex" class="custom-control-input">
            <label class="custom-control-label font-weight-600" for="male_sex">Male</label>
        </div>
        <div class="custom-radio custom-control custom-control-inline">
            <input type="radio" value="female"  name="sex" id="female_sex" class="custom-control-input">
            <label class="custom-control-label font-weight-600" for="female_sex">Female</label>
        </div>

    </div>
   </div>
   <!-- col-sm-6 -->
   <div class="col-sm-6 mb-3">
      <label for="title"  class="font-weight-600"> Age &nbsp;/&nbsp; Date of Birth&nbsp;  </label>
      <input  value="  value=""  type="text" name="dob" id="dob" class="form-control datetimepicker bg-white" placeholder="Date of Birth" required >
       {{--   value="2013-04-22 10:21:17" --}}
      <div class="invalid-feedback"> 
         Provide Date of birth
      </div>   <button data-toggle="modal" data-target=".age_calc" type="button" class="btn btn-lg btn-light mt-1"> <i class="fa fa-calculator"></i> </button>
   </div>
   <!-- col-sm-6 -->
   <div class="col-sm-6 mb-3">
      <label for="title"  class="font-weight-600">Mobile Phone </label>
      <input type="text" value=""   name="phone" id="user-phone" class="form-control" placeholder="Phone No. " required="" >
      <div class="invalid-feedback">
         Provide Mobile Phone
      </div>
   </div>
   <!-- col-sm-6 -->

   <div class="col-sm-6 mb-3">
      <label for="title"  class="font-weight-600">Email </label>
      <input type="text" value=""  name="email" id="user-email" class="form-control" placeholder="Email. " >
      <div class="invalid-feedback">
         Provide Email
      </div>
   </div>
   <!-- col-sm-6 -->
   
    <div class="col-sm-6 mb-3">
        <label for="title"  class="font-weight-600">Your Occupation </label>
        <input type="text value="" name="occupation" id="user-occupation" class="form-control" placeholder="Occupation" >
        <div class="invalid-feedback">
              Provide Your Occupation
      </div>
   </div>
   
     
      <div class="col-sm-6 mb-3 for_family_position family">
        <?php $positions = ['husband','wife','first_child','second_child','third_child','fourth_child','fifth_child','sixth_child','friend','relative','others']; ?>
         <label for="nok_rel"  class="font-weight-600">Family Position  </label>
         <select class="form-control text-capitalize" name="family_position"> 
             <option value="">...</option>
             @foreach($positions as $position)
              <option value=""> {{ str_replace('_',' ',$position)}} </option>
             @endforeach
         </select>
         <div class="invalid-feedback">
            Select Family Position
         </div>
     </div> <!-- col-sm-6 -->  
     
     <div class="col-sm-6 family">
         <label class="mt-2" style="font-weight: 600"> I'm head of the family </label> <br/>
            <label class="switch">  
                <input type="checkbox"  name="family_host" value="1" checked >
                <span class="slider round"></span>
            </label> 
     </div>
</div>

<div class="form-row mt-2">
 
  <div class="col-sm-6 mb-3 nok">
      <label for="title"  class="font-weight-600"> Next of Kin | Name </label>
      <input type="text" value=""  name="nok_name" id="user-nok-name" class="form-control" placeholder="Name of Next of Kin" >
      <div class="invalid-feedback">
         Provide Name of Next of Kin
      </div>
   </div>
   <!-- col-sm-6 -->
   
    <div class="col-sm-6 mb-3 nok">
      <label for="title"  class="font-weight-600">Next of Kin | Phone Number </label>
      <input type="text" value="" name="nok_phone" id="user-nok-phone" class="form-control" placeholder="Next of Kin Phone" >
      <div class="invalid-feedback">
         Provide Next of Kin Phone
      </div>
   </div>
   <!-- col-sm-6 -->
   
   <div class="col-sm-6 mb-3 nok">
      <label for="title"  class="font-weight-600">Next of Kin | Address </label>
      <input type="text" value="" name="nok_address" id="user-nok-address" class="form-control" placeholder="Next of Kin Address" >
      <div class="invalid-feedback">
         Provide Next of Kin Address
      </div>
   </div>
   <!-- col-sm-6 -->
       
     <div class="col-sm-6 mb-3 nok">
     <?php $relations = ['husband','wife','first_child','second_child','third_child','fourth_child','fifth_child','sixth_child','friend','relative','others']; ?>
      <label for="nok_rel"  class="font-weight-600">Next of Kin | Relationship  </label>
      <input type="text" value="" name="nok_relationship" id="user-nok-relationship" class="form-control" placeholder="Next of Kin Relationship" >
      <div class="invalid-feedback">
         Select Next of Kin Relationship
      </div>
     </div> <!-- col-sm-6 -->  
     
</div>
<!-- form-row-->
 
    
<div class="form-row mt-2">
     <div class="col-sm-6 mb-3 address">
          <label for="title">Country </label>
          <select name="country" id="country" onchange="load_student_state_of_origin()" class="form-control" required="" >
              <option value="">--</option>
              @foreach($countries as $country)
              <option value="{{$country->id}}" @selected($country->id==161) >{{$country->name}}</option>
              @endforeach
          </select>
          <div class="invalid-feedback">
             Select Country
          </div>
       </div> <!-- col-sm-6 -->
       
       <div class="col-sm-6 mb-3 address">
           <div class="state_loader"></div>
       </div> <!-- col-sm-6 -->
       
       <div class="col-sm-6 mb-3 address">
           <div class="city_loader"></div>
       </div> <!-- col-sm-6 -->    
       
        <div class="col-sm-6 mb-3 address">
            <label for="title"  class="font-weight-600">Your Residence Address </label>
            <input type="text" value=""  name="residence" id="user-residence" class="form-control" placeholder="Your Residence Address" >
            <div class="invalid-feedback">
               Provide Your Residence Address
            </div>
   </div>
   <!-- col-sm-6 -->        
   
    <div class="col-sm-6 mb-3 address">
      <label for="title"  class="font-weight-600">Name and Address of Employee </label>
      <input type="text" value=""  name="employee_address" id="user-employee-address" class="form-control" placeholder="Name and Address of Employee " >
      <div class="invalid-feedback">
         Provide Name and Address of Employee 
      </div>
   </div>
   <!-- col-sm-6 --> 
            
   <div class="col-md-12 mb-3"> &nbsp;
       <button onclick="submit_updated_customer_profile()" class="mt-2 btn btn-primary btn-lg w-100  submit-updated-customer-profile-btn ladda-button" data-style="expand-right" type="submit"> <strong> {{ "Update Customer Profile " }} </strong></button>
   </div>
</div>
</form>