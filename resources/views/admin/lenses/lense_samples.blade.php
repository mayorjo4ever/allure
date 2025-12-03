@extends('admin.arch_layouts.layout')
@section('content')
 
<div class="row mt-0 pt-0">
        <div class="col-md-12">

        @include('admin.arch_widgets.alert_messanger')
        @can('view-lenses')
        
        <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
            <div class="card-header">Available Lenses
            <div class="btn-actions-pane-right">
                    <div role="group" class="btn-group-sm btn-group">
                        <button onclick="showInactiveTables()" class="active btn btn-focus gap-5">Show Deleted Lenses</button>
                        <button onclick="hideInactiveTables()" class="btn btn-focus gap-5">Hide Deleted Lenses</button>
                    </div>
                </div>  
            </div>

        <div class="table-responsive  mt-2 pt-2 ">
        <table class="align-middle mb-0 table table-borderless table-striped table-hover dataTable">
            <thead>
            <tr class="text-uppercase">
                <th class="pl-4"># ID </th>                
                <th>Name</th>
                <th>Type</th>    
                <th>Category</th>
                <th>Features </th>
                
                <th>Sales Price </th>               
                @can('modify-lenses')<th>Status</th> @endcan
                @can('edit-lenses') <th>Edit </th> @endcan
                <th>Last Updated </th>
            </tr>
            </thead>
            <tbody> @foreach($lenses as $lense )
            <tr class="{{ ($lense['status']==1) ?"active":"inactive" }}">
                <td class="text-dark pl-4"># {{ $lense['id']}} </td>               
                <td> 
                    @can('edit-lenses')
                    <a class="text-dark font-weight-600" target="_blank" href="{{url('admin/add-edit-lenses/'.$lense['id']) }}">
                         {{ $lense['name']}} </a>
                    @else
                     {{ $lense['name']}}
                    @endcan
                    </td>
                    <td class="font-weight-600"> <a href="{{ url('admin/lenses/'.$lense['type_id']) }}" class="text-dark" > {{ $types[$lense['type_id']] }}</a> </td>                 
                    <td> <a href="{{ url('admin/lenses/'.$lense['categ_id']) }}" > {{ $categs[$lense['categ_id']] }}</a> </td> 
                    <td> 
                        <label class="font-weight-500" title=" {{ $lense['name']}}" >                    
                           Qty Rem: {{ $lense['qty_rem']}} <br/>
                           Solds : {{ ($lense['cum_qty'] - $lense['qty_rem']) }}                                       
                         </label>                   
                    </td>
                              
                
                <td> <strong> {!! "&#8358; ".number_format($lense['sales_price']) !!}  </strong> <br> 
                    <small class="text-danger"> {!! "&#8358; ".number_format($lense['purchase_price']) !!}   </small>
                </td>
                <!-- <td> {{ "N ".number_format($lense['sales_price']) }} </td>  -->
                @can('modify-lenses')
                <td>
                        @if($lense['status']==1)
                        <a class="updateLenseStatus" id="lense_id-{{ $lense['id']}}" lense_id="{{ $lense['id']}}" href="javascript:void(0)" title="Active">
                                <i class="pe-7s-check pe-2x font-weight-bold text-success " status="active"></i> Active  </a>  
                                @else <a class="updateLenseStatus" id="lense_id-{{ $lense['id']}}" lense_id="{{ $lense['id']}}" href="javascript:void(0)" title="Deleted">
                              <i class="pe-7s-attention pe-2x  text-danger font-weight-bold"  status="inactive"></i>Deleted </a> 
                         @endif
                </td>@endcan
               @can('edit-lenses') <td >
                        <a class=""  target="_blank" href="{{url('admin/add-edit-lenses/'.$lense['id']) }}">
                            <i class="pe-7s-pen pe-2x text-danger" status="active"></i> </a>
                </td> @endcan
                <td> {{ \Carbon\Carbon::parse($lense['updated_at'])->diffForHumans()}}</td>
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
