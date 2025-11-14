@extends('admin.arch_layouts.layout')
@section('content')
<div class="row mt-0 pt-0">
    <div class="col-md-12"> 
     
        <div class="main-card ml-4 pl-4 mt-0 pt-0 mb-4 pb-4 mr-4 pr-4 card">
            <div class="card-header"> Members
                <span class="">{{"" }}</span>
            </div>
            <?php $members = App\Models\User::where('family_id',$fam_info[1])->get(); ?>
            <div class="card-body">
                <table class="table dataTable">
                    <thead class="table-dark font-weight-bold">
                            <tr>
                                <td>SN</td>
                                <td>Reg No</td>
                                <td>Name</td>
                                <td>Position</td>
                                <td>Medical Histories</td>
                                <td>Date Added </td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($members as $k=>$member)
                            <tr>
                                <td>{{$k+1}}</td>
                                <td>{{$member->regno}}</td>
                                <td>{{$member->surname." ".$member->firstname." ".$member->othername}}</td>
                                <td class="text-capitalize">{{$member->family_position}}</td>
                                <td></td>
                                <td>{{$member->created_at}}</td>
                            </tr>
                            @endforeach
                             
                        </tbody>
                    </table>
                
                <div class="mt-4 pt-4">
                    <button onclick="reset_custom_search(),set_fam_id($(this).attri('data-text')))" type="button" data-toggle="modal" data-target="#add-family-dependant" data-text="{{$fam_info[1]}}" class="btn btn-dark btn-lg p-3 m-3 font-weight-bold"><span class="pe pe-7s-add-user pe-2x"></span> <br/> Add More Members </button>
                </div>
            </div>
           
        </div> 


    </div>
</div>
@endsection 