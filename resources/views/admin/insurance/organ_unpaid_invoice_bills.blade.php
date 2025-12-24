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
        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
            <thead>
            <tr>
                <th class="pl-4"># ID </th>              
                <th>Patient</th>                           
                <th>Bill Details</th>     
                <th>Total Cost</th>
            </tr>
            </thead>
            @php $bills = 0; $discounts = 0; @endphp 
            <tbody> @foreach($organ_invoice  as $k=>$invoice )
            <tr class="{{-- ($invoice['status']==1) ?"active":"inactive" --}}">
                <td class="text-muted pl-4"># {{ $invoice->id}} </td>               
                <td> Patient:&nbsp; <b>{{ $invoice->user->surname}} {{ $invoice->user->firstname}} </b>
                    <br/>Regno:&nbsp; <b>{{ $invoice->user->regno}}</b> 
                    <br/>HMO:&nbsp;<b>{{ $invoice->user->enrole_no}}</b> 
                    <br/>Ticket No:&nbsp; <a href="{{url('admin/print-invoice/'.base64_encode($invoice->bill->ticketno))}}" target="_blank"><span class="font-weight-600">
                       {{ $invoice->bill->ticketno}} </span></a>
                
                </td>  
                              
                <td><small>General Bills</small>
                     <ol class="mb-0 mt-0">
                   <?php $hosp_bills = get_general_bills($invoice->bill->bill_type_ids) ?>
                   @foreach($hosp_bills as $k=>$hosp_bill)
                   <li> &nbsp;&nbsp;{{ $hosp_bill->name }} Fee : &nbsp;&nbsp;
                       <span class="pull-right"> {{ number_format($hosp_bill->amount) }} </span>
                   </li>
                   @endforeach
                   </ol>
                    @if(!empty($invoice->appointment->investigations->toarray()))
                   <small class="mt-0 text-center">Investigations</small>
                    <ol class="mb-0 mt-0">
                     @foreach($invoice->appointment->investigations as $k=>$investigation)
                    <li> &nbsp;&nbsp;{{ $investigation->template->name }} : &nbsp;&nbsp;
                        <span class="pull-right"> {{ number_format($investigation->price) }} </span>                    
                    </li>
                   @endforeach
                   </ol>
                   @endif
                    
                   @if(!empty($invoice->appointment->prescriptions->toarray()))
                    <small>Prescriptions, Drugs & Frames </small>
                    <ol class="mb-0 mt-0">                       
                    @foreach($invoice->appointment->prescriptions as $l=>$prescription)
                    <li> &nbsp;&nbsp;{{ $prescription->item->name }} [{{ ucfirst($prescription->item_type)}}]&nbsp;*&nbsp;{{ $prescription->quantity}}  : &nbsp;&nbsp;
                        <span class="pull-right"> {{ number_format($prescription->total_price) }} </span>
                     </li>
                    @endforeach                       
                    </ol>
                   @endif
                </td>
                <th>  &#8358; {{number_format($invoice->amount)}} <br>
                    <small>Discount : &#8358; {{number_format($invoice->discount)}} </small>
                    @php $bills+=$invoice->amount; $discounts +=$invoice->discount; @endphp 
                </th>
            </tr>
              @endforeach
                </tbody>
        </table>
        </div>
        
            <div class="row pt-3">
            <div class="col-md-12">                
                <h6 class="table-light text-uppercase text-dark p-2 pull-right"> 
                    Total Bills: &nbsp; <strong>&#8358; {{number_format($bills - $discounts)}}  </strong>
                   &nbsp; &nbsp; --&nbsp; &nbsp;  {{ number_to_words($bills - $discounts); }}  </h6>
            </div>
                
            <div class="col-md-12">
                <a href="{{url('admin/download/invoices/unpaid/'.$invoice_no.'/pdf')}}" target="_blank" class="btn btn-light pull-right ">
                    Download PDF &nbsp; <i class="fa fa-file-pdf fa-2x"></i>
                </a>
            </div>
           
            </div><!-- ./ row -->
        </div>
         @else 
            <x-un-authorized-page/>
        @endcan
    </div>
</div>

@endsection
