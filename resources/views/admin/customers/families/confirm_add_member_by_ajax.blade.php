<div class="row">
    <div class="col-md-12">
        <p class="h4 text-danger mb-3">Please confirm if this Customer is part of the family </p>
        <table class="table">
            <thead>
            <tr class="bg-dark text-white font-weight-bold">
                <td>Registration No.</td>
                <td>Name</td>
                <td>Gender</td>
                <td>Position</td>
            </tr></thead>
             <tbody>
            <tr class="">
                <td>{{$customer['regno']}} 
                 <input type="hidden" name="my_id" id="my_id" value="{{$customer['id']}}" />
                </td>
                <td>{{$customer['surname']." ".$customer['firstname']}}</td>
                <td class="text-capitalize">{{$customer['sex']}}</td>
                <td>{{$customer['family_position']}}</td>
            </tr></tbody>
        </table>
    </div>
    
</div>