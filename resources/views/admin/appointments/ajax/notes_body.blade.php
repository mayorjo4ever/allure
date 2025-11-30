<!--<pre></pre>-->
<?php  #print_r($default_note->toarray());

$comment = $appointment->consultation->complaint ?? ""; 
if(empty($appointment->consultation->complaint)):
    $comment = $default_note->notes; 
endif;

?> 
{!! Str::limit($comment, 50, '** Click Button Below To Read More **')!!}

<button type="button" onclick="repopcomment('{{$comment}}')"  data-toggle="modal" data-target="#write-doctors-report" class="btn {{ empty($comment) ?'btn-info':'btn-success' }} btn-rounded rounded btn-block"> View / Write Notes  &nbsp; <span class="pe pe-7s-pen pe-2x"></span>  </button>