<div class="row mt-0 pt-0">
   <div class="col-md-12">
       <div class="card card-border border-primary">
           <div class="card-header"> <span class="card-title"> Add More Bills / Investigations For {{ $ticket_no}} </span> </div>
           <div class="card-body" >
      <form id="ticket_specimen_search_2"  action="javascript:void(0)" class="needs-validation" novalidate method="post">@csrf
       <div class="form-row">
           <div class="col-md-12 font-weight-700 customer mb-3 text-uppercase"></div>
                
           <div class="col-md-4">
               <label class="font-weight-600">Investigations / Bills </label>
              <input type="hidden"  name="ticket_no" id="ticket_no" value="{{$ticket_no}}" class="form-control" placeholder="Ticket No" >  
              <input type="hidden"  name="user_id" id="user_id" value="{{$user_id}}" class="form-control" placeholder="serial" >  
               <input type="text" name="sparam" id="specimen_searcher_2" class="form-control" placeholder="Search Specimen / Bill Type " required=""/>
               <div class="invalid-feedback">
                Please Provide Specimen / Bill Type
             </div> 
           </div> 
           <div class="col-md-4 mt-2 pt-3">             
               <button class="mt-2 btn btn-primary btn-lg w-100  specimen-search-btn-2 ladda-button" data-style="expand-right" type="submit"> <strong>Search Specimen </strong></button>
           </div><!-- col-md-4 -->
           
           <div class="col-md-12 mt-3"> <div class="found-specimen mt-3 mb-3"></div> </div>
           
           <div class="col-md-12 mt-3">
               <div class="final-specimen-form ml-4"></div>
           </div>
               <!-- -->
           </div><!-- form-row -->
          
           <div class="form-row mt-1">
                      
         </div><!-- form-row -->
       </form>
      </div>
      </div>
   </div>
</div>
