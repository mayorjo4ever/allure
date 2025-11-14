<?php
use App\Models\BillType;
use Carbon\Carbon;
?>
<div class="row">
        <div class="col-md-12 mb-4">
            <label class="card-title"> Customer Information </label>
            <div class="card card-border border-gray-400">
                <div class="card-body">
                    <div class="table">
                        <table class="table table-bordered">
                            <tr>@php $myinfo = users_info($ticket[0]['customer_id']); $today = $ticket[0]['date_collected'];
                                @endphp
                                <td>Name:</td>
                               <td class="font-weight-700">{{$myinfo['fullname']}}</td>
                                <td>Hospital Number:</td>
                                <td class="font-weight-700">{{$myinfo['regno']}}</td>
                                <td>Lab Number:</td>
                                <td class="font-weight-700">{{$ticket[0]['ticket_no']}}</td>
                                <td>Age:</td>
                                <td class="font-weight-700">{{ calc_age($myinfo['dob'],$today) }}</td>
                            </tr>
                            <tr>
                                <td colspan="1" >Date Applied: </td>
                                <td colspan="3" class="font-weight-700">{{Carbon::parse($ticket[0]['request_date'])->toFormattedDateString()}}</td>
                                <td colspan="2" >Specimen(s) Collected On:</td>
                                <td colspan="2" class="font-weight-700">{{ Carbon::parse($ticket[0]['date_collected'])->toFormattedDateString()}}</td>
                            </tr>
                            <tr>
                                <td colspan="1" >Ward / Clinic / Hospital </td>
                                <td colspan="3" class="font-weight-700">{{ empty($ticket[0]['hospital'])?"--": $ticket[0]['hospital'] ." / ".$ticket[0]['doctor'] }}</td>

                                <td colspan="1" >Doctor's Remark </td>
                                <td colspan="3" class="font-weight-700">{{ empty($ticket[0]['clinical_details'])?"--":$ticket[0]['clinical_details'] }}</td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
        </div> <!-- ./ col-md-12 -->

    </div><!-- ./ row -->


<div class="row">
        <div class="col-md-12">
            <label class="card-title"> Investigations </label>
            @php $analysis = ""; @endphp  <!--  compute to check finalizing report-->
            @foreach($ticket[0]['specimen'] as $specimen)
            @php $analysis .= $specimen['process_completed']."|";   @endphp
             <div class="card card-border border-gray-400 mb-4">
                <div class="card-body">
                   <div class="table">
                    <table class="table table-bordered">
                        <tr class="bg-secondary text-white font-weight-700">
                            <td>Test Performed :</td>
                            <td>Specimen Sample:</td>
                            <td>Result Computed:</td>
                            <td>Computed By : </td>
                            <td>Date Performed  : </td>
                        </tr>
                        <tr>
                           <td class="font-weight-600">{{ BillType::bill_name($specimen['bill_type_id'])}}</td>
                            <td class="font-weight-600">{{$specimen['specimen_sample']}}</td>
                            <td class="text-capitalize font-weight-600">{{ $specimen['process_completed']}} &nbsp; &nbsp; <span class="{{ ($specimen['process_completed']=="yes")?"pe-7s-check text-success":"pe-7s-attention text-danger" }} pe-2x"></span></td>
                            <td>
                            @if(!empty($specimen['result_uploaded_by'])) {{ admin_info($specimen['result_uploaded_by'])['fullname']}} @endif
                            </td>
                            <td class=""><div class="input-group">
                                <input type="text" class="form-control bg-white datepicker" value="{{$specimen['date_perform']}}" />
                                <button onclick="save_spec_perform_date('{{$specimen['id']}}',$(this).closest('tr td').find('input.datepicker'),'.perform-date-btn-{{$specimen['id']}}')" title="Update Date Performed" class="btn btn-success perform-date-btn-{{$specimen['id']}} ladda-button" data-style="expand-right"><i class="pe-7s-play text-white font-weight-700"></i></button>
                                </div>
                            </td>
                        </tr>
                        @can('make-pathologist-coment')
                        <tr class="bg-secondary text-white font-weight-700">
                             <td colspan="6">Pathologist Comment</td>
                        </tr>
                        <tr>
                            <td colspan="6" class="font-weight-700 ">
                               <textarea name="" rows="3" cols="20" class="form-control w-75 mb-3" placeholder="Make Comment About the Result"></textarea>
                               <button  onclick="save_spec_path_comment('{{$specimen['id']}}',$(this).closest('tr td').find('textarea'),'.pathologist-comment-btn-{{$specimen['id']}}')" class="btn btn-primary btn-lg w-50 font-weight-700 pathologist-comment-btn-{{$specimen['id']}} ladda-button" data-style="expand-right" type="button"> Make Comment &nbsp; <i class="pe-7s-comment text-white font-weight-700"></i></button>
                           </td>
                        </tr>
                        @endcan
                    </table>
                </div>
            </div>
          </div> <!-- ./ card -->
         @endforeach
        </div> <!-- ./ col-md-12 -->

        @can('finalize-results')
        <div class="col-md-12">
            <label class="font-weight-600">Select Result Finalization Date  </label>
            <input name="date-fin" id="date-fin" type="text" class="form-control datetimepicker bg-white w-50 mb-3" value="{{$ticket[0]['date_finalized'] ?? Carbon::now()}}" />
            <button id="finalize_test_process" class="btn btn-primary btn-lg pt-3 pb-3 w-100 font-weight-700 ladda-button" data-style="expand-right" for="{{$ticket[0]['ticket_no']}}" data-text="{{$analysis}}" onclick="finalize_test_process($(this).attr('for'),$(this).attr('data-text'))" > FINALIZE RESULT </button>
        </div>@endcan
    </div><!-- ./ row -->
