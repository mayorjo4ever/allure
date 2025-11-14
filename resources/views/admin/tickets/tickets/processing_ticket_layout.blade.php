<ul class="tabs-animated-shadow tabs-animated nav">
  @can('view-pending-ticket')
  <li class="nav-item">  <!--  onclick="show_pending_tickets()" removed from <a>  -->
       <a role="tab" class="nav-link show active" id="tab-c-0" data-toggle="tab" href="#tab-animated-0" aria-selected="true">
      <span> &nbsp;All Pending Tickets  </span>
      </a>
   </li> @endcan
    
   @can('view-completed-ticket')
   <li class="nav-item">
      <a role="tab" onclick="show_completed_tickets()"  class="nav-link show" id="tab-c-1" data-toggle="tab" href="#tab-animated-1" aria-selected="false">
      <span>&nbsp;All Completed Tickets </span>
      </a>
   </li> @endcan
   
   @can('search-completed-ticket')
    <li class="nav-item">
      <a role="tab" class="nav-link show" id="tab-c-2" data-toggle="tab" href="#tab-animated-2" aria-selected="false">
      <span> &nbsp; Search Ticket By Date </span>
      </a>
   </li>
   <li class="nav-item">
      <a role="tab" class="nav-link show" id="tab-c-3" data-toggle="tab" href="#tab-animated-3" aria-selected="false">
      <span> &nbsp; Search Ticket By Ticket No </span>
      </a>
   </li> @endcan
</ul>
<div class="tab-content">  @can('view-pending-ticket')
   <div class="tab-pane show active" id="tab-animated-0" role="tabpanel">
      @include('admin.tickets.tickets.pending_ticket_view')
   </div> @endcan 
    @can('view-completed-ticket')
   <div class="tab-pane show" id="tab-animated-1" role="tabpanel">
      @include('admin.tickets.tickets.completed_ticket_view')
   </div> @endcan 
   <div class="tab-pane show" id="tab-animated-2" role="tabpanel">
       @include('admin.tickets.completed.ticket_by_date_form')       
   </div>
   <div class="tab-pane show" id="tab-animated-3" role="tabpanel">
      @include('admin.tickets.completed.ticket_by_ticket_search')
   </div>
</div>
