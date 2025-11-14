<?php 
use App\Models\BillType; 
use Carbon\Carbon;
?>

<div class="row">  <hr/>
    <div class="col-md-12 float-left">
        <p class="card-title">Investigations </p>
       <form method="post" id="result_preloader" class="needs-validation" novalidate=""> @csrf 
           <table class="table table-bordered jambo-table">
               <thead>
                   <tr>
                       <th>S/N</th>
                       <th>Investigations</th>
                       <th>Cost</th>
                       <th>Requires Report</th>
                       <th>Result Computed</th>
                       <th>Take Action</th>
                   </tr>
               </thead>
               <tbody>                  
               <input type="hidden" id="ticket_no" name="ticket_no"  value="{{$ticket[0]['ticket_no']}}" />
               <input type="hidden" id="user-id" name="user-id"  value="{{$ticket[0]['customer_id']}}" />
               
               <?php $report_options = ['No','Yes']; ?>   
               
                @php $analysis = ""; @endphp  <!--  compute to check finalizing report-->
                
                  @foreach($ticket[0]['specimen'] as $k=>$specimen)
                     
                  @php $analysis .= $specimen['process_completed']."|";   @endphp
                     
                  <tr><?php $info = BillType::bill_info($specimen['bill_type_id'])?>
                     <td>{{($k+1)}}</td>
                     <td><strong>{{$info['name'] }} &nbsp; &nbsp;@if($info['for_sale']==1) ( {{ $specimen['qty_buy'] }} )  @endif </strong> </td> 
                       <td>N {{number_format($specimen['bill_price']) }}</td>
                        <td>{{ $report_options[$info['req_med_report']] }}</td>
                        <td class="text-capitalize bold"> 
                            <?php                             
                                  if($specimen['process_completed']=="yes"):
                                     echo " &nbsp; <span class='text-success pe pe-7s-check pe-2x'></span> Yes";
                                     else:
                                     echo " &nbsp; <span class='text-danger pe pe-7s-attention pe-2x'></span> No";
                                  endif;                               
                           ?>
                        </td>
                       <td>
                           <button type="button" class="btn process-investigation-report-btn btn-info font-1rem" bill_id="{{$specimen['bill_type_id']}}"> View &nbsp; <i class="pe pe-7s-thumb"></i> </button>
                           @can('delete-ticket-bill')
                           <button title="{{$info['name'] }}" data-text="{{base64_encode($ticket[0]['ticket_no'])}}" type="button" class="confirmBillDelete btn process-investigation-report-btn btn-danger font-1rem" bill_id="{{$specimen['bill_type_id']}}"> Remove &nbsp; <i class="pe pe-7s-trash"></i></button>
                           @endcan
                       </td>  
                   </tr>
                @endforeach 
                <tr class="">
                    <td colspan="3" class="font-weight-600 table-dark"><span class="pull-right">Payment Info</span></td>
                    <td colspan="3" class="font-weight-600 table-dark">  Paid : &#8358; {{number_format($ticket[0]['amount_paid'])}} /  &#8358; {{number_format($ticket[0]['total_cost'])}} </td>
                </tr>
               </tbody>
           </table>  
         </form> 
        </div> <!-- ./ col-md-12 --> 
       
        <div class="row ml-3"> 
        <div class="col-md-2">
            <button class="btn btn-warning btn-lg btn-block text-white" onclick=" location.reload()">  <i class="pe pe-7s-refresh-2 pe-2x"></i> <br/> <strong>Refresh</strong> </button>
        </div>
        
        <div class="col-md-3">
            <button class="btn btn-primary add-more-investigation-btn"><strong><i class="pe pe-7s-plus pe-2x"></i> <br/> Add More Investigations </strong> </button>
        </div>
         @can('finalize-results')
        <div class="col-md-4"> 
            <label class="font-weight-700">Select Date Finalized </label>
             <input name="date-fin" id="date-fin" type="text" class="form-control datetimepicker bg-white w-100 mb-3" value="{{$ticket[0]['date_finalized'] ?? Carbon::now()}}" />
        </div>
         <div class="col-md-3">             
         <button id="finalize_test_process" class="btn btn-success btn-lg pt-3 pb-3 w-100 font-weight-700 ladda-button" data-style="expand-right" for="{{$ticket[0]['ticket_no']}}" data-text="{{$analysis}}" onclick="finalize_test_process($(this).attr('for'),$(this).attr('data-text'))" > <i class="pe pe-7s-check pe-2x"></i> <br/>  Finalize Ticket </button>
        </div>
         @endcan
         </div> <!-- ./ row -->
         
        <div class="col-md-12">
          <div class="card-body">
                   <span class="ajaxLoader bg-dark h2 ladda-button " data-style="expand-right"></span>
                   <div class="result-body"></div>
                </div>
        </div>

    </div><!-- ./ row --> 
