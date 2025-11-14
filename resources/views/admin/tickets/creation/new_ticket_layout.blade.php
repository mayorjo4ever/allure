<ul class="tabs-animated-shadow tabs-animated nav">
   <li class="nav-item">
      <a role="tab" class="nav-link show active" id="tab-c-0" data-toggle="tab" href="#tab-animated-0" aria-selected="true">
      <span>01) &nbsp; Search Customer </span>
      </a>
   </li>
   <!-- <li class="nav-item">
      <a role="tab" class="nav-link show" id="tab-c-1" data-toggle="tab" href="#tab-animated-1" aria-selected="false">
      <span> 02) &nbsp; Profile Summary </span>
      </a>
   </li>-->
   <li class="nav-item">
      <a role="tab" class="nav-link show" id="tab-c-2" data-toggle="tab" href="#tab-animated-2" aria-selected="false">
      <span>02 &nbsp; Investigation Requested </span>
      </a>
   </li>
    <li class="nav-item">
      <a role="tab" class="nav-link show" id="tab-c-3" data-toggle="tab" href="#tab-animated-3" aria-selected="false">
      <span>03 &nbsp; Finalize Ticket </span>
      </a>
   </li>
</ul>
<div class="tab-content">
   <div class="tab-pane show active" id="tab-animated-0" role="tabpanel">
      @include('admin.tickets.creation.customer_search_form')
   </div>
   <div class="tab-pane show" id="tab-animated-1" role="tabpanel">
      @include('admin.tickets.creation.customer_info_form')
   </div>
   <div class="tab-pane show" id="tab-animated-2" role="tabpanel">
      @include('admin.tickets.creation.specimen_search_form')
   </div>
   <div class="tab-pane show" id="tab-animated-3" role="tabpanel">
      @include('admin.tickets.creation.final_ticket_form')
   </div>
</div>
