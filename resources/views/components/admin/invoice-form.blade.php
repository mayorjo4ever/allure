<div class="row" id="existng-invoice-form">
    <div class="col-md-12">
        <span class="h5">Select HMO / Organizational Body To Add To ?</span>
    </div>
    <div class="col-sm-12 mb-3">
         <label> </label> <br/>
         <select onchange="check_our_initial_bills($(this).val())" class="form-control w-100 form-control-lg " id="organ_body" name="organ_body"  style="font-size: 1.2rem">
            <option value=""></option>                     
         </select>
    </div> 
     
</div>


<form method="post" id="organization_bill" onsubmit="submit_organization_bill($(this))" action="javascript:void(0)">@csrf
    <div class="row mt-2 pt-2"> 
      <input id="new_bills" name="new_bills" type="hidden" /> 
      <div class="col-sm-12 mb-3">
        <div id="org-new-bills"></div>
      </div> 
    </div>
    </form>

<div class="row mt-2 pt-2"> 
    <div class="col-sm-12 mb-3">
         <div id="org-initial-bills"></div>
    </div>
   
</div>