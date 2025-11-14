<div class="row"><div class="col-md-12">
    <table class="table table-sm table-bordered rounded text-capitalize" >
        <tr>
            <td><strong class="text-primary text-uppercase font-13"> Patient Name:  </strong> &nbsp;&nbsp; @php $user = users_info($ticket_info[0]['customer_id'])@endphp
            {{$user['fullname']}}</td>
            <td><strong class="text-primary text-uppercase font-13"> Sex: </strong> &nbsp;&nbsp;{{$user['sex']}}</td>
        </tr>
        <tr> <td><strong class="text-primary text-uppercase font-13">  Date of Birth: </strong> &nbsp;&nbsp;{{$user['dob']}}</td>

            <td><strong class="text-primary text-uppercase font-13"> LAB ID Number: </strong>&nbsp;&nbsp; {{$ticket_info[0]['ticket_no']}}</td>
        </tr>
        <tr><td><strong class="text-primary text-uppercase font-13"> Telephone: </strong>&nbsp;&nbsp; {{$user['phone']}}</td>
            <td><strong class="text-primary text-uppercase font-13"> Age: </strong> {{ calc_age($user['dob'],$ticket_info[0]['date_collected']) }}</td>

        </tr>
        <tr>
            <td><strong class="text-primary text-uppercase font-13"> Hospital ID: </strong> &nbsp;&nbsp;{{ $user['regno'] }}</td>
            <td><strong class="text-primary text-uppercase font-13">  Referred By: </strong>&nbsp;&nbsp;</td>
        </tr>
        <tr> <td colspan="2"><strong class="text-primary text-uppercase font-13"> Patient Email:</strong> &nbsp;&nbsp;{{$user['email']}}</td>
        </tr>

    </table>
   </div>
</div>