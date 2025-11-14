<?php 
    use App\Models\Subject; 
?>
@extends('admin.arch_layouts.layout')
@section('content')

<div class="row mt-0 pt-0">
        <div class="col-md-12"> 
            @include('admin.arch_widgets.alert_messanger')
           <x-admin.card header="{{$page_info['title'] }}">
                <div class="table-responsive  mt-2 pt-2 filtered_customers ">
                    <table class="table table-bordered  dataTable" >
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Question</th>
                                <th>Answer Type</th>
                                <th>Answer</th>
                                @can('modify-questionnaire')<th>Status</th>@endcan
                                @can('edit-questionnaire') <th>Edit </th> @endcan
                                <th>Last Updates</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $altNames = ['text'=>'Provide Answer','choice'=>'Multiple Choice Answer','boolean'=>'Yes / No']; @endphp
                            @foreach($questionnaires as $questionnaire)
                                <tr id="row_{{ $questionnaire->id }}">
                                    <td>{{$questionnaire->id }}</td>
                                    <td>{{$questionnaire->question }}</td>
                                    <td>{{ $altNames[$questionnaire->type] }}</td>
                                    <td>{{ ($questionnaire->type=='text')? $questionnaire->default_answer :'' }}</td>
                                    @can('modify-questionnaire')<td>
                                        @if($questionnaire['status']==1)
                                           <a class="updateQuestionnaireStatus" id="questionnaire_id-{{ $questionnaire['id']}}" questionnaire_id="{{ $questionnaire['id']}}" href="javascript:void(0)">
                                               <i class="pe-7s-check pe-2x font-weight-bold text-success " status="active"></i> Active </a>
                                          @else <a class="updateQuestionnaireStatus" id="questionnaire_id-{{ $questionnaire['id']}}" questionnaire_id="{{ $questionnaire['id']}}" href="javascript:void(0)">
                                             <i class="pe-7s-attention pe-2x  text-danger font-weight-bold"  status="inactive"></i> Not Active </a>
                                         @endif
                                    </td>@endcan
                                    
                                    @can('edit-questionnaire') <td>
                                     <a class="text-dark font-weight-600" target="_blank" href="{{url('admin/add-edit-questionnaire/'.$questionnaire['id']) }}">
                                           <i class="pe-7s-pen pe-2x text-danger" status="active"></i> </a>                                      
                                    </td> @endcan
                                    <td> {{ \Carbon\Carbon::parse($questionnaire['updated_at'])->diffForHumans()}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </x-admin.card>    
            
            
            
        </div>
</div>    
            
@endsection 