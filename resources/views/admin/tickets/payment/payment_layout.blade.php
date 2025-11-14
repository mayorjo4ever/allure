<ul class="tabs-animated-shadow tabs-animated nav">
  @can('view-pending-payments')
   <li class="nav-item">
       <a role="tab" class="nav-link show active"id="tab-c-4" data-toggle="tab" href="#tab-animated-4" aria-selected="true">
      <span> View Pending Payments  </span>
      </a>
   </li> @endcan
   
  @can('receive-ticket-payment')
   <li class="nav-item">
      <a role="tab" class="nav-link show"  id="tab-c-1" data-toggle="tab" href="#tab-animated-1" aria-selected="false">
      <span> Make Payment | Print Receipt </span>
      </a>
   </li> @endcan
   
   @can('view-payment-summary')
   <li class="nav-item">
      <a role="tab" class="nav-link show" id="tab-c-2" data-toggle="tab" href="#tab-animated-2" aria-selected="false">
      <span> Payment Summary </span>
      </a>
   </li> @endcan
   @can('view-ticket-payment-summary')
    <li class="nav-item">
      <a role="tab" class="nav-link show" id="tab-c-3" data-toggle="tab" href="#tab-animated-3" aria-selected="false">
      <span> Ticket Summary </span>
      </a>
   </li>@endcan
</ul>
<div class="tab-content">
   <div class="tab-pane show active" id="tab-animated-4" role="tabpanel">
      @include('admin.tickets.payment.pending_payment_by_ticket_form')
   </div>
    
   <div class="tab-pane show " id="tab-animated-1" role="tabpanel">
      @include('admin.tickets.payment.customer_search_form')     
   </div>
   
   <div class="tab-pane show" id="tab-animated-2" role="tabpanel">
      @include('admin.tickets.payment.payment_by_date_form')
   </div>
    
   <div class="tab-pane show" id="tab-animated-3" role="tabpanel">
      @include('admin.tickets.payment.payment_by_ticket_form')
   </div>
</div>
