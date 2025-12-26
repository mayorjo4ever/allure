<?php 
use Illuminate\Support\Facades\Session;
?>
@extends('admin.arch_layouts.layout')
@section('content')

<div class="row mt-0 pt-0">
        <div class="col-md-12"> 
            @include('admin.arch_widgets.alert_messanger')
            @can('view-customers')      
            
            <x-admin.card header="Recent Consultants">
               <form method="post"> @csrf <div class="form-row">
                    <div class="col-md-3 h5 align-right pull-right">
                        Select Status : 
                    </div>
                       <?php $options = ['pending'=>'New','confirmed'=>'Approved','checked_in'=>'Waiting For Doctor','in_consultation'=>'With Doctor','completed'=>'Done'] ?>
                    <div class="col-md-5">
                        <select name="app_status" class="form-control form-control-lg">
                            @foreach($options as $k=>$v)
                            <option value="{{$k}}" @selected(Session::get('app_staus') == $k)>{{$v}}</option>                                    
                            @endforeach      
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary p-3">View</button>
                    </div>
                   
                </div>
                 </form>    
                <div class="table-responsive  mt-2 pt-2 filtered_customers ">
                    <table class="table table-bordered" >
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Doctor</th>
                                <th>Patient</th>
                                <th>Date</th>                                
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($appointments as $appointment)
                                <tr id="row_{{ $appointment->id }}">
                                    <td> {{ $loop->iteration + ($appointments->currentPage() - 1) * $appointments->perPage() }}</td>
                                    <td>{{$appointment->doctor->title." ". $appointment->doctor->surname." ".$appointment->doctor->firstname." ".$appointment->doctor->othername  }}</td>
                                    <td> <span class="font-weight-500">{{ $appointment->patient->surname." ".$appointment->patient->firstname." ".$appointment->patient->othername }}</span>
                                        <br/> <small>{{$appointment->patient->regno }}</small>
                                        <br/> <strong> {{$appointment->ticketno }} </strong>
                                    </td>
                                    <td> <span class="font-weight-500">{{ $appointment->human_date }} </span>
                                        <br/> <small> {{ $appointment->appointment_date->format('Y-m-d') }}  &nbsp; 
                                            {{ $appointment->appointment_date->format('H:i A') }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge p-3 status
                                            @if($appointment->status == 'pending') table-warning
                                            @elseif(in_array($appointment->status,['confirmed','checked_in','in_consultation','in_consultation'])) table-success
                                            @elseif(in_array($appointment->status,['completed','checked_out'])) btn-primary
                                            @else table-danger @endif">
                                           
                                            @if($appointment->status == 'completed')
                                              @can('admit-patient') 
                                                <a target="_blank" href="{{url('admin/appointments/'.$appointment->id.'/admitted')}}" class="text-white p-3 btn-sm">{{ 'Re-Admit' }} </a> 
                                              @endcan
                                              @else
                                               {{ ucfirst($appointment->status) }}
                                            @endif
                                            
                                        </span>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    {{-- Pagination links --}}
                    <div class="d-flex justify-content-center">
                      {{ $appointments->links('vendor.pagination.architectui') }}

                    </div>
                    
                </div>
            </x-admin.card>    
            
        @else 
            <x-un-authorized-page/>
        @endcan
        
    </div>
</div>

@endsection 