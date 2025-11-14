@extends('admin.arch_layouts.layout')
@section('content')
<div class="row mt-0 pt-0">
   <div class="col-md-12">
      @include('admin.arch_widgets.alert_messanger')
      @can('process-tests')
      
      <x-admin.card header="{{$page_info['title']}}">
            <div class="row">
                  @foreach ($pendingTests as $patientId => $appointments)
                  @php $patient = $appointments->first()->first()->patient; @endphp

                  <div class="col-12">
                    <x-admin.card header="{{$patient->surname}} {{$patient->firstname}}  -  {{$patient->regno}}">
                          @foreach ($appointments as $appointmentId => $tests)
                            @php $appointment = $tests->first()->appointment; @endphp
                             <div class="border-bottom p-2">
                                <div class="d-flex justify-content-start align-items-center  mb-3">
                                    <strong>Appointment : #{{ $appointment->id }}</strong> &nbsp; &nbsp; 
                                    Doctor: &nbsp; &nbsp; <b>{{ $appointment->doctor->surname." ".$appointment->doctor->firstname }}</b>
                                    &nbsp; &nbsp; &nbsp; 
                                    <b>Date:</b>&nbsp; &nbsp; {{ $appointment->created_at->format('D d M Y, h:i A') }}
                                </div>
                                 <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Test Name</th>
                                        <th>Price (₦)</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tests as $i => $test)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <th>{{ $test->template->name }}</th>
                                            <td>{{ number_format($test->template->price, 2) }}</td>
                                            <td>
                                                <span class="badge table-warning p-3  text-dark">
                                                    {{ ucfirst($test->status) }}
                                                </span>
                                            </td>
                                            <td> <!-- test_id, patient_id, apppontment_id -->
                                                @php $param = base64_encode($test->id."|".$patient->id."|".$appointment->id);  @endphp
                                                <a target="_blank" href="{{ url('admin/tests/result-computation/'.$param) }}"
                                                class="btn btn-lg btn-outline-primary p-2">
                                                    Process Result
                                                </a>
                                                
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                 </table>
                             </div>
                        @endforeach
                    </x-admin.card>
                      <pre>
                      <?php #  print_r($appointments->toarray()); ?>
                      </pre>
                  </div>
                 @endforeach
            </div><!--./ row -->      
      </x-admin.card> 
        @else 
            <x-un-authorized-page/>
        @endcan
      
    </div>
   </div>
@endsection
