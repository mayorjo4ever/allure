<?php
use App\Models\BillType;
use Carbon\Carbon;
?>
<div class="form-row mt-2">
<!--    <div class="col-md-12 mb-3 font-weight-700">
        Pathologist comment :
    </div>-->
    <div class="col-md-6 mb-3 font-weight-600">
       Signature :  <img style="height:90px" src="{{asset('template/arch/assets/images/lorllyb.jpg')}}" />
    </div>
     <div class="col-md-6 mb-3 font-weight-600">
       Date : {{$ticket_info[0]['date_finalized']}}
    </div>
</div>

