<div class="form-row">
    @if(!empty($questions->toArray()))
    @foreach($questions as $question)
    <div class="col-md-12 mb-3 mt-3"> <form onsubmit="handleQuestionnaireResult($(this))" class="questionnaire-form" method="post" action="javascript:void(0)"> @csrf
        <p class="h5 font-weight-600">{{$question->question}}</p>
        <input type="hidden" name="quid" value="{{$question->id}}" />
        @if($question->type == "boolean")
        <div class="form-row">
            <div class="col-md-6">
                <div class="radio-wrapper-8">
                    <label class="radio-wrapper-8" for="question-p{{$question->id}}">
                      <input id="question-p{{$question->id}}"  value="yes" type="radio" name="answer-{{$question->id}}">
                      <span>Yes</span>
                    </label>
                  </div>
                <div class="radio-wrapper-8">
                    <label class="radio-wrapper-8" for="question-q{{$question->id}}">
                      <input id="question-q{{$question->id}}" value="no" type="radio" name="answer-{{$question->id}}">
                      <span>No</span>
                    </label>
                  </div>               
            </div>             
        </div>
        
        @elseif($question->type == "choice")
        @php $options = json_decode($question->options,true); @endphp
        @foreach($options as $k=>$option)
        <div class="checkbox-wrapper-13">
            <input id="c1-{{$k}}" value="{{$option}}" type="checkbox" name="answers[{{$k}}][]">
            <label for="c1-{{$k}}">{{$option}}</label>
          </div>
        @endforeach
        
            @elseif($question->type == "text")
            <div class="">
                <input type="text" name="answer-{{$question->id}}" class="form-control-lg w-100 p-2" placeholder="Write The Response from Patient " />
            </div>
        @endif
        <div class="mt-3">            
            <button type="submit" class="btn btn-secondary w-50 ladda-button" > Submit </button>
        </div>
        </form>
    </div>
    
       
    
   @endforeach
   @else
     <div class="col-md-12">
         <span class="text-danger font-1rem"> No Question Matches Your Input </span>
    </div>
   @endif
   
   
</div>
