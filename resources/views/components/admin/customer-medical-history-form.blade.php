
<form method="post" id="customer_medical_history"> @csrf
<div class="form-row mt-2">    
    <div class="col-sm-12 mb-3">
      <label for="history"  class="font-weight-600">History</label>
      <input type="hidden"  value="" name="user_id" id="user_id" class="user_id form-control" placeholder="User ID" >
      <textarea rows="4" name="history" id="history" class="form-control" placeholder="History"></textarea>
      <div class="invalid-feedback">
         Provide History
      </div>
     </div> <!-- col-sm-6 --> 
     
     <div class="col-sm-12 mb-3">
      <label for="account_type"  class="font-weight-600">Family History </label>
       <textarea rows="4" name="family-history" id="family-history" class="form-control" placeholder="Family History"></textarea>
      <div class="invalid-feedback">
         Provide Family History.
      </div>
     </div> <!-- col-sm-6 --> 
     
     <div class="col-sm-12 mb-3">
      <label for="account_type"  class="font-weight-600">Drug History </label>
       <textarea rows="4" name="drug-history" id="drug-history" class="form-control" placeholder="Drug History"></textarea>
      <div class="invalid-feedback">
         Provide Family History.
      </div>
     </div> <!-- col-sm-6 --> 
         
     
     
      <div class="col-md-12 mb-3"> &nbsp;
       <button onclick="submit_updated_customer_medical_history()" class="mt-2 btn btn-primary btn-lg w-100  submit-updated-customer-medical-history-btn ladda-button" data-style="expand-right" type="button"> <strong> Update Customer Medical History  </strong></button>
   </div>
</div>
</form>