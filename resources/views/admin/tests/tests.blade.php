@extends('admin.arch_layouts.layout')
@section('content')
 
<div class="row mt-0 pt-0">
        <div class="col-md-12">

        @include('admin.arch_widgets.alert_messanger')
        @can('view-tests')
        
        <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
            <div class="card-header">Available Test / Investigations
            <div class="btn-actions-pane-right">
                    <div role="group" class="btn-group-sm btn-group">
                        <button onclick="showInactiveTables()" class="active btn btn-focus gap-5">Show Deleted Tests</button>
                        <button onclick="hideInactiveTables()" class="btn btn-focus gap-5">Hide Deleted Tests</button>
                    </div>
                </div>  
            </div>

        <div class="table-responsive  mt-2 pt-2 ">
        <table class="align-middle mb-0 table table-borderless table-striped table-hover dataTable">
            <thead>
            <tr>
                <th class="pl-4"># ID </th>
                @can('view-bill-template')
                <th>Template</th>
                @endcan
                <th>Name</th>
                <th>Price </th>  
<!--                <th>Requires Attachment </th>  -->
                @can('modify-tests')<th>Status</th> @endcan
                @can('edit-tests') <th>Edit </th> @endcan
                <th>Last Updated </th>
            </tr>
            </thead>
            <tbody> @foreach($tests as $test )
            <tr class="{{ ($test['status']==1) ?"active":"inactive" }}">
                <td class="text-muted pl-4"># {{ $test['id']}} </td>               
                <td> 
                    @can('edit-tests')
                    <a class="text-dark" target="_blank" href="{{url('admin/add-edit-test/'.$test['id']) }}">
                         {{ $test['name']}} </a>
                    @else
                     {{ $test['name']}}
                    @endcan
                    </td>
                 
                 <td> <strong> {!! "&#8358; ".number_format($test['price']) !!}  </strong> <br>                     
                </td>
<!--                <td>  @if($test['requires_image']==1)
                    <i class="pe-7s-check pe-2x font-weight-bold text-success " status="active"></i> Yes  </a>   
                    @else
                    <i class="pe-7s-close pe-2x font-weight-bold text-danger " status="active"></i> No  </a>   
                    @endif
                </td>-->
                @can('modify-tests')
                <td>
                        @if($test['status']==1)
                        <a class="updateTestStatus" id="test_id-{{ $test['id']}}" test_id="{{ $test['id']}}" href="javascript:void(0)" title="Active">
                                <i class="pe-7s-check pe-2x font-weight-bold text-success " status="active"></i> Active  </a>  
                                @else <a class="updateTestStatus" id="test_id-{{ $test['id']}}" test_id="{{ $test['id']}}" href="javascript:void(0)" title="Deleted">
                              <i class="pe-7s-attention pe-2x  text-danger font-weight-bold"  status="inactive"></i> Deleted </a> 
                         @endif
                </td>@endcan
               @can('edit-tests') <td >
                        <a class=""  target="_blank" href="{{url('admin/add-edit-test/'.$test['id']) }}">
                            <i class="pe-7s-pen pe-2x text-danger" status="active"></i> </a>
                </td> @endcan
                <td> {{ \Carbon\Carbon::parse($test['updated_at'])->diffForHumans()}}</td>
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
