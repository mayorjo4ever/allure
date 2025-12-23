<?php use App\Models\Organization; ?>
@extends('admin.arch_layouts.layout')
@section('content')
 
<div class="row mt-0 pt-0">
        <div class="col-md-12">

        @include('admin.arch_widgets.alert_messanger')
        @can('view-invoices')
        
        <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
            <div class="card-header">
            <div class="btn-actions-pane-right">
<!--                    <div role="group" class="btn-group-sm btn-group">
                        <button onclick="showInactiveTables()" class="active btn btn-focus gap-5">Show Deleted Organizations</button>
                        <button onclick="hideInactiveTables()" class="btn btn-focus gap-5">Hide Deleted Organizations</button>
                    </div>-->
                </div>  
            </div>

        <div class="table-responsive  mt-2 pt-2 ">
        <table class="align-middle mb-0 table table-borderless table-striped table-hover dataTable">
            <thead>
            <tr>
                <th class="pl-4"># ID </th>              
                <th>Organization</th>        
                <th>Invoice Number</th>        
                <th>Total Amount</th>        
                <th>Amount Paid </th>                                          
                <th>Balance</th>                
            </tr>
            </thead>
            <tbody> @foreach($invoices as $k=>$invoice )
            <tr class="{{-- ($invoice['status']==1) ?"active":"inactive" --}}">
                <td class="text-muted pl-4"># {{ $k+1}} </td>               
                <td> {{ Organization::name($invoice->organization_id)}}  </td>                
                <th> <a href="{{url('admin/invoice/'.$invoice->id.'/bills')}}" target="_blank"><span class="badge border border-1 border-primary p-3 font-16">
                        {{$invoice->invoice_number}} 
                     </span></a>
                </th>
                <th>&#8358; {{number_format(calculate_invoice_bill($invoice->invoice_number))}}</th>
                <th> 0.0 </th>             
                <th> 0.0 </th>             
                
             
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
