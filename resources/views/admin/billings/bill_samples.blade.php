@extends('admin.arch_layouts.layout')
@section('content')
 
<div class="row mt-0 pt-0">
        <div class="col-md-12">

        @include('admin.arch_widgets.alert_messanger')
        @can('view-general-bill')
        
        <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
            <div class="card-header">
            <div class="btn-actions-pane-right">
                    <div role="group" class="btn-group-sm btn-group">
                        <button onclick="showInactiveTables()" class="active btn btn-focus gap-5">Show Deleted Bill Types</button>
                        <button onclick="hideInactiveTables()" class="btn btn-focus gap-5">Hide Deleted Bill Types</button>
                    </div>
                </div>  
            </div>

        <div class="table-responsive  mt-2 pt-2 ">
        <table class="align-middle mb-0 table table-borderless table-striped table-hover dataTable">
            <thead>
            <tr>
                <th class="pl-4"># ID </th>              
                <th>Name</th>        
                <th> Amount </th>               
                @can('modify-general-bill')<th>Status</th> @endcan
                @can('edit-general-bill') <th>Edit </th> @endcan
                <th>Last Updated </th>
            </tr>
            </thead>
            <tbody> @foreach($bill_types as $bill_type )
            <tr class="{{ ($bill_type['status']==1) ?"active":"inactive" }}">
                <td class="text-muted pl-4"># {{ $bill_type['id']}} </td>               
                <td> {{ $bill_type['name']}} </td>                
                <td> {{ "N ".number_format($bill_type['amount']) }} </td>
                 @can('modify-general-bill')
                <td>
                    @if($bill_type['status']==1)
                    <a class="updateBillTypeStatus" id="bill_type_id-{{ $bill_type['id']}}" bill_type_id="{{ $bill_type['id']}}" href="javascript:void(0)" title="Active">
                            <i class="pe-7s-check pe-2x font-weight-bold text-success " status="active"></i> Active  </a>  
                            @else <a class="updateBillTypeStatus" id="bill_type_id-{{ $bill_type['id']}}" bill_type_id="{{ $bill_type['id']}}" href="javascript:void(0)" title="Not Active">
                          <i class="pe-7s-attention pe-2x  text-danger font-weight-bold"  status="inactive"></i> Not Active </a> 
                     @endif
                </td>@endcan
               @can('edit-general-bill') <td >
                        <a class="" bill_categ_id="{{ $bill_type['id']}}" href="{{url('admin/add-edit-bill/'.$bill_type['id']) }}">
                            <i class="pe-7s-pen pe-2x text-danger" status="active"></i> </a>
                </td> @endcan
                <td> {{ \Carbon\Carbon::parse($bill_type['updated_at'])->diffForHumans()}}</td>
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
