
<div class="row mt-0 pt-0">
        <div class="col-md-12"> 
           <x-admin.card >
                <div class="table-responsive  mt-2 pt-2">
                    <p class="table-light p-2 font-1rem"><strong>Name : </strong>&nbsp;  {{$info->surname." ".$info->firstname}}</p>

                    <ul class="m-3 font-1rem">
                        <li class="m-3"><strong>History:</strong> {{ $info->history->history ?? 'N/A' }}</li>
                        <li class="m-3"><strong>Family History:</strong> {{ $info->history->family_history ?? 'N/A' }}</li>
                        <li class="m-3"><strong>Drug History:</strong> {{ $info->history->drug_history ?? 'N/A' }}</li>
                        
                    </ul>
                    <hr class="border-gray-300 mt-1 table-light p-2" />
                    <button onclick="$('.user_id').val('{{$info->id}}'),populateCustomerMedicalHistory('{{$info->id}}')" data-toggle="modal" data-target="#update-medical-history" type="" class="btn btn-outline-primary p-2 pull-right">Update Medical History &nbsp; <span class="pe pe-7s-pen pe-2x"></span></button>
                </div>
            </x-admin.card>           
        
    </div>
  
</div>
