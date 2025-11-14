<?php
use App\Models\BillType;
use Carbon\Carbon;
?>
<div class="row"><div class="col-md-12">
    <table class="table table-sm table-bordered border-dark rounded text-capitalize">
        <tr>
            <td><strong class="text-primary text-uppercase font-13 "> Requisition Number:</strong> &nbsp;&nbsp;{{""  }}</td>
            <td><strong class="text-primary text-uppercase font-13 "> Collection Date :</strong> &nbsp;&nbsp;{{ Carbon::parse($ticket_info[0]['date_collected'])->format('D, M j, Y g:i A') }} <!-- ->toDateTimeString() --></td>
        </tr><tr>
            <td><strong class="text-primary text-uppercase font-13 ">Request Date: </strong> &nbsp;&nbsp;{{ Carbon::parse($ticket_info[0]['request_date'])->format('D, M j, Y g:i A') }} <!-- ->toDateTimeString()--></td>
            <td><strong class="text-primary text-uppercase font-13 ">Report Date:</strong> &nbsp;&nbsp;{{Carbon::parse($ticket_info[0]['date_finalized'])->format('D, M j, Y g:i A')}} <!-- ->toFormattedDayDateString() --></td>
        </tr>
        <tr>
            <td><strong class="text-primary text-uppercase font-13 ">Diagnosis:</strong> &nbsp;&nbsp; {{$ticket_info[0]['clinical_details']}}</td>
            @php  $bills = []; @endphp
            <td><strong class="text-primary text-uppercase font-13 ">Tests Requested:</strong> &nbsp;&nbsp; @foreach($ticket_info[0]['specimen'] as $specimen)
                @php $bills[] = $specimen['bill_type_id']  @endphp
                @endforeach
                @php  $billnames = array_map(fn($id)=>BillType::bill_name($id) , $bills)  @endphp
             {{ Arr::join($billnames,', ',' and ') }}</td>
        </tr>

    </table>
   </div>
</div>