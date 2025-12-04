<?php use Carbon\Carbon;  ?>
<div class="row mt-0 pt-0">
        <div class="col-md-12 col-sm-12"> 
           <x-admin.card >
                <div class="row">
                    <div class="col-md-3  m-0 p-0"> 
                        @foreach($past_appointments as $appointment)
                            <div class="col-sm-12">
                                <button onclick="display_this_consultation('{{$appointment->id}}','{{$appointment->user_id}}')" class="btn btn-outline-info active w-100 allSubBtn p-2 m-2 font-weight-600 ">
                                   {{Carbon::parse($appointment->appointment_date)->format('D, jS F, Y - H:i A')}}  
                                </button>
                            </div>
                        @endforeach
                        
                        @if(empty($past_appointments->toArray()))
                        <span class="text-warning font-weight-600"> No Appointment Found </span>
                        @endif
                    </div>
                    <div class="col-md-9">
                            <div class="past_consultation_summary"></div>
                    </div>
                   </div>
                </div>
            </x-admin.card>
</div>   

