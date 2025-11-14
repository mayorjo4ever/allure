<div class="mb-3 col-md-5 border-left">
        <label class="form-label font-weight-600">{{ $field->label }}</label>

    @switch($field->type)
        @case('text')
            <input type="text" name="results[{{ $field->id }}]" value="{{ $existing?->value }}" class="form-control-lg w-100">
            @break

        @case('number')
            <input type="number" step="any" name="results[{{ $field->id }}]" value="{{ $existing?->value }}" class="form-control-lg w-100">
            @break

        @case('textarea')
            <textarea name="results[{{ $field->id }}]" class="form-control-lg w-100">{{ $existing?->value }}</textarea>
            @break

        @case('select')
            @php $options = json_decode($field->options, true) ?? []; @endphp
            <select name="results[{{ $field->id }}]" class="form-control-lg w-100">
                <option value="">-- Select Option --</option>
                @foreach ($options as $option)
                    <option value="{{ $option }}" {{ $existing?->value == $option ? 'selected' : '' }}>
                        {{ $option }}
                    </option>
                @endforeach
            </select>
            @break

        @case('file')
            <input type="file" name="results[{{ $field->id }}][]" class="form-control-lg w-100" multiple accept="image/*">

            {{-- Show existing uploaded files --}}
            @if($existing && $existing->files->count())
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
    @endswitch
</div>
