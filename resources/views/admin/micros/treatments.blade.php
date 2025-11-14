<?php use Carbon\Carbon;  ?>
@extends('admin.arch_layouts.layout')
@section('content')


<div class="row mt-0 pt-0">
    <div class="col-md-12">
        @include('admin.arch_widgets.alert_messanger')
        
        @can('view-microorganism-treatment')

        <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
            <div class="card-header">  {{ Session::get('subpage')}}
                 <div class="btn-actions-pane-right">
                    <div role="group" class="btn-group-sm btn-group">
                        <button onclick="showInactiveTables()" class="active btn btn-focus btn-success">Show Deleted Treatments </button>
                        &nbsp; &nbsp; <button onclick="hideInactiveTables()" class="btn btn-focus btn-danger">Hide Deleted Treatments</button>
                    </div>
                </div>  
            </div>
           <div class="table-responsive  mt-2 pt-2 ">
            <table class="align-middle mb-0 table table-borderless table-md table-striped table-hover dataTable">
                <thead>
                <tr>
                    <th class="pl-4"># ID </th>                  
                    <th> Treatments </th>                                       
                    @can('modify-microorganism-treatment') <th>  Status <br/><small>Deleted / Active </small> </th>@endcan
                    @can('edit-microorganism-treatment') <th>Edit </th> @endcan
                    <th>Last Updated </th>
                </tr>
                </thead>
                <tbody>                
                @foreach($treatments as $treatment)
                   <tr  class="{{ ($treatment['status']==1) ?"active":"inactive" }}">
                    <td class="text-muted pl-4"># {{ $treatment['id']}} </td>
                    <td class="text-muted pl-4">{{ $treatment['name']}} </td>                                        
                    @can('modify-microorganism-treatment')
                        <td>
                            @if($treatment['status']==1)
                               <a class="updateMicroTreatmentStatus" id="treatment_id-{{ $treatment['id']}}" treatment_id="{{ $treatment['id']}}" href="javascript:void(0)">
                                   <i class="pe-7s-check pe-2x font-weight-bold text-success " status="active"></i> Active </a>
                              @else <a class="updateMicroTreatmentStatus" id="treatment_id-{{ $treatment['id']}}" treatment_id="{{ $treatment['id']}}" href="javascript:void(0)">
                                 <i class="pe-7s-attention pe-2x  text-danger font-weight-bold"  status="inactive"></i> Not Active </a>
                             @endif   &nbsp; &nbsp; <span class="treatment_id-{{ $treatment['id']}} ladda-button text-dark bg-dark" data-style="expand-right"></span>
                        </td>@endcan  
                    @can('edit-microorganism-treatment') <td>
                        <a class="" target="_blank" treatment_id="{{ $treatment['id']}}" href="{{url('admin/add-edit-micro-organism-treatment/'.$treatment['id']) }}">
                            <i class="pe-7s-pen pe-2x text-danger" status="active"></i> </a>              
                    </td> @endcan
                    <td class="text-muted pl-4">{{ Carbon::parse($treatment['updated_at'])->diffForHumans()}} </td>
                   </tr>
                @endforeach 
                </tbody>
            </table>
           </div>      
        </div>   
              
        @else 
            <x-un-authorized-page/>
        @endcan
        
        </div>
</div>
@endsection

