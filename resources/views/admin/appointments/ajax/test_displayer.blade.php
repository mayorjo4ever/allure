<div class="form-row">
    @if(!empty($tests->toArray()))  <?php $n=1; ?>
   
    @foreach($tests as $test)     
    <p class="table w-100 table-hover"><form onsubmit="addPatientInvestigation($(this))" class="investigation-form" method="post" action="javascript:void(0)"> @csrf
        {{$n}}  &nbsp; &nbsp;
          <input type="hidden" name="test_id" value="{{$test->id}}" />
         {{$test->name}} &nbsp; &nbsp;
         <small>( &#8358; {{number_format($test->price)}} )</small> &nbsp; &nbsp;
        <button type="submit" class="btn btn-outline-primary btn-lg"> Add &nbsp; <span class="pe pe-7s-plus"></span></button></td>
        </form>
    </p>
    
    <?php $n++; ?>
   @endforeach
   
   @else
     <div class="col-md-12">
         <span class="text-danger font-1rem"> No Investigation Matches Your Input </span>
    </div>
   @endif
   
   
</div>
