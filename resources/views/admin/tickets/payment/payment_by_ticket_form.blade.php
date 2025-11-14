<div class="row mt-0 pt-0">
    
   <div class="col-md-12">
       <div class="card   card-border border-primary">
           <div class="card-body" >
               <form id="ticket_payment_date_form" onsubmit="search_payment_by_ticket($(this).serialize())"  action="javascript:void(0)" class="needs-validation" novalidate method="post">@csrf
                 <div class="form-row mt-3">
                     <div class="col-md-3">
                         <label class="font-weight-600">From Date </label>
                         <input type="text" name="ticket_from" id="ticket_from" class="form-control datepicker bg-white" required=""/>
                         <span class="admin_pay_sum_from_error error-text text-danger"></span>
                         <div class="invalid-feedback">
                          Please Provide From Date 
                       </div>
                         <div class="found-ticket mt-3"></div>
                     </div><!-- col-md-3 -->
                     
                     <div class="col-md-3">
                         <label class="font-weight-600">To Date </label>
                         <input type="text" name="ticket_to" id="ticket_to" class="form-control datepicker bg-white" required=""/>
                         <span class="admin_pay_sum_to_error error-text text-danger"></span>
                         <div class="invalid-feedback">
                          Please Provide To Date 
                       </div>
                         <div class="found-ticket mt-3"></div>
                     </div><!-- col-md-3 -->

                     <div class="col-md-3 mb-3">     &nbsp;                        
                          <button class="mt-2 btn btn-primary btn-lg w-100  ticket-search-payment-btn ladda-button" data-style="expand-right" type="submit"> <strong>Search By Ticket Summary </strong></button>
                       </div>      
                 </div>
                 </form>
                 
               <div class="found-ticket-payment"></div>
               
      </div> <!-- card-body-->
      </div>
   </div>
    
  
</div>
