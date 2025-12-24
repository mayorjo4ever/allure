<div class="form-row mt-2">
<!--    <div class="col-md-12 mb-3 font-weight-700">
        Pathologist comment :
    </div>-->
    <div class="col-md-6 mb-3 font-weight-600">
       Signature :  <img style="height:90px" src="{{public_path('template/arch/assets/images/lorllyb.jpg')}}" />
    </div>
     <div class="col-md-6 mb-3 font-weight-600">
       Date Printed : {{ \Carbon\Carbon::now()->toDayDateTimeString() }}
    </div>
</div>
