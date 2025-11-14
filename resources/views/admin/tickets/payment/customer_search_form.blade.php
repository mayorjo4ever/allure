<div class="row mt-0 pt-0">
    
   <div class="col-md-12">
       <div class="card   card-border border-primary">
           <div class="card-body" >
                <form id="ticket_customer_search"  action="javascript:void(0)" class="needs-validation" novalidate method="post">@csrf
                 <div class="form-row mt-3">
                     <div class="col-md-6">
                         <label class="font-weight-600">Search Customer ID / Name / Email </label>
                         <input type="text" name="param" id="customer_searcher_payment" class="form-control" placeholder="Search Customer ID / Name / Email" required=""/>
                         <span class="admin_ticketno_error error-text text-danger"></span>
                         <div class="invalid-feedback">
                          Please Provide Customer Info 
                       </div>
                         <div class="found-ticket mt-3"></div>
                     </div><!-- col-md-6 -->

                     <div class="col-md-3 mb-3">     &nbsp;                        
                          <button class="mt-2 btn btn-primary btn-lg w-100  customer-search-payment-btn ladda-button" data-style="expand-right" type="submit"> <strong>Search Customer </strong></button>
                       </div>      
                 </div>
                 </form>
             <div class="found-payment mt-3 pt-3"> </div>  
                 
      </div> <!-- card-body-->
      </div>
   </div>
    
  
</div>
