<div class="form-row mt-2">
    
    <div class="col-md-3 mb-3">
      <label for="account_type"  class="font-weight-600">Account Type  </label>
      <select name="account_type" id="account_type" class="form-control" required="" >
          <option value="">..Select Account Type..</option>
          <option value="outsider" @selected($student['account_type']=='outsider') >Outsider Account (External Client) </option>
          <option value="personal" @selected($student['account_type']=='personal') >Personal Account </option>
          <option value="family" @selected($student['account_type']=='family')>Family Account </option>
          <option value="corporate" @selected($student['account_type']=='corporate')>Corporate Account </option>
      </select>
      <div class="invalid-feedback">
         Select Account Type
      </div>
     </div> <!-- col-md-3 --> 
    
    <div class="col-md-3 mb-3">
      <label for="title"  class="font-weight-600">Registration / Hospital No.  </label>
      <input type="hidden" @if(!empty($student['regno'])) value="{{$student['regno']}}" @endif  name="init-regno" id="init-user-regno" class="form-control" placeholder="Hospital No." required >
      <input type="text" @if(!empty($student['regno'])) value="{{$student['regno']}}" @endif  name="regno" id="user-regno" class="form-control" placeholder="Hospital No." required >
      <div class="invalid-feedback">
         Provide Your Identity No.
      </div>
     </div><!-- comment -->
   <div class="col-md-3 mb-3">
      <label for="title"  class="font-weight-600">Surname  </label>
      <input type="text" @if(!empty($student['surname'])) value="{{$student['surname']}}" @endif  name="surname" id="user-surname" class="form-control" placeholder="Surname" required >
      <div class="invalid-feedback">
         Provide Your Surname
      </div>
   </div>
   <!-- col-md-3 -->
   <div class="col-md-3 mb-3">
      <label for="title"  class="font-weight-600">First Name </label>
      <input type="text" @if(!empty($student['firstname'])) value="{{$student['firstname']}}" @endif  name="firstname" id="user-firstname" class="form-control" placeholder="Firstname" required >
      <div class="invalid-feedback">
         Provide First Name
      </div>
   </div>
   <!-- col-md-3 -->
   <div class="col-md-3 mb-3">
      <label for="title"  class="font-weight-600">Other Name </label>
      <input type="text" @if(!empty($student['othername'])) value="{{$student['othername']}}" @endif  name="othername" id="user-othername" class="form-control" placeholder="Other name" >
      <div class="invalid-feedback">
         Provide Other Name
      </div>
   </div>
   <!-- col-md-3 -->
   <div class="col-md-3 mb-3">
       <label for="title" class="font-weight-600">Gender </label>
      <div>
        <div class="custom-radio custom-control custom-control-inline">
            <input type="radio" value="male" @if($student['sex']=="male") checked="" @endif name="sex" id="male_sex" class="custom-control-input">
            <label class="custom-control-label font-weight-600" for="male_sex">Male</label>
        </div>
        <div class="custom-radio custom-control custom-control-inline">
            <input type="radio" value="female"  @if($student['sex']=="female") checked="" @endif  name="sex" id="female_sex" class="custom-control-input">
            <label class="custom-control-label font-weight-600" for="female_sex">Female</label>
        </div>

    </div>
   </div>
   <!-- col-md-3 -->
   <div class="col-md-3 mb-3">
      <label for="title"  class="font-weight-600"> Age &nbsp;/&nbsp; Date of Birth&nbsp;  </label>
      <input @if(!empty($student['dob'])) value="{{$student['dob']}}" @else  value=""  @endif  type="text" name="dob" id="dob" class="form-control datetimepicker bg-white" placeholder="Date of Birth" required >
       {{--   value="2013-04-22 10:21:17" --}}
      <div class="invalid-feedback"> 
         Provide Date of birth
      </div>   <button data-toggle="modal" data-target=".age_calc" type="button" class="btn btn-lg btn-light mt-1"> <i class="fa fa-calculator"></i> </button>
   </div>
   <!-- col-md-3 -->
   <div class="col-md-3 mb-3">
      <label for="title"  class="font-weight-600">Mobile Phone </label>
      <input type="text" @if(!empty($student['phone'])) value="{{$student['phone']}}" @endif  name="phone" id="user-phone" class="form-control" placeholder="Phone No. " required="" >
      <div class="invalid-feedback">
         Provide Mobile Phone
      </div>
   </div>
   <!-- col-md-3 -->

   <div class="col-md-3 mb-3">
      <label for="title"  class="font-weight-600">Email </label>
      <input type="text" @if(!empty($student['email'])) value="{{$student['email']}}" @endif  name="email" id="user-email" class="form-control" placeholder="Email. " >
      <div class="invalid-feedback">
         Provide Email
      </div>
   </div>
   <!-- col-md-3 -->
   
    <div class="col-md-3 mb-3">
        <label for="title"  class="font-weight-600">Your Occupation </label>
        <input type="text" @if(!empty($student['occupation'])) value="{{$student['occupation']}}" @endif  name="occupation" id="user-occupation" class="form-control" placeholder="Occupation" >
        <div class="invalid-feedback">
              Provide Your Occupation
      </div>
   </div>
   
     
      <div class="col-md-3 mb-3 for_family_position family">
        <?php $positions = ['husband','wife','first_child','second_child','third_child','fourth_child','fifth_child','sixth_child','friend','relative','others']; ?>
         <label for="nok_rel"  class="font-weight-600">Family Position  </label>
         <select class="form-control text-capitalize" name="family_position"> 
             <option value="">...</option>
             @foreach($positions as $position)
              <option value="{{$position}}"  @selected($student['family_position']==$position)> {{ str_replace('_',' ',$position)}} </option>
             @endforeach
         </select>
         <div class="invalid-feedback">
            Select Family Position
         </div>
     </div> <!-- col-md-3 -->  
     
     <div class="col-md-3 family">
         <label class="mt-2" style="font-weight: 600"> I'm head of the family </label> <br/>
            <label class="switch">  
                <input type="checkbox"  name="family_host" value="1" @if($student['family_host']==1) checked @endif >
                <span class="slider round"></span>
            </label> 
     </div>
   
</div>
<!-- form-row-->

