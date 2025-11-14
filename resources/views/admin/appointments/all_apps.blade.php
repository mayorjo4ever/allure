<?php 
# use App\Models\Subject;
?>
@extends('admin.arch_layouts.layout')
@section('content')

<div class="row mt-0 pt-0">
        <div class="col-md-12"> 
            @include('admin.arch_widgets.alert_messanger')
            @can('view-customers')      
            
            <x-admin.card header="All Apointments ">
                <div class="table-responsive  mt-2 pt-2 filtered_customers ">
                    <table class="table table-bordered  dataTable" >
                        <thead>
                            <tr>
                                <th>Doctor</th>
                                <th>Patient</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($appointments as $appointment)
                                <tr id="row_{{ $appointment->id }}">
                                    <td>{{$appointment->doctor->title." ". $appointment->doctor->surname." ".$appointment->doctor->firstname." ".$appointment->doctor->othername  }}</td>
                                    <td> <span class="font-weight-500">{{ $appointment->patient->surname." ".$appointment->patient->firstname." ".$appointment->patient->othername }}</span>
                                        <br/> <small>{{$appointment->patient->regno }}</small>
                                    </td>
                                    <td> <span class="font-weight-500">{{ $appointment->human_date }} </span>
                                        <br/> <small> {{ $appointment->appointment_date->format('Y-m-d') }}  &nbsp; 
                                            {{ $appointment->appointment_date->format('H:i A') }}
                                        </small>
                                    </td>
                                    
                                    <td> <span class="countdown font-weight-500"
                                                data-time="{{ $appointment->appointment_date->format('Y-m-d H:i:s') }}">
                                          </span></td>
                                    <td>
                                        <span class="badge p-3 status
                                            @if($appointment->status == 'pending') table-warning
                                            @elseif(in_array($appointment->status,['confirmed','checked_in','in_consultation','in_consultation'])) table-success
                                            @else table-danger @endif">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td> <div class="actions">
                                        @if($appointment->status == 'pending')
                                            <form action="javascript:void(0)" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn p-2 btn-outline-success appointment-confirm-btn ladda-button" data-style="expand-right" data-id="{{ $appointment->id }}">Confirm</button>
                                            </form>

                                            <form  action="javascript:void(0)" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn p-2 btn-outline-danger appointment-cancel-btn ladda-button" data-style="expand-right" data-id="{{ $appointment->id }}">Cancel</button>
                                            </form>
                                        @endif
                                        </div>
                                    </td>
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