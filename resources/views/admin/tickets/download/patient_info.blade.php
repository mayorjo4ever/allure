<div class="row"><div class="col-md-12">
    <table class="table table-sm table-bordered rounded text-capitalize" cellspacing="0" >
        <tr>
            <td><strong class="text-primary text-uppercase font-13"> Patient Name:  </strong> @php $user = users_info($ticket_info[0]['customer_id'])@endphp
            {{$user['fullname']}}</td>
            <td><strong class="text-primary text-uppercase font-13"> Sex: </strong> {{$user['sex']}}</td>
        </tr>
        <tr> <td><strong class="text-primary text-uppercase font-13">  Date of Birth: </strong> {{$user['dob']}}</td>

            <td><strong class="text-primary text-uppercase font-13"> LAB ID Number: </strong> {{$ticket_info[0]['ticket_no']}}</td>
        </tr>
        <tr><td><strong class="text-primary text-uppercase font-13"> Telephone: </strong> {{$user['phone']}}</td>
            <td><strong class="text-primary text-uppercase font-13"> Age: </strong> {{ calc_age($user['dob'],$ticket_info[0]['date_collected']) }}</td>

        </tr>
        <tr>
            <td><strong class="text-primary text-uppercase font-13"> Hospital ID: </strong> {{ $user['regno'] }}</td>
            <td><strong class="text-primary text-uppercase font-13">  Referred By: </strong></td>
        </tr>
        <tr> <td colspan="2"><strong class="text-primary text-uppercase font-13"> Patient Email:</strong> {{$user['email']}}</td>
        </tr>

    </table>
   </div>
</div>