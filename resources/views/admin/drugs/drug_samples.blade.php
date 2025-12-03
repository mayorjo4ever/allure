@extends('admin.arch_layouts.layout')
@section('content')
 
<div class="row mt-0 pt-0">
        <div class="col-md-12">

        @include('admin.arch_widgets.alert_messanger')
        @can('view-drugs')
        
        <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
            <div class="card-header">Available Drugs
            <div class="btn-actions-pane-right">
                    <div role="group" class="btn-group-sm btn-group">
                        <button onclick="showInactiveTables()" class="active btn btn-focus gap-5">Show Deleted Drugs</button>
                        <button onclick="hideInactiveTables()" class="btn btn-focus gap-5">Hide Deleted Drugs</button>
                    </div>
                </div>  
            </div>

        <div class="table-responsive  mt-2 pt-2 ">
        <table class="align-middle mb-0 table table-borderless table-striped table-hover dataTable">
            <thead>
            <tr>
                <th class="pl-4"># ID </th>               
                <th>Name</th>
                <th>Features </th>
                <th>Category</th>                
                <th>Sales Price </th>               
                @can('modify-drugs')<th>Status</th> @endcan
                @can('edit-drugs') <th>Edit </th> @endcan
                <th>Last Updated </th>
            </tr>
            </thead>
            <tbody> @foreach($drugs as $drug )
            <tr class="{{ ($drug['status']==1) ?"active":"inactive" }}">
                <td class="text-muted pl-4"># {{ $drug['id']}} </td>               
                <td> 
                    @can('edit-drugs')
                    <a class="text-dark" target="_blank" href="{{url('admin/add-edit-drugs/'.$drug['id']) }}">
                         {{ $drug['name']}} </a>
                    @else
                     {{ $drug['name']}}
                    @endcan
                    </td>
                <td>  
                   <label class="font-weight-500" title=" {{ $drug['name']}}" >                    
                       Qty Rem: {{ $drug['qty_rem']}} <br/>
                       Solds : {{ ($drug['cum_qty'] - $drug['qty_rem']) }}                                       
                     </label>                   
                </td>
                <td> <a href="{{ url('admin/drugs/'.$drug['categ_id']) }}" > {{ $drugs_categs[$drug['categ_id']] }}</a> </td>
                <td> <strong> {!! "&#8358; ".number_format($drug['sales_price']) !!}  </strong> <br> 
                    <small class="text-danger"> {!! "&#8358; ".number_format($drug['purchase_price']) !!}   </small>
                </td>
                <!-- <td> {{ "N ".number_format($drug['sales_price']) }} </td>  -->
                @can('modify-drugs')
                <td>
                        @if($drug['status']==1)
                        <a class="updateDrugStatus" id="drug_id-{{ $drug['id']}}" drug_id="{{ $drug['id']}}" href="javascript:void(0)" title="Active">
                                <i class="pe-7s-check pe-2x font-weight-bold text-success " status="active"></i> Active  </a>  
                                @else <a class="updateDrugStatus" id="drug_id-{{ $drug['id']}}" drug_id="{{ $drug['id']}}" href="javascript:void(0)" title="Deleted">
                              <i class="pe-7s-attention pe-2x  text-danger font-weight-bold"  status="inactive"></i> Deleted </a> 
                         @endif
                </td>@endcan
               @can('edit-drugs') <td >
                        <a class=""  target="_blank" href="{{url('admin/add-edit-drugs/'.$drug['id']) }}">
                            <i class="pe-7s-pen pe-2x text-danger" status="active"></i> </a>
                </td> @endcan
                <td> {{ \Carbon\Carbon::parse($drug['updated_at'])->diffForHumans()}}</td>
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
