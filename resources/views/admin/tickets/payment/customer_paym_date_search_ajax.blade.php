<div class="row pt-3">
    <div class="col-md-12">
        <span class="big text-primary text-uppercase">Note that this report was sorted by date of payment </span> 
        <div class="table pt-3">
            <table class="table w-100 table-bordered border-dark">
                <tr class="text-uppercase">
                    <th>S/N</th>
                    <th>ticket no </th>
                    <th>name</th>
                    <th>total bill </th>
                    <th><small>payment by</small><br/>cash</th>
                    <th><small>payment by</small><br/>pos</th>
                    <th><small>payment by</small><br/>transfer</th>
                    <th>total pay</th>
                    <!--<th>balance</th>
                    <th>refund</th>-->
                </tr>
                @php $total_bill = 0; $allcash = 0; $allpos = 0; $alltransfer = 0;  @endphp
                @foreach($payments as $k=>$payment)
                <tr class="text-capitalize">
                    @php 
                        $cashes = extract_amount($payment,'cash'); 
                        $pos = extract_amount($payment,'pos');
                        $transfers = extract_amount($payment,'transfer'); 
                        /*********************************/
                        $cash_sum = empty($cashes)?0:array_sum($cashes);
                        $pos_sum = empty($pos)?0:array_sum($pos);
                        $transfer_sum = empty($transfers)?0:array_sum($transfers);
                        $each_pay = $cash_sum + $pos_sum + $transfer_sum; 
                        
                    @endphp
                    <td>{{$k}}</td>
                    <td>{{$payment[0]['ticketno']}} </td>
                    <td>{{users_name($payment[0]['ticket']['patient_id'])}} </td>
                    <td>{{number_format($payment[0]['ticket']['total_cost'])}} </td>                      
                    <td title="By Cash"> {{Arr::join($cashes,', ')}}</td>
                    <td title="By POS">{{Arr::join($pos,', ')}}</td>
                    <td title="By Transfer">{{Arr::join($transfers,', ')}}</td>                    
                    <td>{{number_format($each_pay)}} </td>
                    <!--<td>{{ number_format(($payment[0]['ticket']['payment_completed']=="no")? ( $payment[0]['ticket']['total_cost'] - $payment[0]['ticket']['amount_paid']):0) }} </td>
                   <td>{{number_format($payment[0]['ticket']['refund'])}} </td>-->
                </tr>
                @php  
                    $allcash += $cash_sum;
                    $allpos += $pos_sum;
                    $alltransfer += $transfer_sum;                    
                    $total_bill += $payment[0]['ticket']['total_cost']; 
                @endphp 
                @endforeach
                
                @php 
                $total_pay = $allcash + $allpos + $alltransfer; 
                @endphp
                
                <tr class="text-uppercase">
                    <th>S/N</th>
                    <th>ticket no </th>
                    <th>name</th>
                    <th><small>Total bill</small><br/>{{number_format($total_bill)}}</th>
                    <th><small>cash</small><br/>{{number_format($allcash)}}</th>
                    <th><small>pos</small><br/>{{number_format($allpos)}}</th>
                    <th><small>transfer</small><br/>{{number_format($alltransfer)}}</th>
                    <th><small>total pay</small><br/>{{number_format($total_pay)}}</th>
                    <!--<th><small>balance</small><br/>0.00</th>
                    <th><small>refund</small><br/>0.00</th>     -->             
                </tr>
                
            </table>
        </div>
        
    </div>
</div>