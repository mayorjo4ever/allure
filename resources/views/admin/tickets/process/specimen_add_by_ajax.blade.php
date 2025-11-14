<?php
    use App\Models\BillType;
?>
<form id="ticket_specimen_add_2" action="javascript:void(0)" method="post">@csrf

    <div class="row">
    <div class="col-md-12">
        <div class="card card-border border-primary">
           <div class="card-body"> <span class="h6 card-title">Add This Specimen More </span>

               <div class="table table-responsive">
                   <table class="table w-100">
                       <tbody>
                           <input type="hidden" name="user-id" id="user-id" class="form-control" value="{{$user['id']}}" />
                           <input type="hidden" name="bill-id" id="bill-id" class="form-control" value="{{$bill['id']}}" />
                           <input type="hidden" name="ticket_no" id="ticket_no" class="form-control" value="{{$ticket[0]['ticket_no'] }}" />
                           <tr>
                               <td> Name  </td>
                               <td> Specimen Sample </td>
                               <th class="text-capitalize">Unit Price  </th>
                               @if($bill['for_sale']==1)
                               <th> Final Price </th>
                               <th> Qty </th>
                               @endif
                               <td> Action  </td>
                           </tr>
                           <tr class="font-weight-600">
                               <td> {{$bill['name']}}   </td>
                               <td> <input type="text" id="specimen_sample" name="specimen_sample"  class="form-control" style="width:120px" value="{{$bill['specimen_sample']}}" />  </td>
                               <td> &#8358; {{ number_format($bill[$whom.'_price'])}}
                                   <input type="hidden" name="price" id="price" value="{{$bill[$whom.'_price']}}" />
                               </td>
                                @if($bill['for_sale']==1)
                                <td> &#8358; <span class="final_price">{{ number_format($bill[$whom.'_price'])}}</span>
                                   <input type="hidden" name="final_price" id="final_price" value="{{$bill[$whom.'_price']}}" />
                                </td>
                               <td> 
                                   <input onkeyup="control_product_price()" class="form-control" type="number" name="qty_buy" id="qty_buy" value="{{1}}" min="1" max="{{$bill['qty_rem']}}" />&nbsp; <small> Rem : {{$bill['qty_rem']}}</small>
                               </td>
                               @endif
                               
                               <td> <button type="submit" class="btn btn-success btn-lg add-specimen-btn-2 ladda-button" data-style="expand-right">Add Bill </button>  </td>
                           </tr>
                       </tbody>
                   </table>

               </div>


               @if(!empty($ticket))

               <hr class="mt-4"/>

               <table class="table table-hover w-100">
                   <thead>
                       <tr><td colspan="5" class="table-dark font-weight-700"> LIST OF SAVED BILLS </td></tr>
                       <tr class="font-weight-700 text-uppercase">
                           <td>S/N</td>
                           <td>Name</td>
                           <td>Specimen</td>
                           <td>Price</td>
                          @can('delete-ticket-bill') <td>Action </td>@endcan
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
                           @can('delete-ticket-bill')
                           <td>
                               <a class="confirmDelete" onclick="confirmDelete($(this).attr('module'),$(this).attr('moduleid'),$(this).attr('title'))" title=" {{BillType::bill_name($specimen['bill_type_id'])}}" module="ticket-bill" moduleid="{{ $specimen['id']}}" href="javascrpt:void(0)">
                                <i class="pe-7s-trash pe-2x text-danger" ></i></a>
                           </td>   @endcan
                           @php $total += $specimen['bill_price'] @endphp
                       </tr>
                       @endforeach
                       <tr style="font-size: 18px; font-weight: 600">
                           <td colspan="1">TOTAL </td>
                           <td colspan="4">{{ number_format($total) }}</td>
                       </tr>
                   </tbody>
               </table>

               <div class="form-row">
                   <div class="col-md-6">
                       <button onclick="location.reload()" class="btn btn-info w-75 btn-lg font-weight-700 "  {{($total == 0)?"disabled":"" }}  >  Finalize Bill </button>
                   </div>
               </div>
               @endif
           </div>
        </div>
    </div>

</div>
</form>
