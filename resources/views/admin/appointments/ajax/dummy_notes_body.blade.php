<!--<pre></pre>-->
<?php  #print_r($default_note->toarray());

$comment = $appointment->consultation->complaint ?? ""; 
if(empty($appointment->consultation->complaint)):
    $comment = $default_note->notes; 
endif;

?> 

<textarea name="dummy_notes" id="dummy_notes">
   {{$comment}}
</textarea>
