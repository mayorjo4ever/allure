<div class="form-row mt-2">
     <div class="col-md-3 mb-3">
      <label for="title"  class="font-weight-600">Hospital No.  </label>
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
   <div class="col-md-6 mb-3"> &nbsp;
      <button class="mt-2 btn btn-primary btn-lg w-100  new-student-btn ladda-button" data-style="expand-right" type="submit"> <strong> {{ empty($student['id']) ? " Create New Customer ":"Update Customer " }} </strong></button>
   </div>
</div>
<!-- form-row-->
