@extends('admin.arch_layouts.layout')
@section('content')
 
<div class="row mt-0 pt-0">
        <div class="col-md-12">
            @include('admin.arch_widgets.alert_messanger')
            @can('view-lenses-category')
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
                @can('modify-lenses-category')<th >Status</th> @endcan
                @can('edit-lenses-category') <th>Edit / Delete </th> @endcan
                <th>Last Updated </th>
            </tr>
            </thead>
            <tbody> @foreach($categs as $categ )
            <tr class="{{ ($categ['status']==1) ?"active":"inactive" }}">
                <td class="text-muted pl-4"># {{ $categ['id']}} </td>
                <td> {{ $categ['name']}} </td>                
                @can('modify-lenses-category')
                <td>
                         @if($categ['status']==1)
                            <a class="updateLenseCategStatus" id="lense_categ_id-{{ $categ['id']}}" lense_categ_id="{{ $categ['id']}}" href="javascript:void(0)">
                                <i class="pe-7s-check pe-2x font-weight-bold text-success " status="active"></i> Active </a>
                           @else <a class="updateLenseCategStatus" id="lense_categ_id-{{ $categ['id']}}" lense_categ_id="{{ $categ['id']}}" href="javascript:void(0)">
                              <i class="pe-7s-attention pe-2x  text-danger font-weight-bold"  status="inactive"></i> Deleted </a>
                          @endif
                </td>@endcan
                      @can('edit-lenses-category') <td >
                        <a class="" lense_categ_id="{{ $categ['id']}}" href="{{url('admin/add-edit-lense-category/'.$categ['id']) }}">
                            <i class="pe-7s-pen pe-2x text-danger" status="active"></i> </a>                        

                </td> @endcan
                <td> {{ \Carbon\Carbon::parse($categ['updated_at'])->diffForHumans()}}</td>
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