 
<div class="card-header">  Result Parameters
        <div class="btn-actions-pane-right">
           <div role="group" class="btn-group-sm btn-group">
               <button onclick="showInactiveTables()" class="active btn btn-focus btn-success">Show Deleted Sample List</button>
               &nbsp; &nbsp;     <button onclick="hideInactiveTables()" class="btn btn-focus btn-danger">Hide Deleted  Sample List</button>
           </div>
       </div>  
   </div>
    <div class="table-responsive  mt-2 pt-2 ">    
        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
            <thead>
            <tr>
                <th class="pl-4"># ID </th> 
                <th>Result Name</th>
                <th>To Whom </th>
                <th>Unit </th>
                <th>Reference Value </th>                
                @can('edit-bill-types')<th >Status <br><small>Delete / Restore </small> </th> @endcan  
                <th> Action <br><small>Update Contents  </th>
                <th>Last Updated </th>
            </tr>
            </thead>
            
            <tbody>
                @foreach($bill_sample['template'] as $templist)
                <tr class="{{ ($templist['status']==1) ?"active":"inactive" }}">
                    <td># {{$templist['id']}}</td>
                    <td>{{$templist['name']}}</td>
                    <td class="text-capitalize">{{$templist['age_range']}}s</td>
                    <td>{!! $templist['unit']!!}</td>
                    <td>{{$templist['ref_val']}}</td>
                   @can('edit-bill-template')<td>
                     @if($templist['status']==1)
                               <a class="updateBillTemplateChildStatus" id="templist_id-{{ $templist['id']}}" templist_id="{{ $templist['id']}}" href="javascript:void(0)">
                                   <i class="pe-7s-check pe-2x font-weight-bold text-success " status="active"></i> Active </a>
                              @else <a class="updateBillTemplateChildStatus" id="templist_id-{{ $templist['id']}}" templist_id="{{ $templist['id']}}" href="javascript:void(0)">
                                 <i class="pe-7s-attention pe-2x  text-danger font-weight-bold"  status="inactive"></i> Deleted </a>
                             @endif    &nbsp; &nbsp; <span class="templist_id-{{ $templist['id']}} ladda-button text-dark bg-dark" data-style="expand-right"></span>
                   </td> @endcan
                   @can('edit-bill-template') <td>
                    <a class="" bill_categ_id="{{ $templist['id']}}" href="{{url('admin/bill-sample-template/'.$bill_sample['id'].'/'.$templist['id']) }}">
                        <i class="pe-7s-pen pe-2x text-danger" status="active"></i> </a>
                    @endcan
                    <td> {{ \Carbon\Carbon::parse($templist['updated_at'])->diffForHumans()}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
 </div>