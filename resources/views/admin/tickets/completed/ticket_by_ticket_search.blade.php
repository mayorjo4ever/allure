<div class="row mt-0 pt-0">
    
   <div class="col-md-12">
       <div class="card card-border border-primary">
           <div class="card-body" >
                <form id="ticket_customer_search"  action="javascript:void(0)" class="needs-validation" novalidate method="post">@csrf
                 <div class="form-row mt-3">
                     <div class="col-md-6">
                         <label class="font-weight-600">Search Completed Tickets By  </label>
                         <input type="text" name="param" id="ticket_by_ticket" class="form-control" placeholder="Customer ID / Name / Email or Ticket No." required=""/>
                         <span class="admin_ticket_no_error error-text text-danger"></span>
                         <div class="invalid-feedback">
                          Please Ticket No. 
                       </div>
                         <div class="found-ticket mt-3"></div>
                     </div><!-- col-md-6 -->

                     <div class="col-md-3 mb-3">     &nbsp;                        
                          <button class="mt-2 btn btn-primary btn-lg w-100 search-customer-completed-ticket-btn ladda-button" data-style="expand-right" type="submit"> <strong>Search Ticket No. </strong></button>
                       </div>      
                 </div>
                 </form>
             <div class="found-ticket-ticket mt-1 pt-1"> </div>  
                 
      </div> <!-- card-body-->
      </div>
   </div>
    
  
</div>
