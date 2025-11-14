    <?php
        use App\Models\BillType;
        use Carbon\Carbon;
    ?>
<form method="post" id="complete-customer-ticket" action="javascript:void(0)">@csrf
    <div class="row">
    <div class="col-md-6">

    <span class="font-weight-700 mb-3 text-uppercase">
        FINALIZE TICKET FOR # {{$ticket[0]['user']['regno']." - ".  $ticket[0]['user']['surname']." ". $ticket[0]['user']['firstname']." "      }}
    </span>
    <p><label class="font-weight-600 pt-3 text-uppercase">Bill Summary   </label></p>
    <div class="card card-border border-info">
        <div clas="card-body">
    <table class="table table-hover w-100 table-sm">
        <thead>
            <tr class="font-weight-700 text-uppercase">
                <td>S/N</td>
                <td>Name</td>
                <td>Specimen</td>
                <td>Price</td>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
             @foreach($ticket[0]['specimen'] as $k=>$specimen)
             <tr class="font-weight-600">
                <td>{{$k+1}}</td>
                <td>{{BillType::bill_name($specimen['bill_type_id'])}}</td>
                <td>{{$specimen['specimen_sample']}}</td>
                <td>{{number_format($specimen['bill_price'])}}</td>
                @php $total += $specimen['bill_price'] @endphp
            </tr>
            @endforeach
            <tr style="font-size: 18px; font-weight: 600">
                <td colspan="5" class="text-center ">TOTAL :  N {{ number_format($total) }}</td>
            </tr>
        </tbody>
    </table>
       </div>
    </div>
    </div><!-- col-md-6 -->

    <div class="col-md-6">
        <span class="font-weight-700 mb-3 text-uppercase">
        Other medical information
    </span>

        <div class="form-row pt-3">
            <div class="col-md-12 mb-3">
                <input type="hidden" name="user_id" value="{{$ticket[0]['user']['id']}}"/>
                <input type="hidden" name="ticket_id" value="{{$ticket[0]['id']}}"/>
                <label class="font-weight-600 text-uppercase"> Ward / Clinic / Hospital </label>
                <input type="text" class="form-control" name="hospital" id="hospital" />
            </div>
            <div class="col-md-6 mb-3">
                <label class="font-weight-600 text-uppercase">Requesting Doctor's Name:  </label>
                <input type="text" class="form-control" name="doctor" id="doctor" />
            </div>
             <div class="col-md-6 mb-3">
                <label class="font-weight-600 text-uppercase">Consultant's Name:  </label>
                <input type="text" class="form-control" name="consultant" id="consultant" />
            </div>
             <div class="col-md-12 mb-3">
                <label class="font-weight-600 text-uppercase">Diagnosis and Clinical Details : <span class="h6">Including Antibiotics Treatment</span>  </label>
                <input type="text" class="form-control" name="medical_report" id="medical_report" />
            </div>
            <div class="col-md-6 mb-3">
                <label class="font-weight-600 text-uppercase">Request Date:  </label>
                <input type="text" class="form-control datetimepicker bg-white" name="request_date" id="request_date"  value="{{Carbon::now()}}"/>
            </div>
             <div class="col-md-6 mb-3">
                <label class="font-weight-600 text-uppercase">Date Collected:  </label>
                <input type="text" class="form-control datetimepicker bg-white" name="date_collected" id="date_collected" value="{{ Carbon::now() }}" />
            </div>
        </div>

    </div><!-- col-md-6 -->
    </div><!-- row -->
    <div class="row">
        <div class="col-md-12">
            <button  onclick="complete_customer_ticket()" type="submit" class="btn btn-info btn-lg w-100 font-weight-700 complete-customer-ticket-btn ladda-button" data-style="expand-right"> Create Ticket </button>
        </div>

    </div>
    </form>
