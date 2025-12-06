@extends('admin.arch_layouts.layout')
@section('content')
 
<div class="row mt-0 pt-0">
        <div class="col-md-12">

        @include('admin.arch_widgets.alert_messanger')
        @can('view-accounts')
        
        <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
            <div class="card-header">
            <div class="btn-actions-pane-right">
                    <div role="group" class="btn-group-sm btn-group">
                        <button onclick="showInactiveTables()" class="active btn btn-focus gap-5">Show Deleted Accounts</button>
                        <button onclick="hideInactiveTables()" class="btn btn-focus gap-5">Hide Deleted Accounts</button>
                    </div>
                </div>  
            </div>

        <div class="table-responsive  mt-2 pt-2 ">
        <table class="align-middle mb-0 table table-borderless table-striped table-hover dataTable">
            <thead>
            <tr>
                <th class="pl-4"># ID </th>              
                <th>Bank Name</th>        
                <th>Account Name</th>        
                <th> Account Number </th>               
                <th> Main Account </th>               
                @can('modify-account')<th>Status</th> @endcan
                @can('edit-account') <th>Edit </th> @endcan
                <th>Last Updated </th>
            </tr>
            </thead>
            <tbody> @foreach($accounts as $account )
            <tr class="{{ ($account->status==1) ?"active":"inactive" }}">
                <td class="text-muted pl-4"># {{ $account->id}} </td>               
                <td> {{ $account->bank}} </td>                
                <td> {{ $account->name}} </td>                
                <td> {{ $account->number }} </td>
                <td> {{ ($account->active==0)?"NO":"YES" }} </td>
                 @can('modify-account')
                <td>
                    @if($account->status==1)
                    <a class="updateBankAccountStatus" id="account_id-{{ $account->id}}" account_id="{{ $account->id}}" href="javascript:void(0)" title="Active">
                            <i class="pe-7s-check pe-2x font-weight-bold text-success " status="active"></i> Active  </a>  
                            @else <a class="updateBankAccountStatus" id="account_id-{{ $account->id}}" account_id="{{ $account->id}}" href="javascript:void(0)" title="Deleted">
                          <i class="pe-7s-attention pe-2x  text-danger font-weight-bold"  status="inactive"></i> Deleted </a> 
                     @endif
                </td>@endcan
               @can('edit-account') <td >
                        <a class=""  href="{{url('admin/add-edit-account/'.$account->id) }}">
                            <i class="pe-7s-pen pe-2x text-danger" status="active"></i> </a>
                </td> @endcan
                <td> {{ \Carbon\Carbon::parse($account->updated_at)->diffForHumans()}}</td>
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
