@extends('admin.arch_layouts.layout')
@section('content')
 
<div class="row mt-0 pt-0">
        <div class="col-md-12">

        @include('admin.arch_widgets.alert_messanger')
        @can('view-organizations')
        
        <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
            <div class="card-header">
            <div class="btn-actions-pane-right">
                    <div role="group" class="btn-group-sm btn-group">
                        <button onclick="showInactiveTables()" class="active btn btn-focus gap-5">Show Deleted Organizations</button>
                        <button onclick="hideInactiveTables()" class="btn btn-focus gap-5">Hide Deleted Organizations</button>
                    </div>
                </div>  
            </div>

        <div class="table-responsive  mt-2 pt-2 ">
        <table class="align-middle mb-0 table table-borderless table-striped table-hover dataTable">
            <thead>
            <tr>
                <th class="pl-4"># ID </th>              
                <th>Name</th>        
                <th>HMO No.</th>        
                <th>Address</th>        
                <th>Contact Email</th>               
                <th>Contact Phone </th>               
                @can('modify-organization')<th>Status</th> @endcan
                @can('edit-organization') <th>Edit </th> @endcan
                <th>Last Updated </th>
            </tr>
            </thead>
            <tbody> @foreach($organizations as $organization )
            <tr class="{{ ($organization['status']==1) ?"active":"inactive" }}">
                <td class="text-muted pl-4"># {{ $organization->id}} </td>               
                <td> {{ $organization->name}} </td>                
                <td> {{ $organization->enrole_no}} </td>                
                <td> {{ $organization->address}} </td>                
                <td> {{ $organization->email }} </td>
                <td> {{ $organization->phone }} </td>
                 @can('modify-organization')
                <td>
                    @if($organization->status ==1)
                    <a class="updateOrganizationStatus" id="organization_id-{{ $organization->id}}" organization_id="{{ $organization->id}}" href="javascript:void(0)" title="Active">
                            <i class="pe-7s-check pe-2x font-weight-bold text-success " status="active"></i> Active  </a>  
                            @else <a class="updateOrganizationStatus" id="organization_id-{{ $organization->id}}" organization_id="{{ $organization->id}}" href="javascript:void(0)" title="Deleted">
                          <i class="pe-7s-attention pe-2x  text-danger font-weight-bold"  status="inactive"></i> Deleted </a> 
                     @endif
                </td>@endcan
               @can('edit-organization') <td >
                        <a class=""  href="{{url('admin/add-edit-organization/'.$organization->id) }}">
                            <i class="pe-7s-pen pe-2x text-danger" status="active"></i> </a>
                </td> @endcan
                <td> {{ \Carbon\Carbon::parse($organization->updated_at)->diffForHumans()}}</td>
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
