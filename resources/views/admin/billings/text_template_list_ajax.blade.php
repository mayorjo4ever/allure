  
  <div class="card-header">  Result Parameters
        <div class="btn-actions-pane-right">
           <div role="group" class="btn-group-sm btn-group">
               <button onclick="showInactiveTables()" class="active btn btn-focus btn-success">Show Deleted Sample List</button>
               &nbsp; &nbsp;     <button onclick="hideInactiveTables()" class="btn btn-focus btn-danger">Hide Deleted  Sample List</button>
           </div>
       </div>  
   </div>

    <div class="row  mt-2 pt-2 ">    
        <div class="col-md-12">
           @foreach($bill_sample['template'] as $templist)
           <div class="table table-responsive">
               <table class="table w-100 table-hover">
                   <tr class="{{ ($templist['status']==1) ?"active":"inactive" }}">
                       <td># {{$templist['id']}}</td>
                       <td>{!!$templist['raw_text_val']!!}</td>
                     @can('edit-bill-template') <td>
                    <a class="" bill_categ_id="{{ $templist['id']}}" href="{{url('admin/bill-sample-template/'.$bill_sample['id'].'/'.$templist['id']) }}">
                        <i class="pe-7s-pen pe-2x text-danger" status="active"></i> Edit </a>                  
                     </td>
                     <td>
                         @if($templist['status']==1)
                               <a class="updateBillTemplateChildStatus" id="templist_id-{{ $templist['id']}}" templist_id="{{ $templist['id']}}" href="javascript:void(0)">
                                   <i class="pe-7s-check pe-2x font-weight-bold text-success " status="active"></i> Active </a>
                              @else <a class="updateBillTemplateChildStatus" id="templist_id-{{ $templist['id']}}" templist_id="{{ $templist['id']}}" href="javascript:void(0)">
                                 <i class="pe-7s-attention pe-2x  text-danger font-weight-bold"  status="inactive"></i> Deleted </a>
                             @endif    &nbsp; &nbsp; <span class="templist_id-{{ $templist['id']}} ladda-button text-dark bg-dark" data-style="expand-right"></span>
                  
                     </td>   @endcan
                       <td> {{ \Carbon\Carbon::parse($templist['updated_at'])->diffForHumans()}} (Last updates)</td>
                   </tr>
               </table>
           </div>                 
           @endforeach
            
            
        </div>
        <div class="col-md-3">
           
        </div>
    </div>