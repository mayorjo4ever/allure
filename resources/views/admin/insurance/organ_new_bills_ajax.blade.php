<?php use Carbon\Carbon; ?>
<p class="h6 bg-light p-2">New Bills</p>

@if($org_id=="")
<p class="text-danger font-20">Select Organization Body</p>
@else
<input type="hidden" value="{{$org_id}}" name="organization_id"/>
    <table class="table">
        <tr class="text-uppercase font-weight-700">
            <td>SN</td>
            <td>Patient</td>
            <td>Amount</td>
            <td>Discount</td>
        </tr>
        @foreach($new_bills as $k=>$bill)
            <tr class="text-uppercase">
                <td>{{$k+1}}</td>
                <td><b>{{$bill->user->surname ." ".$bill->user->firstname }} </b><br/>
                    hmo: {{$bill->user->hmo }}  &nbsp; 
                    file no: {{$bill->user->regno }}  <br/>
                    hmo no :  {{$bill->user->enrole_no }} <br/>
                    ticket no :  {{$bill->ticketno }}
                </td>
                <td>{{$bill->total_cost  -  $bill->amount_paid}}
                <input type="hidden" name="bill_ids[]" value="{{$bill->id}}" placeholder="bill id"/>
                </td>
                <td><input style="width: 100px" name="discounts[]" value="0.00" type="text" class="form-control form-control-lg"/></td>
            </tr>
        @endforeach
    </table> 
     <div class="col-sm-12">        
         <button  type="submit" class="btn btn-success p-2 btn-block " style="font-size: 1.5rem">
            Add Bills
        </button>             
    </div>
 @endif