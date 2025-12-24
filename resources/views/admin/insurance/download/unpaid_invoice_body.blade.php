<p class="text-uppercase font-weight-600 mb-4" style="border: 0;"> 
    <span class="h6 font-weight-700" style="font-size:17px">INVOICE NO: <strong> {{$invoice_no}}</strong></span><br/>
    <span class="h6 font-weight-700" style="font-size:16px"> <strong> {{ $organization->name}}</strong></span><br/> 
    <span class="h6 font-weight-700" style="font-size:16px"> HMO NO:  <strong>{{ $organization->enrole_no}}</strong></span><br/>
    <span class="h6 font-weight-700" style="font-size:16px"> DATE: <strong> {{ \Carbon\Carbon::parse($organization->created_at)->toDayDateTimeString()}}</strong></span><br/>    
</p>

<div class="table-responsive pt-3">
    <table class="align-middle mb-0 table table-borderless">
        <thead>
        <tr>
            <th class="pl-4"># ID </th>              
            <th>Patient</th>                           
            <th>Bill Details</th>     
            <th>Total Cost</th>
        </tr>
        </thead>
        @php $bills = 0; $discounts = 0; @endphp 
        <tbody> @foreach($organ_invoice  as $k=>$invoice )
        <tr >
            <td class="text-muted pl-4"># {{ $k +1}} </td>               
            <td> Patient:&nbsp; <b>{{ $invoice->user->surname}} {{ $invoice->user->firstname}} </b>
                <br/>Regno:&nbsp; <b>{{ $invoice->user->regno}}</b> 
                <br/>HMO:&nbsp;<b>{{ $invoice->user->enrole_no}}</b> 
                <br/>Ticket No:&nbsp;<b>  {{ $invoice->bill->ticketno}} </b>
            </td>  

            <td><small>General Bills</small>
                 <ol class="mb-0 mt-0">
               <?php $hosp_bills = get_general_bills($invoice->bill->bill_type_ids) ?>
               @foreach($hosp_bills as $k=>$hosp_bill)
               <li> &nbsp;&nbsp;{{ $hosp_bill->name }} Fee : &nbsp;&nbsp;
                   <span class="pull-right"> {{ number_format($hosp_bill->amount) }} </span>
               </li>
               @endforeach
               </ol>
                @if(!empty($invoice->appointment->investigations->toarray()))
               <small class="mt-0 text-center">Investigations</small>
                <ol class="mb-0 mt-0">
                 @foreach($invoice->appointment->investigations as $k=>$investigation)
                <li> &nbsp;&nbsp;{{ $investigation->template->name }} : &nbsp;&nbsp;
                    <span class="pull-right"> {{ number_format($investigation->price) }} </span>                    
                </li>
               @endforeach
               </ol>
               @endif

               @if(!empty($invoice->appointment->prescriptions->toarray()))
                <small>Prescriptions, Drugs & Frames </small>
                <ol class="mb-0 mt-0">                       
                @foreach($invoice->appointment->prescriptions as $l=>$prescription)
                <li> &nbsp;&nbsp;{{ $prescription->item->name }} [{{ ucfirst($prescription->item_type)}}]&nbsp;*&nbsp;{{ $prescription->quantity}}  : &nbsp;&nbsp;
                    <span class="pull-right"> {{ number_format($prescription->total_price) }} </span>
                 </li>
                @endforeach                       
                </ol>
               @endif
            </td>
            <th>N{{number_format($invoice->amount)}}   </th>
        </tr>
          @php $bills+=$invoice->amount; $discounts +=$invoice->discount; @endphp 
          @endforeach
          <tr>
              <td class="text-uppercase p-3 m-1" colspan="4">Gross Total : &nbsp; <strong>N {{number_format($bills - $discounts)}}  </strong>  :  
                {{ number_to_words($bills - $discounts) }}
              </td>
          </tr>  
            </tbody>
    </table>
 </div>

<p class="text-uppercase font-weight-600 pt-4" style="border: 0;"> 
    <span class="h6 font-weight-700" style="font-size:16px">Receiving Bank Account: &nbsp;&nbsp;&nbsp; <strong> {{$account->bank}}</strong></span><br/>
    <span class="h6 font-weight-700" style="font-size:16px"> Account Name: &nbsp;&nbsp;&nbsp;<strong> {{ $account->name}}</strong></span><br/> 
    <span class="h6 font-weight-700" style="font-size:16px"> Account NO: &nbsp;&nbsp;&nbsp;<strong>{{ $account->number}}</strong></span><br/>    
</p>
