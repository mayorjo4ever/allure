@extends('admin.arch_layouts.layout')
@section('content')
<div class="row mt-0 pt-0">
        <div class="col-md-12">
           @include('admin.arch_widgets.alert_messanger')
           @can('process-pending-ticket')
        <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
                <div class="card-body">
                   @include('admin.tickets.process.input_result_view')
               </div> 
            </div> <!-- ./ card-body -->

        </div>
           @else
           <x-unauthorized-page></x-unauthorized-page>
        @endcan
    </div>
</div>

@endsection