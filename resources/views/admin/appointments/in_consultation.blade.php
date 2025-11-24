<?php 
use Carbon\Carbon;
?>
@extends('admin.arch_layouts.layout')
@section('content')
<style>
/* The container */
.container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.container .checkmark:after {
 	top: 9px;
	left: 9px;
	width: 8px;
	height: 8px;
	border-radius: 50%;
	background: white;
}
.container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
</style>
<div class="row mt-0 pt-0">
        <div class="col-md-12"> 
            @include('admin.arch_widgets.alert_messanger')
            @include('admin.arch_widgets.summernote')
            @can('admit-patient')      
            
            <x-admin.card header="{!! $page_info['title'] !!}  |  Appointment Date : {{$appointment->appointment_date}}">
          
                <div class="row">                    
                   <div class="col-md-3">
                        <button type="button" onclick="activateBtn($(this)),getPatientInfo('consultation'),add_tinymce()" class="btn btn-outline-info allBtn p-3 w-100  font-weight-500"> Take Notes / Observations  &nbsp; <span class="pe pe-7s-pen pe-2x"></span>  </button>
                    </div>
                    
                    <div class="col-md-3">
                        <button onclick="activateBtn($(this)),getPatientInfo('profile')" type="button" class="btn btn-outline-success allBtn p-3 w-100 font-weight-500">Brief Profile  &nbsp; <span class="pe pe-7s-user-female pe-2x"></span></button>
                    </div>
                    <div class="col-md-3">
                        <button onclick="activateBtn($(this)),getPatientInfo('history')"  type="button" class="btn btn-outline-primary allBtn p-3 w-100  font-weight-500">Medical History  &nbsp; <span class="pe pe-7s-wine pe-2x"></span> </button>
                    </div>
                    
                    <div class="col-md-3">
                        <button onclick="activateBtn($(this)),getPatientInfo('appointments')"  type="button" class="btn btn-outline-info allBtn p-3 w-100  font-weight-500">Previous Appointments &nbsp; <span class="pe pe-7s-alarm pe-2x"></span> </button>
                    </div>
                
                <div class="col-md-12 mt-3 pt-3">
                    <input type="hidden" id="patient" value="{{$appointment->patient->id}}" />
                    <input type="hidden" id="app_id" value="{{$appointment->id}}" />
                    <input type="hidden" id="regno" value="{{$appointment->patient->regno}}" />
                        <h6 class="heading font-weight-600 table-light p-3">Take Notes / Observations  </h6>
                        <div class="data-body"></div>
                 
                     </div> <!-- ./ col-md-12 -->
                </div> <!-- ./ row -->
            </x-admin.card>    
                       
        @else 
            <x-un-authorized-page/>
        @endcan
        
    </div>
</div>

@endsection 