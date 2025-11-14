<?php
   use App\Models\BillType;
   ?>
<div class="row">
    <span class="card-title w-100 m-2 p-2"> Below are Completed Tickets : as at  {{$real_date ?? "" }} </span>
     @foreach($completedTickets as $ticket)
    <div class="col-md-6">
        <div class="main-card mb-3 card mt-3 card-border border-success">
            <div class="card-body">
                <h5 class="card-title">  {{users_name($ticket['customer_id'])}} :   {{$ticket['ticket_no']}}
                    <button type="button" data-toggle="collapse" href="#collapse-{{$ticket['id']}}"
                        class="btn pull-right btn-icon-only mt-0 pt-0" style="font-size: 16px"> <i class="pe-7s-menu pe-2x"></i></button> </h5>
                        <div class="collapse" id="collapse-{{$ticket['id']}}">
                           <h6> <u> Test Performed  </u> </h6>
                            @foreach($ticket['specimen'] as $specimen)
                            <div class="form-row">
                                <div class="col-md-12">

                                    <div class="mt-2 mb-2">
                                        <div class="custom-checkbox custom-control custom-control-inline font-weight-600" style="font-size:16px">
                                            <input type="checkbox" name="specimen_results_check[]" value="{{base64_encode($specimen['bill_type_id'])}}" id="custom_{{$specimen['id']}}" class="custom-control-input specimen_results_check" >
                                            <label class="custom-control-label" for="custom_{{$specimen['id']}}">
                                             {{BillType::bill_name($specimen['bill_type_id'])}}  </label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            @endforeach
                            <hr/>
                            <button onclick="print_results($(this).attr('for'))" for="{{base64_encode($ticket['ticket_no'])}}" class="btn btn-icon-only btn-light btn-lg" style="font-size:14px">PRINT &nbsp; <span class="pe-7s-print" ></span></button>
                            &nbsp;&nbsp;
                            <button onclick="download_results($(this).attr('for'))" for="{{base64_encode($ticket['ticket_no'])}}" class="btn btn-icon-only  btn-light btn-lg"  style="font-size:16px"> PDF &nbsp; <span class="pe-7s-file " style="font-size:16px"></span></button>
                            &nbsp;&nbsp;
                            @can('reverse-completed-ticket')
                            <button type="button" onclick="reverseTicket($(this).attr('for'))" for="{{base64_encode($ticket['ticket_no'])}}" class="reverse_ticket btn btn-icon-only  btn-danger btn-lg"  style="font-size:16px"> Reverse &nbsp; <span class="pe-7s-refresh-o " style="font-size:16px"></span></button>
                            @endcan
                    </div>
            </div>
        </div>
    </div>
    @endforeach

    @if(empty($completedTickets))
    <div class="col-md-12">
        <div class="card card-border border-dark">
            <div class="card-body bg-light font-weight-600 text-dark" style="font-size: 18px">
                No Completed  Ticket Was found  &nbsp;
            </div>
        </div>

    </div>
    @endif
</div>
