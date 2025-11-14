<?php
use App\Models\BillType;
use App\Models\CustomerSpecimenResult; 
?>
@foreach($ticket_info[0]['specimen'] as $specimen)
<div class="row"> 
    @php $bill_info = BillType::with('template')->where('id',$specimen['bill_type_id'])->get()->toArray()  @endphp 
    <div class="col-md-12"> <p class="h6 p-1 table-light w-100 font-weight-600">  {{$bill_info[0]['name']}}  - Result </p> </div><!-- col-md-12 -->
        <div class="col-md-12">
             <?php  ?>
            @if($bill_info[0]['template_type']=="param_form")
               @php  $results = CustomerSpecimenResult::with('template')->where(['ticket_no'=>$specimen['ticket_no'],'bill_type_id'=>$specimen['bill_type_id']])->get()->toArray(); @endphp
               <div class="table">
                   <table class="table table-sm table-bordered">
                       <tr class="font-weight-600 bg-light text-uppercase">
                           <td>S/N</td>
                           <td>Name</td>
                           <td>Result</td>
                           @if($results[0]['template']['has_ref_val']==1)<td>Range</td>@endif
                           @if($results[0]['template']['has_unit']==1)<td>Unit</td>@endif
                           <!-- <td>comment</td> -->
                       </tr>
                       @foreach($results as $k=>$result) 
                         <tr>
                           <td>{{$k+1}}</td>
                           <td>{{$result['template']['name']}}</td>
                           <td>{{$result['result']}}</td>
                           @if($results[0]['template']['has_ref_val']==1)<td>{{$result['template']['ref_val']}}</td>@endif
                           @if($results[0]['template']['has_unit']==1)<td>{!! $result['template']['unit'] !!}</td>  @endif                         
                           <!-- <td>{!! $result['comment'] !!}</td>                                                       -->
                       </tr> 
                       @endforeach
                   </table> 
               </div> 
            @else
            @php  $result = CustomerSpecimenResult::where(['ticket_no'=>$specimen['ticket_no'],'bill_type_id'=>$specimen['bill_type_id']])->get()->toArray();                    
                 @endphp
              
                {!! $result[0]['raw_text_val'] !!}
             
            @endif
           
        </div><!-- col-md-12 -->
</div><!-- row -->
@endforeach