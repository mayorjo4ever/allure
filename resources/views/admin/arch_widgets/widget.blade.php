<?php use App\Models\BillType;
    use Carbon\Carbon;
    $this_year = Carbon::now()->year;
?>


@can('view-calendar-widget')
<div class="row">
    <div class="col-md-6 col-xl-4">
      <div class="card mb-3 widget-content bg-grow-early">
          <center> <div class="calendar w-100" ></div> </center>
      </div>
   </div>
</div>@endcan


<div class="row">
  @can('view-total-customer-widget')
   <div class="col-md-6 col-xl-4">
      <div class="card mb-3 widget-content bg-midnight-bloom">
         <div class="widget-content-wrapper text-white">
            <div class="widget-content-left">
               <div class="widget-heading text-uppercase">Total Customer </div>
               <div class="widget-subheading font-weight-700"><a class="text-white" style="opacity:1" target="_blank" href="{{url('admin/customers')}}">All Registered Customers  :</a> </div>
            </div>
            <div class="widget-content-right">
               <div class="widget-numbers text-white"><span>{{number_format($customers)}} </span></div>
            </div>
         </div>
      </div>
   </div> @endcan

   @can('view-all-appointment-widget')
   <div class="col-md-6 col-xl-4">
      <div class="card mb-3 widget-content bg-midnight-bloom">
         <div class="widget-content-wrapper text-white">
            <div class="widget-content-left">
                <div class="widget-heading text-uppercase"><a class="text-white" style="opacity:1" target="_blank" href="{{url('admin/tickets')}}"> All Appointments </a> </div>
               <div class="widget-subheading font-weight-700 text-white text-uppercase"> for the year {{$this_year}} </div>
            </div>
            <div class="widget-content-right">
               <div class="widget-numbers text-white"><span>{{number_format($tickets_created)}} </span></div>
            </div>
         </div>
      </div>
    </div> @endcan

    @can('view-completed-ticket-widget')
   <div class="col-md-6 col-xl-4">
      <div class="card mb-3 widget-content bg-grow-early">
         <div class="widget-content-wrapper text-white">
            <div class="widget-content-left">
                <div class="widget-heading font-weight-700 text-uppercase"> <a class="text-white" style="opacity:1" target="_blank" href="{{url('admin/tickets')}}">Total Completed Tickets </a></div>
               <div class="widget-subheading font-weight-700 text-white text-uppercase"> for the year {{$this_year}} </div>
            </div>
            <div class="widget-content-right">
               <div class="widget-numbers text-white "><span>{{number_format($completed_tickets)}} </span></div>
            </div>
         </div>
      </div>
   </div> @endcan

   @can('view-pending-appointment-widget')
   <div class="col-md-6 col-xl-4">
      <div class="card mb-3 widget-content bg-sunny-morning">
         <div class="widget-content-wrapper text-white">
            <div class="widget-content-left">
                <div class="widget-heading text-uppercase font-weight-700"><a class="text-white" style="opacity:1" target="_blank" href="{{url('admin/tickets')}}">Total Pending Appointments</a></div>
               <div class="widget-subheading font-weight-700 text-dark text-uppercase"> for the year {{$this_year}} </div>
            </div>
            <div class="widget-content-right">
               <div class="widget-numbers text-white font-weight-700"><span> {{number_format($pending_tickets)}}</span></div>
            </div>
         </div>
      </div>
   </div> @endcan

   @can('view-highest-test-widget')
   <div class="col-md-6 col-xl-4">
      <div class="card mb-3 widget-content bg-arielle-smile">
         <div class="widget-content-wrapper text-white">
            <div class="widget-content-left">
                <div class="widget-heading text-uppercase font-weight-700"> <a class="text-white" style="opacity:1" target="_blank" href="{{url('admin/reports')}}">Highest Test Done</a></div>
               <div class="widget-subheading font-weight-700 text-dark">{{BillType::bill_name($maxBill) }}</div>
            </div>
            <div class="widget-content-right">
                <div class="widget-numbers text-white"> <small class="small">Total :</small><span> {{number_format($maxCount)}}</span></div>
            </div>
         </div>
      </div>
   </div> @endcan

   @can('view-total-payment-widget')
   <div class="col-md-6 col-xl-4">
      <div class="card mb-3 widget-content bg-arielle-smile">
         <div class="widget-content-wrapper text-white">
            <div class="widget-content-left">
                <div class="widget-heading text-uppercase font-weight-900"><a class="text-white" style="opacity:1" target="_blank" href="{{url('admin/all-reports')}}"> Overall bill cost </a></div>
               <div class="widget-subheading font-weight-700 text-dark text-uppercase"> for the year {{$this_year}} </div>
            </div>
            <div class="widget-content-right">
               <div class="widget-numbers text-white"><span> {{number_format(total_bill_cost($this_year))}}</span></div>
            </div>
         </div>
      </div>
   </div>  @endcan
   
 @can('view-total-pending-payment-widget')
   <div class="col-md-6 col-xl-4">
      <div class="card mb-3 widget-content bg-love-kiss">
         <div class="widget-content-wrapper text-white">
            <div class="widget-content-left">
               <div class="widget-heading text-uppercase font-weight-900">Pending payment </div>
               <div class="widget-subheading font-weight-700 text-dark text-uppercase"> for the year {{$this_year}} </div>
            </div>
            <div class="widget-content-right">
               <div class="widget-numbers text-white"><span> {{number_format(total_pending_payment($this_year)) }}</span></div>
            </div>
         </div>
      </div>
   </div> @endcan
   
   @can('view-total-payment-widget')
   <div class="col-md-6 col-xl-4">
      <div class="card mb-3 widget-content bg-grow-early">
         <div class="widget-content-wrapper text-white">
            <div class="widget-content-left">
               <div class="widget-heading text-uppercase font-weight-900">Total Amount Paid </div>
               <div class="widget-subheading font-weight-700 text-dark text-uppercase"> for the year {{Carbon::now()->year}} </div>
            </div>
            <div class="widget-content-right">
               <div class="widget-numbers text-white"><span> {{number_format(total_bill_paid(Carbon::now()->year))}}</span></div>
            </div>
         </div>
      </div>
   </div>
@endcan


</div>
