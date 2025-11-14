<div class="row mt-0 pt-0">
   <div class="col-md-12">
       <div class="card card-border border-primary">          
           <div class="card-body" >
      <form id="ticket_specimen_search"  action="javascript:void(0)" class="needs-validation" novalidate method="post">@csrf
       <div class="form-row mt-3">
           <div class="col-md-12 font-weight-700 customer mb-3 text-uppercase"></div>
                
           <div class="col-md-4">
               <label class="font-weight-600">Search Specimen  </label>
              <input type="hidden"  name="id" id="user-id" class="form-control" placeholder="serial" >  
               <input type="text" name="sparam" id="specimen_searcher" class="form-control" placeholder="Search Specimen / Bill Type " required=""/>
               <div class="invalid-feedback">
                Please Provide Specimen / Bill Type
             </div>               
             <div class="found-specimen mt-3 mb-3"></div>
               <button class="mt-2 btn btn-primary btn-lg w-100  specimen-search-btn ladda-button" data-style="expand-right" type="submit"> <strong>Search Specimen </strong></button>
           </div><!-- col-md-4 -->
           
           <div class="col-md-8">
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
