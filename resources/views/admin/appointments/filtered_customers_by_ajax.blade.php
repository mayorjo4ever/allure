<div class="table-light w-100 mt-1 mb-1 pt-1 pb-1 font-weight-600"><center > {{ count($students)}} Records Found </center></div>
<table class="align-middle mb-0 table table-borderless table-sm table-hover dataTable">
            <thead>
            <tr>                               
                <th>Name </th>               
                <th>HMO</th>                                                                                                            
            </tr>
            </thead>
            <tbody> @foreach($students as $student)
            <tr>                
                <td class="text-uppercase">
                    <a  target="_blank" style="font-size: 1.1rem" href="{{url('admin/appointment/new/'.base64_encode($student['id']))}}" class="btn btn-outline-primary p-3  font-weight-600 btn-block">    
                     <small>Schedule :&nbsp; &nbsp; </small>
                    {{ $student['surname']." ".$student['firstname']." ".$student['othername']}} 
                    &nbsp; &nbsp; <small>With Card No:&nbsp; &nbsp; </small>
                    {{ $student['regno']}}
                </a>
                </td>                           
                <td class="text-capitalize"> <strong> {{  $student['hmo'] }} </strong> <br/> <span class="text-primary">{{  $student['enrole_no'] }} </span>
                &nbsp; &nbsp; 
                @if($student['family_host']==1)
                <?php $code = base64_encode($student['id']."_".$student['family_id']);?>
                <a title="Add More Members To The Family" href="{{url('admin/family-members/'.$code)}}" target="_blank" class="btn btn-icon-only btn-success">&nbsp;<span class="pe pe-7s-plus font-1rem text-white font-weight-900"></span></a>
                @endif
                </td>                 
                </tr>
                    @endforeach
                </tbody>
        </table>