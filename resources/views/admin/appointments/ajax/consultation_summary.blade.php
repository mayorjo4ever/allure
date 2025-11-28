<?php use App\Models\Questionnaire;  use App\Models\InvestigationTemplate; ?>
<div class="row">
   @if(!empty($appointment->consultation))
    <div class="col-md-12">
        <h4  class="card-title bg-light p-2">Notes / Comment</h4>      
            {!! $appointment->consultation->complaint !!}
            &nbsp;&nbsp;
            <span data-toggle="modal" data-target="#write-doctors-report" class="pointer text-primary" onclick="repopcomment($(this).attr('dataText'))" dataText="{{$appointment->consultation->complaint}}">Modify &nbsp; <span class="pe pe-7s-pen pe-2x"></span></span>
    </div>
   @else -- No Comment --
   @endif
</div>

<div class="row mt-5">
    <div class="col-md-12">
        <h4 class="card-title bg-light p-2">Questionnaires</h4>  
        @if(!empty($appointment->questions->toArray())) <?php $i = 1; ?>
         @foreach($appointment->questions as $question)
         <?php $q = Questionnaire::find($question->questionnaire_id);   ?>
          <div class="col-md-12 mb-3 mt-3">
            <p class="h6 font-weight-600">{{$i}}. {{$q->question}}</p>
                       
               @if($q->type=="choice")
               <?php $ans = $question->answer; $decode =  json_decode($ans,true); ?>
               <ul class="ml-3">
               @foreach($decode as $ans)
               <li>{{$ans[0]}}</li>
                @endforeach
                </ul> 
               @else 
               <span class="ml-4">Ans: <strong> {{ucwords($question->answer)}} </strong></span>
               @endif
           
          </div>
     
         
         <?php $i++; ?>
         @endforeach
        @else -- No Questionnaire --
        @endif
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-12">
        <h4 class="card-title bg-light p-2">Investigations </h4>  
        @php $invest_fee = 0; @endphp
          @if(!empty($appointment->investigations->toArray())) <?php $i = 1; ?>
          <i>The following test(s) are to be carried out </i>
          
          @foreach($appointment->investigations as $investigation)
          <div class="col-md-12 mb-3 mt-3">
              <p>
                {{$i}} -   {{investigation_name($investigation->investigation_template_id) }}
                &nbsp; <i>(&#8358; {{number_format($investigation->price)}}) </i>
                @php $invest_fee += $investigation->price; @endphp
                &nbsp; &nbsp; &nbsp; <button onclick="load_investigation_result('{{$investigation->id}}')"  data-toggle="modal" data-target="#view-investigation-result"  class="btn btn-sm @if(!empty($investigation->results->toarray())) btn-outline-success @else btn-outline-warning @endif "> View Result </button>
              </p>                         
          </div>
          <?php $i++; ?>
          @endforeach
          <p><strong> Total Fees : &nbsp; &nbsp;&#8358; {{number_format($invest_fee)}}</strong></p>
          <input type="hidden" name="invest_fee" id="invest_fee" value="{{$invest_fee}}">
          @else 
            -- No Investigations --
          @endif
    </div>
</div>
  
<div class="row mt-5">
    <div class="col-md-12">
        <h4 class="card-title bg-light p-2">Prescriptions </h4>  
         @php $drug_fee = 0; @endphp
         @if(!empty($appointment->prescriptions->toArray()))  <?php $i = 1; ?>
         <strong><i> Summary List of Prescribed Drugs, Lenses and Usage </i></strong>
         <table class="table table-sm">
             <tr>
                 <th>SN</th>
                 <th>ITEM</th>
                 <th>TYPE</th>
                 <th>QTY</th>
                 <th>UNIT PRICE</th>
                 <th>TOTAL PRICE</th>
                 <th>DOSAGE</th>
             </tr> 
         @foreach($appointment->prescriptions as $prescription)
           <tr>
                 <td> {{$i}}</td>
                 <td>{{$prescription->item->name  }}</td>
                 <td> {{ucwords($prescription->item_type)}} </td>
                 <td> {{ $prescription->quantity }} </td>
                 <td>&#8358; {{ number_format($prescription->unit_price) }}</td>
                 <td><strong>&#8358; {{number_format($prescription->total_price)}} </strong> </td>                 
                 <td>{{$prescription->dosage  }}</td>
                 @php $drug_fee += $prescription->total_price; @endphp
           </tr>                  
          <?php $i++; ?>
          @endforeach
          <tr class="font-weight-bold">
              <td align="right " colspan="5">Total Fees :</td>
              <td colspan="2">&#8358;  {{number_format($drug_fee) }}</td>              
          </tr>
         </table>
         <input type="hidden" name="drug_fee" id="drug_fee" value="{{$drug_fee}}">
         @else 
            -- No Prescriptions --
          @endif
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-12">
        <h4 class="card-title bg-light p-2">FINAL SUBMISSION </h4>  
        <p><strong>Include any other fees and submit / close the appointment </strong></p>
       @php
            $my_bill_ids = [];
            if (!empty($appointment->bills) && !empty($appointment->bills->bill_type_ids)) {
                $my_bill_ids = explode(',', $appointment->bills->bill_type_ids);
            }
        @endphp
        
        @foreach($billings as $bill) 
        <div class="checkbox-wrapper-13 mb-3">
            <input onclick="calc_other_bills()" id="c1-{{$bill->id}}" value="{{$bill->id}}" data-amount="{{$bill->amount}}" class="bills"  type="checkbox" name="bills[]"  @checked(in_array($bill->id, $my_bill_ids)) >
            <label for="c1-{{$bill->id}}"> {{$bill->name}}&nbsp;Fee &nbsp; <strong> ( &#8358; {{number_format($bill->amount)}} )</strong> </label>
          </div>
        @endforeach
    </div> 
    <p><pre>
       
        </pre>
    </p>
    <p class="bg-light font-weight-600 p-2">
        <input id="init_fee" type="hidden" value="{{$invest_fee + $drug_fee}}" />
        Investigations + ( Drugs + Lenses ) &nbsp; <span title=" Investigations ">{{number_format($invest_fee)}} </span> +  <span title="Drugs / Lenses "> {{ number_format($drug_fee)}} </span>  <span class="appendix"></span> =  <span class="final_total"> {{number_format($invest_fee + $drug_fee) }} </span>
    </p>
    
    <button  onclick="closeAppointment()" class="btn btn-primary btn-lg p-3 w-100 font-1-5rem font-weight-bold" > Close and Schedule Payment of : &#8358; <span class="final_total"> {{number_format($invest_fee + $drug_fee) }} </span> </button>
    
</div>
        