<?php 
use Carbon\Carbon;   use App\Models\InvestigationTemplate;
?>
@extends('admin.arch_layouts.layout')
@section('content')

<div class="row mt-0 pt-0">
        <div class="col-md-12"> 
            @include('admin.arch_widgets.alert_messanger')
            @can('view-customers')      
            
            <x-admin.card header="{{$page_info['title']}}">
                <div class="table-responsive  mt-2 pt-2 filtered_customers ">
                    <table class="table table-bordered  dataTable" >
                        <thead>
                            <tr>                               
                                <th>Patient</th>
                                <th>Appointed Date</th>
                                <th>Checked In Time <br/> <small>If Patient has Arrived</small> </th>
<!--                                <th>Services </th>
                                <th>Payments </th>
                                <th>Checked Out Time</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appointment)
                            <tr id="row_{{ $appointment->id }}" class="{{ ($appointment->status=='completed'?'table-success':'')}}">                                    
                                    <td> <span class="font-weight-500">{{ $appointment->patient->surname." ".$appointment->patient->firstname." ".$appointment->patient->othername }}</span>
                                        <br/> <span class="badge table-info font-weight-500 p-2"> {{$appointment->patient->regno }} </span>
                                        <span class="badge p-2 status
                                            @if($appointment->status == 'pending') table-warning
                                            @elseif(in_array($appointment->status,['confirmed','checked_in','in_consultation','in_consultation','completed'])) table-success
                                            @else table-danger @endif">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                        
                                        <br/> <small>To See </small>
                                        {{$appointment->doctor->title." ". $appointment->doctor->surname." ".$appointment->doctor->firstname." ".$appointment->doctor->othername  }}
                                        
                                    </td>
                                    <td> <span class="font-weight-500">{{ $appointment->human_date }} </span>
                                        <br/>   {{ $appointment->appointment_date->format('Y-m-d') }}  &nbsp; 
                                            {{ $appointment->appointment_date->format('H:i A') }}
                                          <br/>
                                        <span class="countdown font-weight-500"
                                                data-time="{{ $appointment->appointment_date->format('Y-m-d H:i:s') }}">
                                          </span>
                                    </td>
                                    <td> 
                                        @if(!$appointment->checkedin)
                                        <div id="checkin-{{$appointment->id}}"> <button class="btn btn-outline-primary p-2 btn-sm appointment-checkin-btn ladda-button" data-style="expand-right" data-id="{{ $appointment->id }}">Check-In Now </button> </div>
                                        @else
                                        {{$appointment->checkin_time}} <br> <small> {{Carbon::parse($appointment->checkin_time)->diffForHumans()}}</small>
                                        @endif
                                    </td>
                                    <!--                                      <td> @php $totalFee = 0; $amountPaid = 0;  @endphp
                                       @if(!empty($appointment->investigations->toArray()))
                                        @foreach($appointment->investigations as $investigation)
                                            @php $totalFee += $investigation->price; @endphp
                                            <span class="badge @if(!empty($investigation->results->toarray())) table-success @else table-warning @endif"> {{investigation_name($investigation->investigation_template_id) }} </span>  <br/> 
                                         @endforeach
                                        @else
                                            --:--
                                        @endif
                                    </td>
                                    <td><strong> {{ $amountPaid }} /  {{$totalFee}} </strong></td>
                                   
                                    <td> <button class="btn btn-outline-success p-2 btn-sm">Check-Out Now </button></td>
                                     -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-admin.card>    
            
        @else 
            <x-un-authorized-page/>
        @endcan
        
    </div>
</div>

@endsection 