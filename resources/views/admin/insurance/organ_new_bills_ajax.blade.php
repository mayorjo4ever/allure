<p class="h6 bg-light p-2">New Bills</p>

@if($org_id=="")
<p class="text-danger">Select Organization Body</p>
@else
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
            <td>{{$bill->total_cost  -  $bill->amount_paid}}</td>
            <td><input style="width: 100px" type="text" class="form-control form-control-lg"/></td>
        </tr>
    @endforeach
</table> 
 @endif