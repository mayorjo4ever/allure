<!--<pre></pre>-->
<?php  #print_r($default_note->toarray());

$comment = $appointment->consultation->complaint ?? ""; 
if(empty($appointment->consultation->complaint)):
    $comment = $default_note->notes; 
endif;
 
?>

<div class="row pb-2 mb-2">
    <div class="col-md-12">
        <div class="input-group">
            <label class="form-label font-weight-500">Diagnosis &nbsp; &nbsp; </label><br/>
            <input type="text" id="patient_diagnosis" name="patient_diagnosis" class="form-control" placeholder="What Are You Diagnosing ?"/>
            <button type="button" onclick="save_diagnosis()" class="btn btn-primary btn-lg p-2 diagnosis-btn ladda-button" data-style="expand-right">Save &nbsp; <i class="fa fa-save"></i> </button>
        </div>
    </div>
</div>

<a href="javascript:void(0)" onclick="repopcomment('{{$comment}}')"  data-toggle="modal" data-target="#write-doctors-report" class="font-weight-700"> View / Write More Notes  &nbsp; <span class="pe pe-7s-pen pe-2x"></span></a>

<div class="mt-3  pt-3"></div>
{!! Str::limit($comment, 50, 'More...')!!}
