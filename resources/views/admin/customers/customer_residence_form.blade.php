<?php 
    use Carbon\Carbon;
    use App\Models\Country; 
    $countries = Country::countries();
    // dd($countries); 
?>
<p class="card-title pt-3 mt-3">Address Info &nbsp; <button type="button" onclick="toggleShowAddress()" class="btn btn-info pull-right">Show Address </button></p> <hr> 
<div class="form-row mt-2">
     <div class="col-md-3 mb-3 address">
          <label for="title">Country </label>
          <select name="country" id="country" onchange="load_student_state_of_origin()" class="form-control" required="" >
              <option value="">--</option>
              @foreach($countries as $country)
              <option value="{{$country->id}}" @selected($country->id==$student['country_id'])  @selected($country->id==161) >{{$country->name}}</option>
              @endforeach
          </select>
          <div class="invalid-feedback">
             Select Country
          </div>
       </div> <!-- col-md-3 -->
       
       <div class="col-md-3 mb-3 address">
           <div class="state_loader"></div>
       </div> <!-- col-md-3 -->
       
       <div class="col-md-3 mb-3 address">
           <div class="city_loader"></div>
       </div> <!-- col-md-3 -->    
       
        <div class="col-md-3 mb-3 address">
            <label for="title"  class="font-weight-600">Your Residence Address </label>
            <input type="text" @if(!empty($student['residence'])) value="{{$student['residence']}}" @endif  name="residence" id="user-residence" class="form-control" placeholder="Your Residence Address" >
            <div class="invalid-feedback">
               Provide Your Residence Address
            </div>
   </div>
   <!-- col-md-3 -->
        
     
 
   <!-- col-md-3 -->
   
    <div class="col-md-3 mb-3 address">
      <label for="title"  class="font-weight-600">Name and Address of Employee </label>
      <input type="text" @if(!empty($student['employee_address'])) value="{{$student['employee_address']}}" @endif  name="employee_address" id="user-employee-address" class="form-control" placeholder="Name and Address of Employee " >
      <div class="invalid-feedback">
         Provide Name and Address of Employee 
      </div>
   </div>
   <!-- col-md-3 --> 
       
</div>