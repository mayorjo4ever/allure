@extends('admin.arch_layouts.layout')
@section('content')
<div class="row mt-0 pt-0">
        <div class="col-md-12">
            @include('admin.arch_widgets.alert_messanger')
           @can('process-pending-ticket')
        <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
            <div class="card-body">
                <ul class="tabs-animated-shadow tabs-animated nav">
                    <li class="nav-item">
                        <a role="tab" onclick="" class="nav-link show active" id="tab-c-0" data-toggle="tab" href="#tab-animated-0" aria-selected="true">
                       <span> &nbsp; Compute The  Results </span>
                       </a>
                    </li>

                    <li class="nav-item">
                       <a role="tab" onclick=""  class="nav-link show" id="tab-c-1" data-toggle="tab" href="#tab-animated-1" aria-selected="false">
                       <span>&nbsp; Results Summary </span>
                       </a>
                    </li>
                 </ul>

                 <div class="tab-content mt-4">
                    <div class="tab-pane show active" id="tab-animated-0" role="tabpanel">
                       @include('admin.tickets.process.input_result_view')
                    </div>
                    <div class="tab-pane show" id="tab-animated-1" role="tabpanel">
                       @include('admin.tickets.process.result_summary_view')
                    </div>

                 </div>

            </div> <!-- ./ card-body -->

        </div>
           @else
           <x-unauthorized-page></x-unauthorized-page>
        @endcan
    </div>
</div>

@endsection