<?php
 use Carbon\Carbon; 
?>
<div class="row"><div class="col-sm-12"><br/>
        <center>
            <img src="data:image/png;base64,{{ $barcodeImage }}" alt="barcode" />
        </center>
    <table class="table table-sm table-borderless">
        <tr align="center">
            <td></td>
            <td class="text-uppercase font-weight-600">
                <span class="h3 font-weight-700" style="font-size:16px"> {{ str_replace("_"," ",env('APP_NAME'))}} </span> <br/>
                <span style="font-size:12px"> {{ str_replace("_"," ",env('SUB_APP_NAME'))}}  </span><br/>                
           <!--  </td>

            <td class="text-capitalize font-weight-600" style="font-size:12px">
                -->
                {{-- <span class="text-capitalize font-weight-600">Beside Unilorin Health Service Clinic </span>  <br/> --}}
                {{-- <span class="text-capitalize font-weight-600">P.M.B 1515, Ilorin </span>  <br/> --}}
                <span class="text-capitalize font-weight-600">Telephone : {{ str_replace("_"," ",env('APP_PHONE'))}} </span>  <br/>
                <span class="text-lowercase">e-Mail : {{ env('APP_EMAIL')}}  </span>  <br/>               
            </td>
        </tr>
        <tr>
            <td colspan="3" class="text-uppercase font-weight-700 text-center"><hr class="p-0 p-0 mt-0 mb-0"/>payment-Invoice <hr class="p-0 p-0 mt-0 mb-0"/></td>
        </tr>
        <tr style="font-size: 12px">

            <td colspan="3" class="text-uppercase font-weight-700">Ticket No:&nbsp;&nbsp;<span class="pull-right">{{$ticket_info->ticketno}} </span> <br/>
                Hosp. No:&nbsp;&nbsp; <span class="pull-right">{{ $ticket_info->appointment->patient->regno}}</span> <br/>
                name:&nbsp;&nbsp;  <span class="pull-right">{{ users_name($ticket_info->appointment->user_id )}}</span>  <br/>
                date:&nbsp;&nbsp;  <span class="pull-right">{{  Carbon::parse($ticket_info['updated_at'])->toDayDateTimeString(); }}</span> 
            </td>
        </tr>

        <tr>
            <td colspan="3" class="text-uppercase font-weight-700 text-center"> <hr class="p-0 p-0 mt-1 mb-0"/> bills  <hr class="p-0 p-0 mt-0 mb-0"/></td>
        </tr>        
        <tr style="font-size: 12px">
            <td colspan="3" class="text-capitalize font-weight-600 text-left">
                <small class="mt-0 text-center">Tests</small><br/>   
                @foreach($ticket_info->investigations as $k=>$investigation)
                    {{ $k+1 }} &nbsp;&nbsp;{{ $investigation->template->name }} : &nbsp;&nbsp;
                       <span class="pull-right"> {{ number_format($investigation->price) }} </span>
                    <br/>
                   @endforeach
                   <small>Prescriptions & Drugs</small><br/>
                   @foreach($ticket_info->prescriptions as $l=>$prescription)
                    {{ $l+1 }} &nbsp;&nbsp;{{ $prescription->item->name }} [{{ ucfirst($prescription->item_type)}}]&nbsp;*&nbsp;{{ $prescription->quantity}}  : &nbsp;&nbsp;
                       <span class="pull-right"> {{ number_format($prescription->total_price) }} </span>
                    <br/>
                   @endforeach
                   <small>Other Fees</small><br/>
                   
                  <?php $bills = get_general_bills($ticket_info->bill_type_ids) ?>
                   @foreach($bills as $k=>$bill)
                    {{ $k+1 }} &nbsp;&nbsp;{{ $bill->name }} Fee : &nbsp;&nbsp;
                       <span class="pull-right"> {{ number_format($bill->amount) }} </span>
                    <br/>
                   @endforeach
                   <hr class="p-0 p-0 mt-1 mb-1"/>
                   <strong>TOTAL COST:  <span class="pull-right">{{number_format($ticket_info->total_cost)}}</span> </strong>
                  
                   <hr class="p-0 p-0 mt-1 mb-1"/>
                  <strong> AMOUNT PAID :  <span class="pull-right">{{number_format($ticket_info->amount_paid)}}</span> </strong>
                   <br/> <small>{{ print_paymode($ticket_info->payment) }}  </small> <br/>

                   @if($ticket_info->refund > 0 )
                    Change : {{ number_format($ticket_info->refund) }}  <br/>
                   @endif

                   <strong>BALANCE : <span class="pull-right">{{ number_format(($ticket_info->total_cost - $ticket_info->amount_paid),2) }} </span> </strong><br/>
                   <!--<span class="text-uppercase">Payment Completed : <span class="pull-right font-weight-bold">{{ ($ticket_info->payment_completed) ? "Yes":"No" }}</span> </span> <br/>-->
                    <hr class="p-0 p-0 mt-1 mb-1"/>
                  <center> <?php $Collector ?>                  
                   
                  <!--Cashier: {{ admin_info(1)['fullname']}}--> 
                    
                  </center>

            </td>
        </tr>

    </table>
   </div>
</div>