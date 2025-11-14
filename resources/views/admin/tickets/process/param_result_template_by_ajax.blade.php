<form id="specimen_report_form" method="post" action="javascript:void(0)">@csrf
 <div class="row">
    <div class="col-md-12">
        <div class="main-card mb-4 pb-4 card">
            <div class="card-title m-3 p-3"> <span class="font-1-5rem text-primary"> {{ $bill_info['name']}} </span> /  {{ $bill_info['category']['name'] }}   <br/>   report template  &nbsp; &nbsp; </div>
        <hr class="mb-0"/><!-- comment -->
        <div class="card-body">
            <div class="form-row">
                <input type="hidden" name="report_type" id="report_type" value="param" />
                <input type="hidden" name="ticket_no" id="ticket_no" value="{{$ticket_no}}" />
                <input type="hidden" name="bill_id" id="bill_id" value="{{$bill_id}}" />
                <i class="pe-7s-comment pe-2x text-primary"></i> &nbsp;  &nbsp;
                   <span class="text-primary mb-4 h6">Note : You can deselect any of the options that are not included in your result </span>
           </div>

            <div class="table">
                <table class="table table-bordered">
                    <thead class="table-dark text-uppercase">
                        <tr>
                            <th>SN</th>  <th>Name</th>
                            <th>Result</th>   <th>Unit</th>
                            <th>Ref. Value</th>  <th> For </th> <th> Comment </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bill_info['template'] as $k=>$template)
                        <tr class="text-capitalize">
                            <td><div class="custom-checkbox custom-control custom-control-inline  mb-1">
                                <input name="picks[]" value="{{$template['id']}}" type="checkbox" id="temp-{{$template['id']}}" {{ extract_checkbox($template['id'], $result_info[0]['results'])  }} onclick="highlight_check_rows()" class="custom-control-input checkboxes">
                                <label class="custom-control-label font-weight-600" for="temp-{{$template['id']}}"> pick </label>
                                </div></td>
                            <td>{{$template['name']}}</td>
                            <td><input type="text" name="spec_result[]" value="{{ extract_result($template['id'], $result_info[0]['results']) }}" class="form-control result" style="width:150px" /></td>
                            <td class="pt-3">{!! $template['unit']!!}</td>
                            <td>{{$template['ref_val']}}</td>
                            <td>{{$template['age_range']}} </td>
                            <td><input type="text" name="spec_comment[]" value="{{ extract_comment($template['id'], $result_info[0]['results'])  }}" class="form-control comment" placeholder="comment" /></td>
                        </tr>
                        @endforeach
                        @if(empty($bill_info['template']))
                        <tr><td colspan="7" class="text-warning font-weight-700 mt-3 pt-3 "> <span class="pe-7s-attention pe-2x"></span> &nbsp; &nbsp;  No Template Has been scheduled for this Test </td></tr>
                        @endif
                    </tbody>
                </table>
            </div><!-- comment -->
            <div class=""><!-- comment -->
                <span class="ajaxLoader bg-dark h2 ladda-button " data-style="expand-right"></span>
                <button onclick="save_param_specimen_result()" type="submit" class="btn btn-primary btn-lg w-100 ladda-button font-weight-700 param-report-submit-btn" data-style="expand-right">Submit Report </button>
            </div>
        </div>
    </div>
  </div>
</div>
</form>