@extends('admin.arch_layouts.layout')
@section('content')
 
<div class="row mt-0 pt-0">
        <div class="col-md-12">

        @include('admin.arch_widgets.alert_messanger')
        @can('view-organizations')
        
        <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
            <div class="card-header">{{$page_info['title']}}
<!--            <div class="btn-actions-pane-right">
                    <div role="group" class="btn-group-sm btn-group">
                        <button onclick="showInactiveTables()" class="active btn btn-focus gap-5">Show Deleted Organizations</button>
                        <button onclick="hideInactiveTables()" class="btn btn-focus gap-5">Hide Deleted Organizations</button>
                    </div>
                </div>  -->
            </div>

        <div class="table-responsive  mt-2 pt-2 ">
        <table class="align-middle mb-0 table table-borderless table-striped table-hover dataTable">
            <thead>
            <tr>
                <th class="pl-4"># ID </th>              
                <th>Patient</th>        
                <th>Amount</th>        
                <th>Ticket No</th>        
                <th>Date</th>
                @can('delete-invoice-bill') <th>Delete </th> @endcan
                <th>Last Updated </th>
            </tr>
            </thead>
            @php $bills = 0; $discounts = 0; @endphp 
            <tbody> @foreach($organization->openedInvoices  as $invoice )
            <tr class="{{-- ($invoice['status']==1) ?"active":"inactive" --}}">
                <td class="text-muted pl-4"># {{ $invoice->id}} </td>               
                <td> {{ $invoice->user->surname}} {{ $invoice->user->firstname}} <br/> <b>{{ $invoice->user->regno}}</b> </td>                
                <th>  &#8358; {{number_format($invoice->amount)}} <br>
                    <small>Discount : &#8358; {{number_format($invoice->discount)}} </small>
                    @php $bills+=$invoice->amount; $discounts +=$invoice->discount; @endphp 
                </th>
                <td> <a href="{{url('admin/print-invoice/'.base64_encode($invoice->bill->ticketno))}}" target="_blank"><span class="badge border border-1 border-primary p-3 font-16">
                       {{ $invoice->bill->ticketno}} </span></a> </td>                
                <td>
                   {{ \Carbon\Carbon::parse($invoice->created_at)->toDayDateTimeString()}}
                </td>
               @can('delete-invoice-bill') <td >
                   <a class="btn btn-outline-danger" href="javascript:void(0)" onclick="deleteOrganInvoice('{{$invoice->id.'|'.$invoice->bill->ticketno.' - N '.$invoice->amount}}')" >
                            <i class="pe-7s-trash pe-2x" status="active"></i> </a>
                </td> @endcan
                <td> {{ \Carbon\Carbon::parse($invoice->updated_at)->diffForHumans()}}</td>
                </tr>
              @endforeach
                </tbody>
        </table>
        </div>
        
            <div class="row pt-3">
            <div class="col-md-6">
                 <h6 class="mt-3 text-capitalize"> Total Bills: <strong>&#8358; {{number_format($bills - $discounts)}}  </strong>
               <br/>  In Words :     {{ number_to_words($bills); }}   </h6>
            </div>
            <div class="col-md-3"> @if(!empty($organization->openedInvoices->toarray()))
                <button onclick="finalizeOrganInvoice('{{$organization->id}}')" class="btn btn-block btn-primary btn-lg p-3 font-weight-700">Finalize Invoice </button>
                @endif
            </div>
            </div><!-- ./ row -->
        </div>
         @else 
            <x-un-authorized-page/>
        @endcan
    </div>
</div>

@endsection
