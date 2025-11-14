<div class="row mt-0 pt-0">
   <div class="col-md-12">
       <div class="card card-border border-primary">
           <div class="card-body" >  
            @can('view-ticket')
            
            <form method="">
                <div class="form-row">
                    <div class="col-md-6 mb-3"> 
                        <input type="text" name="filteration" id="filteration" class="form-control h-2-5-rem font-1rem" placeholder="Filter By Name , Ticket No." />
                    </div>
                    <div class="col-md-6 mb-3">
                        <button type="button" onclick="show_pending_tickets()" class="btn btn-primary h-2-5-rem font-1rem ladda-button" data-style="expand-right"> Filter Pending Tickets</button>
                    </div>
                </div>
            </form>
             <span class="ajaxLoader bg-dark h2 ladda-button " data-style="expand-right"></span>
                        
             <div class="pending-tickets"> </div>
             @endcan  
      </div>
      </div>
   </div>
</div>
