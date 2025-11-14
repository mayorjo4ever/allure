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
                
                <div class="col-md-12 mb-3">
                    <label class="text-primary font-weight-600 mb-3"> MODIFY THIS  TEMPLATE ACCORDING TO THE RESULT GOTTEN </label>
                    <textarea id="result_text" name="result_text" class="form-control form-control-plaintext">
                        @if(!empty($result_info[0]['results']))
                            {{ $result_info[0]['results'][0]['raw_text_val']}}
                         @else 
                             {{ $bill_info['template'][0]['raw_text_val'] }}
                        @endif
                    </textarea>
                </div>
                <div class="col-md-12 mb-3"> <!-- comment -->
                    <label class="font-weight-600">General Comment </label>
                    <input type="text" name="text_comment" id="text_comment" value="{{$result_info[0]['results'][0]['comment'] ?? ""}}" class="form-control comment" placeholder="comment" />
                </div>
                <div class="col-md-6 mt-3">
                    <button type="submit" class="btn btn-primary btn-lg w-100 ladda-button font-weight-700 text-report-submit-btn" data-style="expand-right">Submit Report </button>
                </div>
            </div>
        </div>
       </div>            
        </div>
    </div>
  </form>