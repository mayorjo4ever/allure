 <form onsubmit="filter_daily_report($(this).serialize())" class="needs-validation" novalidate="" method="post" action="javascript:void(0)"> 
        @csrf
    <div class="form-row">
      <div class="col-md-4 mb-3">
          <label for="title" class="font-weight-700"> Calendar Date  </label>
         <input type="text" name="calendar" id="calendar" class="form-control datepicker bg-white"  placeholder="Select Calendar Date " required >         
         <div class="invalid-feedback">
            Select Calendar Date 
         </div>
      </div>
      <?php $options = ['customer'=>'Customers','bills'=>'Billings','payment'=>'Payments','tickects'=>'Tickets']; ?>
      <div class="col-md-4 mb-3">
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
      <div class="col-md-4 mb-3">     &nbsp;                        
          <button class="mt-2 btn btn-primary btn-lg w-100 daily-report-btn ladda-button" data-style="expand-right" type="submit"> <strong> Search &nbsp; <i class="pe pe-7s-search" > </i></strong></button>
      </div>
    </div>
</form>
         
