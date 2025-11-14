<?php 
    use App\Models\BillType;
    
    ?>

<form onsubmit="filter_overall_report($(this).serialize())" class="needs-validation" novalidate="" method="post" action="javascript:void(0)"> 
        @csrf
    <div class="form-row">
      <div class="col-md-3 mb-3">
          <label for="title" class="font-weight-700"> Date From </label>
         <input type="text" name="dfrom" id="calendar1" class="form-control datepicker bg-white"  placeholder="Select Calendar Date " required >         
         <div class="invalid-feedback">
            Select Calendar Date 
         </div>
      </div>
        
        <div class="col-md-3 mb-3">
          <label for="title" class="font-weight-700"> Date To </label>
         <input type="text" name="dto" id="calendar2" class="form-control datepicker bg-white"  placeholder="Select Calendar Date " required >         
         <div class="invalid-feedback">
            Select Calendar Date 
         </div>
        </div>
        
      <?php $options = ['customer'=>'Customers','bills'=>'Billings','payment'=>'Payments','tickets'=>'Tickets']; ?>
      <div class="col-md-3 mb-3">
          <label for="code" class="font-weight-700"> Reports To Include </label>
          <select multiple="" name="report_types[]" id="report_types" class="form-control select2"  placeholder="Recommended Treatments" >
               @foreach($options as $k => $option):                
                <option value="{{$k}}" >{{$option}} </option>              
              @endforeach
          </select>
         <div class="invalid-feedback">
            Provide Recommended Treatments
         </div>
      </div>
      
         <div class="col-md-3 mb-3">
         <?php  $bill_types = BillType::where('status',1)->orderBy('name')->get()->toArray(); ?>
          <label for="code" class="font-weight-700"> Specific Investigation </label>
          <select multiple="" name="investigations[]" id="investigations_bills" class="form-control select2"  placeholder="Select Specific Investigations / Leave Blank " >
               @foreach($bill_types as $k => $bill):                
                <option value="{{$bill['id']}}" >{{$bill['name']}} </option>              
              @endforeach
          </select>
         <div class="invalid-feedback">
            Provide Recommended Treatments
         </div>
      </div>
        
      <div class="col-md-12 mb-3">     &nbsp;                        
          <button class="mt-2 btn btn-primary btn-lg w-100 overall-report-btn ladda-button" data-style="expand-right" type="submit"> <strong> Search &nbsp; <i class="pe pe-7s-search" > </i></strong></button>
      </div>
    </div>
</form>
         
