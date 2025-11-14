  <div class="card card-border border-primary">
     <div class="card-body" >    
       <form id="ticket_customer_profile"  action="javascript:void(0)" class="needs-validation" novalidate method="post">@csrf
    <div class="form-row mt-2">     
 
     <div class="col-md-3 mb-3">
      <label for="title"  class="font-weight-600">Identity No.  </label>
      <input type="hidden"  name="id" id="user-id" class="form-control" placeholder="serial" > 
      <input type="text"  name="regno" id="user-regno" class="form-control" placeholder="Identity No." required > 
      <div class="invalid-feedback">
         Provide Your Identity No.
      </div>
     </div><!-- comment -->
   <div class="col-md-3 mb-3">
      <label for="title"  class="font-weight-600">Surname  </label>
      <input type="text" name="surname" id="user-surname" class="form-control" placeholder="Surname" required > 
      <div class="invalid-feedback">
         Provide Your Surname
         <span class="tick_surname_error error-text text-danger font-weight-600"> Provide Date of birth</span>
      </div>
   </div>
   <!-- col-md-3 -->
   <div class="col-md-3 mb-3">
      <label for="title"  class="font-weight-600">First Name </label>
      <input type="text"  name="firstname" id="user-firstname" class="form-control" placeholder="Firstname" required >                        
      <div class="invalid-feedback">
         Provide First Name
         <span class="tick_firstname_error error-text text-danger font-weight-600"> Provide First Name</span>
      </div>
   </div>
   <!-- col-md-3 -->
   <div class="col-md-3 mb-3">
      <label for="title"  class="font-weight-600">Other Name </label>
      <input type="text"  name="othername" id="user-othername" class="form-control" placeholder="Other name" >                        
      <div class="invalid-feedback">
         Provide Other Name
      </div>
   </div>
   <!-- col-md-3 -->
   <div class="col-md-3 mb-3">
       <label for="title" class="font-weight-600">Gender </label>
      <div>
        <div class="custom-radio custom-control custom-control-inline">
            <input type="radio" value="male"  name="sex" id="male-sex" class="custom-control-input">
            <label class="custom-control-label font-weight-600" for="male-sex">Male</label>
        </div> 
        <div class="custom-radio custom-control custom-control-inline">
            <input type="radio" value="female"   name="sex" id="female-sex" class="custom-control-input">
            <label class="custom-control-label font-weight-600" for="female-sex">Female</label>           
        </div>
    </div> <div class="invalid-feedback">      
     Select Sex
        </div>
   </div>
   <!-- col-md-3 -->
   <div class="col-md-3 mb-3">
      <label for="title"  class="font-weight-600">Date of birth </label>
      <input type="text" name="dob" id="user-dob" class="form-control datepicker bg-white" placeholder="Date of Birth" required >                        
      <div class="invalid-feedback">
         Provide Date of birth
      </div>
   </div>
   <!-- col-md-3 -->
   <div class="col-md-3 mb-3">
      <label for="title"  class="font-weight-600">Mobile Phone </label>
      <input type="text"  name="phone" id="user-phone" class="form-control" placeholder="Phone No. " >                        
      <div class="invalid-feedback">
         Provide Mobile Phone
      </div>
   </div>
   <!-- col-md-3 -->
   
   <div class="col-md-3 mb-3">
      <label for="title"  class="font-weight-600">Email </label>
      <input type="text" name="email" id="user-email" class="form-control" placeholder="Email. " >                        
      <div class="invalid-feedback">
        Provide email 
      </div>
   </div>
   <!-- col-md-3 -->
   <div class="col-md-4 mb-3"> &nbsp;                        
      <button class="mt-2 btn btn-primary btn-lg w-100  ticket-customer-profile-btn ladda-button" data-style="expand-right" type="submit"> <strong> {{ empty($student['id']) ? " Create New Customer ":"Update Customer " }} </strong></button>
   </div>
</div>
<!-- form-row-->
       </form>
     </div>
  </div>