
<div class="modal fade age_calc" role="dialog" aria-labelledby="age_calc" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Calculate Customer's Date of Birth  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div class="row">
                    <div class="col-md-12"> <form id="ageCalc" onsubmit="calculateAge()" method="post" action="javascript:void(0)" class="needs-validation" novalidate=""> @csrf                         
                        <div class="form-row mt-3">                            
                            <div class="col-md-6">
                                <label class="font-weight-700">How Many &nbsp;&nbsp;  <span class="ca1_mark"></span> </label>
                                <input class="form-control age_value" type="text" name="age_value" id="age_value" value="" required="" />
                            </div>
                             
                             <div class="col-md-6">
                                <label class="font-weight-700"> Select years / Months &nbsp; &nbsp; <span class="exam_mark"></span>  </label>
                                <select class="form-control age_range" name="age_range" id="age_range" value="" required="">
                                    <option value="years">Years</option>
                                    <option value="months">Months</option>
                                    <option value="weeks">Weeks</option>
                                    <option value="days">Days</option>
                                    <option value="hours">Hours</option>
                                </select>
                            </div>
                        </div>
                       </form>
                    </div><!-- ./ col-md-12 -->
                    
                </div><!-- ./ row -->
            </div>
            <div class="modal-footer mt-3">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button onclick="$('form#ageCalc').submit()" type="button" class="btn btn-primary btn-lg age-calculator-btn ladda-button" data-style="expand-right"> Calculate &nbsp; <i class="fa fa-calculator"></i> </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade add-family-dependant" id="add-family-dependant"  role="dialog" aria-labelledby="age_calc" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add More Family Dependent  - <span class="faimily-info"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ">
                <div class="row">
                    <div class="col-md-12"> <form id="ticket_customer_search" onsubmit="submit_family_dependent()" method="post" action="javascript:void(0)" class="needs-validation" novalidate=""> @csrf 
                        <input type="hidden" name="family_id" id="family_id" value="{{$param ??""}}" />
                        <div class="form-row mt-3">                            
                            <div class="col-md-3">
                                <label class="font-weight-700">Search Existing Users &nbsp;&nbsp;  <span class="pe pe-7s-search pe-2x"></span> </label>
                                <input type="text" name="param" id="customer_searcher" class="form-control" placeholder="Search Customer ID / Name / Email" required=""/>
                                <br/>
                                <div class="found-customer mt-3"></div>
                            </div>
                        </div>
                        <div class="form-row">                            
                            <div class="col-md-2">
                                <label class="font-weight-700"> &nbsp; </label><br/>
                                <button class="btn btn-info btn-block m-2 pb-3 add-family-dependant-start-btn ladda-button" data-style="expand-right"> Proceed </button>
                            </div>
                            
                           <div class="col-md-9 offset-1 output-search">                                
                            </div>
                            
                        </div>
                       </form>
                    </div><!-- ./ col-md-12 -->
                    
                </div><!-- ./ row -->
            </div>
            <div class="modal-footer mt-3">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="$('form#ticket_customer_search').submit()" class="btn btn-primary btn-lg submit-family-dependent-btn ladda-button" data-style="expand-right"> Yes Add To The Family &nbsp; <i class=""></i> </button>
            </div>
        </div>
    </div>
</div>

  
<x-admin.modal id="set_doctor_availability" title="Set Doctors Available Days ">
    <span class="ajaxLoader"></span> 
        <div class="mb-3">
            <form class="doctor_availability_form"> @csrf  
                <input type="hidden" name="doctor_id" id="doctor_id" value="" />
            <span class="font-weight-bold h6">Doctor's Name : </span> &nbsp; <span class="cert-name"></span> <br/> <br/>             
            <label for="name" class="mt-1 pt-1 font-weight-bold h6">Available Days </label>
            <div class="form-row">   <div class="col-sm-12">            
              @php  $days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];  @endphp
              @foreach($days as $day)
                <div class="custom-checkbox custom-control mb-3 mr-2 ml-2 float-left">
                    <input type="checkbox" name="days[]" class="custom-control-input" id="my_{{$day}}" value="{{ $day }}" >
                    <label for="my_{{$day}}" class="custom-control-label">   {{ $day }} </label>
                </div>
               @endforeach
            </div> </div> <!-- ./ form-row -->
            
            <div class="form-row">
                <div class="col-sm-6">
                    <label class="font-weight-bold">Start Time</label>
                <input type="text" name="start_time" class="form-control bg-white timepicker" required>
                </div> 
                <div class="col-sm-6">
                    <label class="font-weight-bold">End Time</label>
                <input type="text" name="end_time" class="form-control bg-white timepicker" required>
                </div></div>

            <div class="form-check">
                <label class="mt-2" style="font-weight: 600"> Available </label> <br/>
                <label class="switch">  
                    <input type="checkbox"  name="is_active" value="1"  checked  >
                    <span class="slider round"></span>
                </label> 
            </div> 
            
            <input type="text" class="update-re form-control datetimepicker" id="appointment_date" value=""/> 
            
            </form>
            
        </div> 
        <x-slot name="footer">
            <button type="button" class="btn btn-secondary  btn-lg p-2  close-btn" data-dismiss="modal">Cancel</button>
            <button onclick="submit_doctor_availability_form()" type="submit" class="btn btn-success btn-lg p-2 doctor-avail-update-btn ladda-button" data-style="expand-right">Update Availability </button>
        </x-slot>
    
</x-admin.modal>


 <x-admin.modal id="update-medical-history" title="Update Patient Medical History">
      <x-admin.customer-medical-history-form></x-admin.customer-medical-history-form>     
 </x-admin.modal>

 <x-admin.modal id="update-patient-profile" title="Update Patient Profile" size="md">
     <x-admin.customer-basic-form></x-admin.customer-basic-form>     
 </x-admin.modal>

 <x-admin.modal id="view-investigation-result" title="Investigaton Result" size="lg">
    <div id="invest-result"></div>
 </x-admin.modal>

 <x-admin.modal id="write-doctors-report" title="Doctor's Report" size="lg">
    <textarea id="complaint_forms"  name="complaint_forms" rows="4" placeholder="Complaints / Questions & Answers / Inquiries " class="form-control tinymce form-textarea"></textarea>
    <button onclick="save_doctors_comment()" class="btn btn-outline-primary w-100 font-weight-800 ladda-button p-2 mt-2 save-doctors-comment-btn" data-style="expand-right" type="button"> Save Report </button>

 </x-admin.modal>

<!-- make new appointment during consultation -->
 <x-admin.modal id="next_appointment_modal" title="Schedule Next Appointment Day" size="lg">
       <input type="hidden" value="" id="ref_no"/>
            <div id="doctor-name" class="mb-3"></div>
            <div id="doctor-calendar" class="mt-3"></div>
            <div id="time-slots" class="mt-3"></div>
 </x-admin.modal>

 <x-admin.modal id="payment_invoice_modal" title="Add Bill To Invoice" size="lg">
       <input type="hidden" value="" id="ref_no"/>
            
 </x-admin.modal>