<?php use Carbon\Carbon; ?>
<p class="h6 bg-light p-2">Our Bills</p>
@if($org_id=="")
    <p class="text-danger font-20">Select Organization Body</p>
@else

    @if(empty($initial_bills->toarray()))
         <p class="text-dark font-20"> No Outstanding Bills </p>
    @else 
     
    @php $total_cost = 0; $total_discount = 0; @endphp
    <table class="table">
        <tr class="text-uppercase font-weight-700">
            <td>SN</td>
            <td>Patient</td>
            <td>Amount</td>
            <td>Discount</td>
            <td>&#8358;  TOTAL</td>
        </tr>
    @foreach($initial_bills as $k=>$bill)
        <tr class="text-uppercase">
                <td>{{$k+1}}</td>
                <td><b>{{$bill->user->surname ." ".$bill->user->firstname }} </b><br/>
                    hmo: {{$bill->user->hmo }}  &nbsp; 
                    file no: {{$bill->user->regno }}  <br/>
                    hmo no :  {{$bill->user->enrole_no }} <br/>
                    ticket no :  {{$bill->bill->ticketno }}
                </td> 
                @php $total_cost += $bill->amount; $total_discount += $bill->discount; @endphp
                <td>{{$bill->amount}}  </td>
                <td>{{$bill->discount}}</td>
                <td>&#8358; {{number_format($bill->amount - $bill->discount)}}
                    <br/><small>
                {{ $bill->updated_at }} <br/> {{Carbon::parse($bill->updated_at)->diffForHumans()}}</small>
                </td>
            </tr>
    @endforeach
    <tr>
        <td colspan="2"></td>        
        <td>{{number_format($total_cost)}}</td>
        <td>{{number_format($total_discount)}}</td>
        <td><strong>{{number_format($total_cost - $total_discount)}}</strong></td>
    </tr>
    </table>
    @endif

@endif