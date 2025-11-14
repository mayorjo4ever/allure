<?php 
# use App\Models\Subject;
?>
@extends('admin.arch_layouts.layout')
@section('content')
<div class="row mt-0 pt-0">
        <div class="col-md-12"> 
            @include('admin.arch_widgets.alert_messanger')
            @can('view-customers')
         <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
            <div class="card-header">Select Doctor </div>
            <div class="card-body mt-2 pt-2">
                <div class="row">
                    @foreach($doctors as $doctor) <div class="col-md-4">
                        <a href="javascript:void(0)" onclick="show_doctor_availability('{{$doctor->id}}','{{$user->id}}')" style="text-decoration: none;">
                        <div class="card border border-primary btn-outline-primary">
                            <div class="card-body">  <center>                             
<!--                                <img class="img img-thumbnail"/>-->
                                <h5>{{ $doctor->title. " ".$doctor->surname. " ".$doctor->firstname. " ".$doctor->othername }}</h5>
                                </center>
                            </div>
                        </div>  </a>                  
                    </div>  <!-- ./ col-md-4 -->
                @endforeach
                </div> <!-- ./ row -->
            </div>
            <input type="hidden" value="{{base64_decode($user->id)}}" id="ref_no"/>
            <hr/>            
            <div id="doctor-name" class="mb-3"></div>
            <div id="doctor-calendar" class="mt-3"></div>
            <div id="time-slots" class="mt-3"></div>
        </div> 
            
        @else 
            <x-un-authorized-page/>
        @endcan
        
    </div>
</div>

@endsection 