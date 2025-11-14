<div class="mb-3 col-md-6 border-left">
    <label class="form-label font-weight-600">{{ $field->label }}</label> <br/>

    @switch($field->type)

        {{-- Basic text input --}}
        @case('text')
            <input type="text" name="{{ $prefix }}" class="form-control-lg w-100">
            @break

        {{-- Number input --}}
        @case('number')
            <input type="number" step="any" name="{{ $prefix }}" class="form-control-lg  w-100">
            @break

        {{-- Textarea --}}
        @case('textarea')
        <textarea rows="3" name="{{ $prefix }}" class="form-control-lg w-100"></textarea>
            @break

        {{-- Select dropdown --}}
        @case('select')
            @php $options = json_decode($field->options, true) ?? []; @endphp
            <select name="{{ $prefix }}" class="form-control-lg w-100">
                <option value="">-- Select Option --</option>
                @foreach ($options as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
            @break

        {{-- File upload (images/scans) --}}
        @case('file')
            <input type="file" name="{{ $prefix }}" class="form-control-lg w-100">
            @break 
            
              @case('file')
            <input type="file" name="results[{{ $field->id }}][]" class="form-control" multiple>

            {{-- Show existing uploaded files --}}
            @if ($existing && $existing->files->count())
                <div class="mt-2">
                    @foreach ($existing->files as $file)
                        <div class="d-inline-block me-2">
                            <a href="{{ asset($file->file_path) }}" target="_blank">
                                <img src="{{ asset($file->file_path) }}" 
                                     alt="Uploaded file" 
                                     style="width: 100px; height: 100px; object-fit: cover; border-radius: 10px;">
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
            @break

        {{-- Left-Right paired values (Eyes) --}}
        @case('left_right')
            <div class="row">
                <div class="col-6">
                    <small class="fw-bold">Left</small>
                    <input type="text" name="{{ $prefix }}[left]" class="form-control-lg w-100">
                </div>

                <div class="col-6">
                    <small class="fw-bold">Right</small>
                    <input type="text" name="{{ $prefix }}[right]" class="form-control-lg w-100">
                </div>
            </div>
            @break

    @endswitch
</div>
