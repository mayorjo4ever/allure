<?php 
use App\Models\BillType; 
use Carbon\Carbon;
?>
<form id="specimen_report_form" method="post" action="javascript:void(0)">@csrf
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-4 pb-4 card">
        <div class="card-title m-2 p-2"> <span class="font-1-5rem text-primary"> {{ $bill_info['name']}} </span> /  {{ $bill_info['category']['name'] }}   <br/>   Approve The Sales  &nbsp; &nbsp; </div>
        <hr class="mb-0 mt-0"/><!-- comment -->
        <div class="card-body">
            <div class="form-row">
                <input type="hidden" name="report_type" id="report_type" value="for_sale" /> 
                <input type="hidden" name="ticket_no" id="ticket_no" value="{{$ticket_no}}" /> 
                <input type="hidden" name="bill_id" id="bill_id" value="{{$bill_id}}" /> 
                
                <div class="col-md-12 mb-3"> <?php $info = BillType::bill_info($bill_id);
                    $specimen = \App\Models\CustomerSpecimen::where(['ticket_no'=>$ticket_no,'bill_type_id'=>$bill_id])->first()->toArray(); 
                    $ticket = App\Models\CustomerTicket::where('ticket_no',$ticket_no)->first()->toArray();
                ?>
                    <table class="table jambo_table">
                        <tr class="font-weight-bold bg-dark text-white">
                            <td>Items</td>
                            <td>Unit Price</td>
                            <td>Qty</td>
                            <td>Total</td>
                            <td>Amount Paid</td>
                        </tr>
                        <tr class="font-weight-500">
                            <td>{{$info['name'] }}</td>
                            <td>&#8358; {{number_format($bill_info['adult_price'])}}</td>
                            <td>{{ $specimen['qty_buy']}}</td>
                            <td>&#8358; {{ number_format($specimen['bill_price'])}}</td>
                            <td>&#8358; {{ number_format($ticket['amount_paid'])}} / {{ number_format($ticket['total_cost'])}} </td>
                        </tr>
                    </table>
                </div>
                
                <div class="col-md-6 mt-3">
                    @if($specimen['process_completed']=="no")
                        <button type="submit" class="btn btn-primary btn-lg w-100 ladda-button font-weight-700 text-report-submit-btn" data-style="expand-right">Approve Sale </button>
                    @else
                        <button disabled="" type="submit" class="btn btn-success btn-lg w-100 ladda-button font-weight-700 text-report-submit-btn" data-style="expand-right">Already Sold</button>
                    @endif
                </div>
            </div>
        </div>
       </div>            
        </div>
    </div>
  </form>