@extends('admin.arch_layouts.layout')
@section('content')
 
<div class="row mt-0 pt-0">
        <div class="col-md-12">
            @include('admin.arch_widgets.alert_messanger')
            @can('view-bill-category')
        <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
            <div class="card-header">Available  {{$page_info['title']}}
                 <div class="btn-actions-pane-right">
                    <div role="group" class="btn-group-sm btn-group">
                        <button onclick="showInactiveTables()" class="active btn btn-focus">Show Deleted Categories</button>
                         &nbsp; &nbsp;  <button onclick="hideInactiveTables()" class="btn btn-focus">Hide Deleted Categories</button>
                    </div>
                </div>  
            </div>
        <div class="table-responsive  mt-2 pt-2 ">
        <table class="align-middle mb-0 table table-borderless table-striped table-hover dataTable">
            <thead>
            <tr>
                <th class="pl-4"># Category ID </th>
                <th>Name</th>
                <th >Short Description</th>
                @can('modify-bill-category')<th >Status</th> @endcan
                @can('edit-bill-category') <th>Edit / Delete </th> @endcan
                <th>Last Updated </th>
            </tr>
            </thead>
            <tbody> @foreach($billcategs as $billcateg )
            <tr class="{{ ($billcateg['status']==1) ?"active":"inactive" }}">
                <td class="text-muted pl-4"># {{ $billcateg['id']}} </td>
                <td> {{ $billcateg['name']}} </td>
                <td> {{ $billcateg['description']}} </td>
                @can('modify-bill-category')
                <td>
                         @if($billcateg['status']==1)
                            <a class="updateBillCategStatus" id="bill_categ_id-{{ $billcateg['id']}}" bill_categ_id="{{ $billcateg['id']}}" href="javascript:void(0)">
                                <i class="pe-7s-check pe-2x font-weight-bold text-success " status="active"></i> Active </a>
                           @else <a class="updateBillCategStatus" id="bill_categ_id-{{ $billcateg['id']}}" bill_categ_id="{{ $billcateg['id']}}" href="javascript:void(0)">
                              <i class="pe-7s-attention pe-2x  text-danger font-weight-bold"  status="inactive"></i> Not Active </a>
                          @endif
                </td>@endcan
                      @can('edit-bill-category') <td >
                        <a class="" bill_categ_id="{{ $billcateg['id']}}" href="{{url('admin/add-edit-bill-category/'.$billcateg['id']) }}">
                            <i class="pe-7s-pen pe-2x text-danger" status="active"></i> </a>                        

                </td> @endcan
                <td> {{ \Carbon\Carbon::parse($billcateg['updated_at'])->diffForHumans()}}</td>
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