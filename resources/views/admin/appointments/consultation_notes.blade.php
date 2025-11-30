<?php 
use Illuminate\Support\Facades\Session;
?>
@extends('admin.arch_layouts.layout')
@section('content')

<div class="row mt-0 pt-0">
        <div class="col-md-12"> 
            @include('admin.arch_widgets.alert_messanger')
            @can('view-consultation-notes')      
            
            <x-admin.card header="Manage Consultation Notes">
                <form method="post" action="{{url('admin/appointments/consultationnotes')}}"> @csrf <div class="form-row">
                 <div class="table-responsive  mt-2 pt-2 ">
                    <table class="table table-bordered" >
                         
                        <tbody>
                                <tr>
                                    <td>
                                        <textarea id="complaint_forms" name="complaint_forms">{!! $notes->notes !!}</textarea>
                                    </td> 
                                </tr>
                                @can('edit-consultation-notes')
                                <tr>
                                    <td>
                                        <button class="btn btn-success btn-block p-2"> <strong>Update Notes </strong> </button>
                                    </td>
                                </tr>
                                @endcan
                        </tbody>
                    </table>
                    </div>
                   </div>
                 </form> 
               </form> 
                    
                </div>
            </x-admin.card>    
            
        @else 
            <x-un-authorized-page/>
        @endcan
        
    </div>
</div>

@endsection 