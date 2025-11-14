<?php 
use App\Models\BillType; 
?>

<div class="row">  <hr/>
        <div class="col-md-6 float-left">
            <div class="form-row">
                <div class="col-md-12"> <form method="post" id="result_preloader" class="needs-validation" novalidate=""> @csrf 
                    <label  class="card-title">Select a Test </label>
                    <input type="hidden" id="ticket_no" name="ticket_no"  value="{{$ticket[0]['ticket_no']}}" />

                    <select name="bill_id" id="inputing-result-options" class="form-control" required="">
                        <option value="">...</option> 
                        @foreach($ticket[0]['specimen'] as $specimen)
                        <option value="{{$specimen['bill_type_id']}}">{{BillType::bill_name($specimen['bill_type_id'])}}</option> 
                        @endforeach
                    </select>  
                    <div class="invalid-feedback">
                        please select a specimen 
                    </div>
                    </form>
                </div>
            </div> <!-- ./ form-row --> 


        </div> <!-- ./ col-md-3 --> 


        <div class="col-md-12">
            <label class="card-title"> Compute The Result </label>
            <div class="card card-border border-gray-400">
                <div class="card-body">
                   <span class="ajaxLoader bg-dark h2 ladda-button " data-style="expand-right"></span>
                   <div class="result-body"></div>
                </div>
            </div>
        </div>

    </div><!-- ./ row --> 
