<form id="specimen_report_form" method="post" action="javascript:void(0)">@csrf
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-4 pb-4 card">
        <div class="card-title m-3 p-3"> <span class="font-1-5rem text-primary"> {{ $bill_info['name']}} </span> /  {{ $bill_info['category']['name'] }}   <br/>   report template  &nbsp; &nbsp; </div>
        <hr class="mb-0"/><!-- comment -->
        <div class="card-body">
            <div class="form-row">
                <input type="hidden" name="report_type" id="report_type" value="text" /> 
                <input type="hidden" name="ticket_no" id="ticket_no" value="{{$ticket_no}}" /> 
                <input type="hidden" name="bill_id" id="bill_id" value="{{$bill_id}}" /> 
                 
                <p class="font-weight-bold text-danger h4">&nbsp;&nbsp; No Result Template Found   </p>
                <a class="btn btn-primary btn-lg w-100 m-3 p-3 font-1rem" target="_blank" href="{{url('admin/bill-sample-template/'.$bill_id)}}"> <strong>Set It Up Now</strong>  </a>                   
            
            </div>
        </div>
        </div>
    </div>
</div>