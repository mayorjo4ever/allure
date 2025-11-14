<?php 
# sprint_r($data);
?>

 @if(!empty($customers)) <?php #  print_r($customers);  ?>
 <div class="row mt-3">
   <div class="col-md-12"> 
       <div class="main-card mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
           <div class="card-header">All Customers  </div>
           <div class="card-body">
               <div class="table-responsive  mt-2 pt-2 ">
        <table class="align-middle mb-0 table table-borderless table-sm table-striped table-hover dataTable">
            <thead>
            <tr>               
                <th>ID No </th>
                <th>Name </th>
                <th>Account Type </th>
                <th>Gender </th>
                <th>Total Tickets </th>                               
                <th>Email </th>                
                <th>Phone </th> 
            </tr>
            </thead>
            <tbody> @foreach($customers as $custom )
                <?php $customer = users_info($custom['customer_id']); ?>
                <tr>                   
                    <td class="text-muted pl-4">{{ $customer['regno']}} </td>
                    <td class="text-uppercase"> {{ $customer['fullname']}} </td> 
                    <td class="text-uppercase"> {{ $customer['account_type']}} </td> 
                    <td class="text-capitalize"> {{  $customer['sex'] }}  </td> 
                    <td>{{ $custom['total']}} </td>                  
                    <td>{{ $customer['email']}} </td>                  
                    <td>{{ $customer['phone']}} </td>                  
                   </tr>
                    @endforeach
                    </tbody>
            </table>
            </div>
           </div>
       </div>
         
     </div>
     
 </div>
 @else 
 <div class="alert alert-info"> No Customers</div>
 @endif


 @if(!empty($bills)) 
 <div class="row mt-3">
   <div class="col-md-12"> 
       <div class="main-card mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
           <div class="card-header">All Bills / REQUESTS </div>
           <div class="card-body">
               <div class="table-responsive  mt-2 pt-2 ">
        <table class="align-middle mb-0 table table-borderless table-sm table-striped table-hover dataTable">
            <thead>
            <tr>               
                <th>S/No </th>
                <th> Bills / REQUESTS </th>                
                <th>Total Qty </th>                                               
            </tr>
            </thead> <?php $sn = 1; ?>
            <tbody> @foreach($bills as $custom )
                <?php $bill = bill_name($custom['bill_type_id']); ?>
                <tr>                   
                    <td class="text-muted pl-4">{{ $sn }} </td>
                    <td class="text-uppercase"> {{ $bill}} </td> 
                    <td class="text-capitalize"> {{  $custom['total'] }}  </td>  
                   </tr> <?php $sn++; ?>
                    @endforeach
                    </tbody>
            </table>
            </div>
           </div>
       </div>
         
     </div>
     
 </div>
  @else 
 <div class="alert alert-info"> No Bills</div>
 @endif
 
 
 @if(!empty($payments)) 
 <div class="row pt-3">
    <div class="col-md-12">
        <div class="main-card mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
           <div class="card-header">PAYMENTS </div>
           <div class="card-body">   
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
                    <td>{{$payment[0]['ticket_no']}} </td>
                    <td>{{users_name($payment[0]['ticket']['customer_id'])}} </td>
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
        
    </div>
</div>
 @else 
 <div class="alert alert-info">No Payment</div>
 @endif
 
 
 @if(!empty($tickets)) 
 <div class="row pt-3">
    <div class="col-md-12">
        <div class="main-card mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
           <div class="card-header">TICKETS </div>
           <div class="card-body">               
        <span class="big text-primary text-uppercase">Note that this report was sorted by date of registration </span> 
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
                    <th>balance</th>
                    <th>refund</th>
                </tr>
                @php $total_bill = 0;  $each_pay =0;   $allcash = 0; $allpos = 0; $alltransfer = 0;   
                $each_balance = 0; $refunds = 0;  $total_balance = 0 ;
                @endphp
               
                @foreach($tickets as $k=>$payment)
                <tr class="text-capitalize">
                     @php 
                        $cashes = extract_amount($payment['payment'],'cash'); 
                        $pos = extract_amount($payment['payment'],'pos');
                        $transfers = extract_amount($payment['payment'],'transfer'); 
                        /*********************************/
                        $cash_sum = empty($cashes)?0:array_sum($cashes);
                        $pos_sum = empty($pos)?0:array_sum($pos);
                        $transfer_sum = empty($transfers)?0:array_sum($transfers);
                        $each_pay = $cash_sum + $pos_sum + $transfer_sum; 
                        $each_balance = ($payment['payment_completed']=="no")? ( $payment['total_cost'] - $payment['amount_paid']):0; 
                        
                    @endphp
                    <td>{{($k+1)}}</td>
                    <td>{{$payment['ticket_no']}} </td>
                    <td>{{users_name($payment['customer_id'])}} </td>
                    <td>{{number_format($payment['total_cost'])}} </td>                      
                    <td title="By Cash"> {{Arr::join($cashes,', ')}}</td>
                    <td title="By POS">{{Arr::join($pos,', ')}}</td>
                    <td title="By Transfer">{{Arr::join($transfers,', ')}}</td>                       
                    <td>{{number_format($each_pay)}} </td>
                    <td>{{number_format($each_balance)}} </td>
                   <td>{{number_format($payment['refund'])}} </td>
                </tr>
                  @php  
                    $allcash += $cash_sum;
                    $allpos += $pos_sum;
                    $alltransfer += $transfer_sum;    
                    $total_bill += $payment['total_cost']; 
                    $total_balance += $each_balance; 
                    $refunds += $payment['refund']; 
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
                    <th><small>balance</small><br/>{{number_format($total_balance)}}</th>
                    <th><small>refund</small><br/>{{number_format($refunds)}}</th>                  
                </tr>
                 <tr class="text-uppercase">
                    <th colspan="6" class="text-right">&nbsp; </th>
                    <th><small>Total bill</small><br/>{{number_format($total_bill)}}</th>
                    <th colspan=""><small>Net Pay</small><br/>{{number_format($total_pay - $refunds)}} </th>
                    <th colspan="2"><small>balance</small><br/>{{number_format($total_balance)}}</th>
                </tr>
            </table>
        </div>
      </div> 
     </div> 
    </div>
</div>
 @else 
 <div class="alert alert-info">No Tickets </div>
 @endif
 
 
 
 <?php # print_r($payments);?>



