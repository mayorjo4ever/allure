<option value="">...</option>
@foreach($bodies as $body)
<option value="{{$body->id}}">{{$body->name}} - {{$body->enrole_no}} </option>
@endforeach