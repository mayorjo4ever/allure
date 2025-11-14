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
            <div class="card-header">Available Family Accounts
                <div class=" ml-4 pl-4 pt-3 mt-3 mb-2">                 
<!--                    <input type="text" name="all_customer_filter" id="all_customer_filter" class="w-100 block form-control font-1-5rem" placeholder="Search / Filter Customers" /> -->
                  &nbsp; &nbsp; <span class="customer-loader ladda-button text-dark bg-dark" data-style="expand-right"></span>                  
                </div> 
            </div>
        <div class="table-responsive  mt-2 pt-2 filtered_customers ">
            @include('admin.customers.filtered_customers_by_ajax')
        </div>
           
        </div> 
            
        @else 
            <x-un-authorized-page/>
        @endcan
        
    </div>
</div>

@endsection 