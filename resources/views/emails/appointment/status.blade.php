<x-mail::message>
# Appointment {{ ucfirst($status) }}

Hello **{{ $appointment->patient->surname." ".$appointment->patient->firstname }}**,

Your appointment scheduled for  
**{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y g:i A') }}**  
with **Dr. {{ $appointment->doctor->surname." ". $appointment->doctor->firstname }}** has been **{{ $status }}**.

@isset($appointment->notes)
> Doctor's Note: {{ $appointment->notes }}
@endisset

<x-mail::button :url="url('admin/appointments/'.$appointment->id)">
View Appointment
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>