    @if(Session::has('success_message'))
      <div class="alert alert-success fade show  " data-dismiss="alert" role="alert"> 
         <button type="button" class="close" ><span aria-hidden="true">×</span></button>
         <span class="pe-7s-check pe-2x"></span> &nbsp;&nbsp; <strong> {{Session::get('success_message')}} </strong> 
      </div>
    @endif
      
    @if(Session::has('error_message'))
        <div class="alert alert-danger fade show " data-dismiss="alert" role="alert"> 
           <button type="button" class="close"><span aria-hidden="true">×</span></button>
           <span class="pe-7s-attention pe-2x"></span> &nbsp;&nbsp; <strong> {{Session::get('error_message')}} </strong> 
        </div>
    @endif
      
    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
      @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        <button type="button" class="close" data-dismiss="alert" > <span>&times </span> </button>
     </div>
     @endif
      