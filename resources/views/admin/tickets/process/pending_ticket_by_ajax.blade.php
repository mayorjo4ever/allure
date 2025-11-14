<div class="row">
   @foreach($pendingTickets as $ticket)
   <div class="col-md-6">
      <div class="card-shadow-primary border mb-3 card card-body border-primary">
          <a href="{{url('admin/process-ticket/'.base64_encode($ticket['ticket_no']))}}" target="_blank" class="text-dark" style="text-decoration: none;">
         <h5 class="card-title">{{users_name($ticket['customer_id'])}} </h5>
          <b>Investigations</b> <span class="badge badge-pill badge-primary">{{count($ticket['specimen'])}}</span>
          <br/>
         <p>
            {!! list_customer_specimen($ticket['specimen'],$ticket['results'])  !!}
         </p>
          <span class="font-weight-600 mt-2 "> Ticket No : {{$ticket['ticket_no']}}</span>
         <button class="mb-2 mr-2 btn btn-secondary w-100 mt-2"> {{ \Carbon\Carbon::parse($ticket['updated_at'])->diffForHumans()}}<span class="badge badge-pill badge-light"><span class="pe-7s-alarm"></span></span></button>
         </a>
      </div>
   </div>
   @endforeach
   
   @empty($pendingTickets)
   <div class="col-md-12">
       <div class="alert alert-warning font-1rem">
           No Record Found &nbsp; <span class="pe pe-7s-search pe-2x"></span>
       </div>
   </div>
   @endempty
</div>
