<?php
use App\Models\BillType;
use Carbon\Carbon;
?>
<div class="row"><div class="col-md-12">
    <table class="table table-sm table-bordered border-dark rounded text-capitalize"  cellspacing="0" >
        <tr>
            <td><strong class="text-primary text-uppercase font-13 "> Requisition Number:</strong> {{""  }}</td>
            <td><strong class="text-primary text-uppercase font-13 "> Collection Date :</strong> {{ Carbon::parse($ticket_info[0]['date_collected'])->toFormattedDateString()}}</td>
        </tr><tr>
            <td><strong class="text-primary text-uppercase font-13 ">Request Date: </strong> {{ Carbon::parse($ticket_info[0]['request_date'])->toFormattedDateString()}}</td>
            <td><strong class="text-primary text-uppercase font-13 ">Report Date:</strong> {{Carbon::parse($ticket_info[0]['date_finalized'])->toFormattedDateString()}}</td>
        </tr>
        <tr>
            <td><strong class="text-primary text-uppercase font-13 ">Diagnosis:</strong>  {{$ticket_info[0]['clinical_details']}}</td>
            @php  $bills = []; @endphp
            <td><strong class="text-primary text-uppercase font-13 ">Tests Requested:</strong>  @foreach($ticket_info[0]['specimen'] as $specimen)
                @php $bills[] = $specimen['bill_type_id']  @endphp
                @endforeach
                @php  $billnames = array_map(fn($id)=>BillType::bill_name($id) , $bills)  @endphp
             {{ Arr::join($billnames,', ',' and ') }}</td>
        </tr>

    </table>
   </div>
</div>