<div class="row mt-0 pt-0">
    
   <div class="col-md-12">
       <div class="card   card-border border-primary">
           <div class="card-body" >
               <form id="all_pending_payments" onsubmit="list_all_pending_payments($(this).serialize())"  action="javascript:void(0)" class="needs-validation" novalidate method="post">@csrf
                 <div class="form-row mt-1">
                     <div class="col-md-3 mb-3">     &nbsp;                        
                          <button class=" btn btn-info btn-lg w-100  pending-payment-list-btn ladda-button" data-style="expand-right" type="submit"> <strong> Refresh Pending Payment List </strong></button>
                       </div>      
                 </div>
                 </form>
                 
               <div class="found-pending-payments"></div>
               
      </div> <!-- card-body-->
      </div>
   </div>
    
  
</div>
