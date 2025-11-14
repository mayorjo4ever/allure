<?php use App\Models\State;use App\Models\Country; use App\Models\Lga; ?>
<div class="row mt-0 pt-0">
        <div class="col-md-12"> 
           <x-admin.card >
                <div class="table-responsive  mt-2 pt-2 filtered_customers ">
                    <table class="table table-bordered " >
                         <tbody>
                            <tr>                               
                                <th class="table-light" style="width:30%">Patient Name</th>
                                <td>{{$info->surname." ".$info->firstname}}</td>   </tr>
                                <tr> <th ">Registration Number:</th>
                                <td>{{$info->regno}}</td> </tr>
                                <tr><th class="table-light w-20">HMO</th>
                                <td>{{$info->hmo}} </td>  </tr>
                                <tr><th>Enrole No </th>
                                      <td>{{$info->enrole_no }}</td>
                                  </tr>
                                   <tr><th>Phone No </th>
                                      <td>{{$info->phone }}</td>
                                  </tr>
                                   <tr><th class="table-light" >Email </th>
                                      <td>{{$info->email }}</td>
                                  </tr>
                                   <tr><th >Date of Birth </th>
                                      <td>{{$info->dob }}</td>
                                  </tr> <tr><th class="table-light" >Age </th>
                                      <td>{{ calc_age($info->dob) }}</td>
                                  </tr>
                                  </tr> <tr><th  >Gender </th>
                                      <td>{{ucwords($info->sex) }}</td>
                                  </tr>
                                  </tr> <tr><th class="table-light" >Nationality </th>
                                      <td>{{Country::name($info->country_id) }}</td>
                                  </tr>
                                  </tr> <tr><th>State </th>
                                      <td>{{ State::name($info->state_id)}}</td>
                                  </tr>
                                  </tr> <tr><th class="table-light" >LGA </th>
                                      <td>{{Lga::name($info->city_id) }}
                                      </td>
                                  </tr>
                                  </tr> <tr><th>Home Address </th>
                                      <td>{{$info->residence ?? "--:--" }}</td>
                                  </tr>
                                  </tr> <tr><th class="table-light">NOK Name</th>
                                      <td>{{$info->nok_name ?? "--:--" }}</td>
                                  </tr>
                                  <tr><th class="table-light">NOK Phone </th>
                                      <td>{{$info->nok_phone  ?? "--:--"}}</td>
                                  </tr>                                  
                                  </tr> <tr><th>NOK Relationship</th>
                                      <td>{{$info->nok_relationship  ?? "--:--"}}</td>
                                  </tr> <tr>
                                  <th class="table-light">NOK Address </th>
                                      <td>{{$info->nok_address ?? "--:--" }}</td>
                                  </tr>
                                  <tr>
                                      <td colspan="2">
                                          <button onclick="$('.user_id').val('{{$info->id}}'),populateCustomerBiodata('{{$info->id}}')"  data-toggle="modal" data-target="#update-patient-profile" type="button" class="btn btn-outline-success p-2 pull-right">Update Basic Profile &nbsp; <span class="pe pe-7s-pen pe-2x"></span></button> 
                                      </td>
                                  </tr>                            
                        </tbody>
                       
                    </table>
                </div>
            </x-admin.card>           
        
    </div>
</div>
