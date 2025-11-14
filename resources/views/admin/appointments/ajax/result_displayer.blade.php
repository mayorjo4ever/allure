
     <h5 class="mb-3">     
        <strong>{{users_name($investigation->patient_id)}}</strong>&nbsp;  :      
    
     {{ $investigation->template->name }}  Result  </h5>
    <hr>
   
    <div class="card shadow-sm">
        <div class="card-body">
            @foreach ($investigation->template->fields as $field)
                @php
                    $result = $resultsByField->get($field->id);
                @endphp

                <div class="mb-4 col-md-6 float-left border-bottom pb-3">
                    <h6 class="text-primary mb-1">{{ $field->label }}</h6>

                    {{-- Display Result Value --}}
                    <p class="mb-2">
                        <strong>Result:</strong> 
                        {{ $result?->value ?? '—' }}
                    </p>

                    {{-- Display Uploaded Files --}}
                    @if (!empty($result?->files))
                        <div class="row">
                            @foreach ($result->files as $file)
                                @php
                                    // Build correct public URL for the saved image
                                    $imageUrl = asset($file['file_path']);
                                @endphp

                                <div class="col-md-6 col-6 mb-3">
                                    <div class="border rounded p-2 text-center bg-light">
                                        <a href="{{ $imageUrl }}" target="_blank">
                                            <img src="{{ $imageUrl }}"
                                                 alt="Scanned Result"
                                                 class="img-fluid rounded mb-2"
                                                 style="height: 120px; object-fit: cover;">
                                        </a>
                                        <div>
                                            <a href="{{ $imageUrl }}" 
                                               target="_blank" 
                                               class="small text-muted">
                                               View full image
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
<pre>
    <?php #  print_r($investigation->toArray());?>
</pre>
     