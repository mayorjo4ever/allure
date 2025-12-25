
<p class="text-uppercase font-weight-600 pt-4" style="border: 0;"> 
    <span class="h6 font-weight-700" style="font-size:16px">Receiving Bank Account: &nbsp;&nbsp;&nbsp; <strong> {{$account->bank}}</strong></span><br/>
    <span class="h6 font-weight-700" style="font-size:16px"> Account Name: &nbsp;&nbsp;&nbsp;<strong> {{ $account->name}}</strong></span><br/> 
    <span class="h6 font-weight-700" style="font-size:16px"> Account NO: &nbsp;&nbsp;&nbsp;<strong>{{ $account->number}}</strong></span><br/>    
</p>


<div class="form-row mt-2">
<!--    <div class="col-md-12 mb-3 font-weight-700">
        Pathologist comment :
    </div>-->
    <div class="col-md-6 mb-3 font-weight-600">
       Signature :  <img style="height:90px" src="{{public_path('template/arch/assets/images/lorllyb.jpg')}}" />
    </div>
     
</div>

