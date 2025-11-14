<div class="table-light w-100 mt-1 mb-1 pt-1 pb-1 font-weight-600"><center > {{ count($students)}} Records Found </center></div>
<table class="align-middle mb-0 table table-borderless table-sm table-striped table-hover dataTable">
            <thead>
            <tr>
                <th class="pl-4"># ID </th> 
                <th>Reg.No </th>
                <th>Surname </th>
                <th>First Name </th>
                <th>Other Name </th>
                <th>HMO</th>                
                <!--<th>Email </th>-->                
                <th>Phone </th>                                
               @can('edit-customer') <th>Edit  </th>@endcan
                <th>Last Updated </th>
            </tr>
            </thead>
            <tbody> @foreach($students as $student)
            <tr>
                <td class="text-muted pl-4"># {{ $student['id']}} </td>
                <td class="text-muted pl-4">{{ $student['regno']}} </td>                
                <td class="text-uppercase"> {{ $student['surname']}} </td> 
                <td class="text-capitalize"> {{ $student['firstname']}} </td>                 
                <td class="text-capitalize"> {{  $student['othername'] }}  </td> 
                <td class="text-capitalize"> <strong> {{  $student['hmo'] }} </strong> <br/> <span class="text-primary">{{  $student['enrole_no'] }} </span>
                &nbsp; &nbsp; 
                @if($student['family_host']==1)
                <?php $code = base64_encode($student['id']."_".$student['family_id']);?>
                <a title="Add More Members To The Family" href="{{url('admin/family-members/'.$code)}}" target="_blank" class="btn btn-icon-only btn-success">&nbsp;<span class="pe pe-7s-plus font-1rem text-white font-weight-900"></span></a>
                @endif
                </td> 
                <!-- <td>{{ $student['email']}} </td>-->
                <td>{{ $student['phone']}} </td>                                                 
                @can('edit-customer')<td>
                    <a class="" target="_blank" student_id="{{ $student['id']}}" href="{{url('admin/add-edit-customer/'.$student['id']) }}">
                        <i class="pe-7s-pen pe-2x text-danger" status="active"></i> </a>
                </td>@endcan
                <td> {{ \Carbon\Carbon::parse($student['updated_at'])->diffForHumans()}}</td>
                </tr>
                    @endforeach
                </tbody>
        </table>