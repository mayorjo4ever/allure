@extends('admin.arch_layouts.layout')
@section('content')
 
<div class="row mt-0 pt-0">
        <div class="col-md-12">

        @include('admin.arch_widgets.alert_messanger')
        @can('view-frames')
        
        <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
            <div class="card-header">Available Frames
            <div class="btn-actions-pane-right">
                    <div role="group" class="btn-group-sm btn-group">
                        <button onclick="showInactiveTables()" class="active btn btn-focus gap-5">Show Deleted Frames</button>
                        <button onclick="hideInactiveTables()" class="btn btn-focus gap-5">Hide Deleted Frames</button>
                    </div>
                </div>  
            </div>

        <div class="table-responsive  mt-2 pt-2 ">
        <table class="align-middle mb-0 table table-borderless table-striped table-hover dataTable">
            <thead>
            <tr class="text-uppercase">
                <th class="pl-4"># ID </th>                
                <th>Name</th>
<!--                <th>Type</th>    
                <th>Category</th>-->
                <th>Features </th>
                
                <th>Sales Price </th>               
                @can('modify-frames')<th>Status</th> @endcan
                @can('edit-frames') <th>Edit </th> @endcan
                <th>Last Updated </th>
            </tr>
            </thead>
            <tbody> @foreach($frames as $frame )
            <tr class="{{ ($frame->status==1) ?"active":"inactive" }}">
                <td class="text-dark pl-4"># {{ $frame->id}} </td>               
                <td> 
                    @can('edit-frames')
                    <a class="text-dark font-weight-600" target="_blank" href="{{url('admin/add-edit-frames/'.$frame->id) }}">
                         {{ $frame->name}} </a>
                    @else
                     {{ $frame->name}}
                    @endcan
                    </td>
                    <td> 
                        <label class="font-weight-500" title=" {{ $frame->name}}" >                    
                           Qty Rem: {{ $frame->qty_rem}} <br/>
                           Solds : {{ ($frame->cum_qty - $frame->qty_rem) }}
                         </label>                   
                    </td> 
                
                <td> <strong> {!! "&#8358; ".number_format($frame['sales_price']) !!}  </strong> <br> 
                    <small class="text-danger"> {!! "&#8358; ".number_format($frame['purchase_price']) !!}   </small>
                </td>
                <!-- <td> {{ "N ".number_format($frame['sales_price']) }} </td>  -->
                @can('modify-frames')
                <td>
                        @if($frame->status ==1)
                        <a class="updateBillTypeStatus" id="bill_type_id-{{ $frame->id}}" bill_type_id="{{ $frame->id}}" href="javascript:void(0)" title="Active">
                                <i class="pe-7s-check pe-2x font-weight-bold text-success " status="active"></i> Active  </a>  
                                @else <a class="updateBillTypeStatus" id="bill_type_id-{{ $frame->id}}" bill_type_id="{{ $frame->id}}" href="javascript:void(0)" title="Not Active">
                              <i class="pe-7s-attention pe-2x  text-danger font-weight-bold"  status="inactive"></i> Not Active </a> 
                         @endif
                </td>@endcan
               @can('edit-frames') <td >
                        <a class=""  target="_blank" href="{{url('admin/add-edit-frames/'.$frame->id) }}">
                            <i class="pe-7s-pen pe-2x text-danger" status="active"></i> </a>
                </td> @endcan
                <td> {{ \Carbon\Carbon::parse($frame['updated_at'])->diffForHumans()}}</td>
                </tr>
                    @endforeach
                </tbody>
        </table>
        </div>

        </div>
         @else 
            <x-un-authorized-page/>
        @endcan
    </div>
</div>

@endsection
