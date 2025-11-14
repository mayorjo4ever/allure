<?php use Carbon\Carbon;  ?>
 
@extends('admin.arch_layouts.layout')
@section('content')


<div class="row mt-0 pt-0">
    <div class="col-md-12">
        @include('admin.arch_widgets.alert_messanger')
        
         <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
         <div class="card-header">{{$page_info['title']}} </div>
         <div class="card-body">
             @include('admin.reports.forms.daily_form_filter')
             
             <div class="report_view"></div>
         </div>
         <!-- ./ card-body -->     
        
    </div>
</div>
 

@endsection