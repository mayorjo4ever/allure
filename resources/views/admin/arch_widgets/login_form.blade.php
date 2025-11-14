<form class="needs-validation" novalidate id="loginForm" action="javascript:;" method="post">@csrf
    <div class="row mt-0 pt-0">

   <div class="col-lg-5 col-12 h-100">

   <div class="card mb-4 mt-5 w-100  ml-lg-5 bg-dots-darker" style="min-height: 12rem; border-radius: 2rem"><div class="card-body">
           <center><img style="height:90px" src="{{asset('template/arch/assets/images/logo.jpg') }}"> </center>
     <center><span class="card-title text-dark font-2rem"> {{ str_replace("_", " ",env('APP_NAME')) }} &nbsp;</span> </center>
     <center><span class="card-title text-dark font-1rem"> <small>{{ str_replace("_", " ",env('SUB_APP_NAME')) }} </small> &nbsp;</span> </center>
      <div class="form-row">
         <div class="col-md-12 mt-4 mb-2">
            <input type="text" name="username" id="username" class="form-control font-1-5rem h-3-rem"  placeholder="Username / Email " required >
            <div class="invalid-feedback text-danger font-14">
               Provide Your Email / Username
            </div>
         </div> <!-- ./ col-md-4 -->

         <div class="col-md-12 mt-4 mb-3">
           <input type="password" name="password" id="user-password" class="form-control font-1-5rem h-3-rem" placeholder="Password" required >
            <div class="invalid-feedback text-danger font-14">
               Provide Your Password
            </div>
           
           <div class="mt-4 custom-checkbox custom-control custom-control-inline font-weight-500 font-1rem">
               <input type="checkbox" onclick="toggleShowPassword()" class="custom-control-input " name="custom_password" id="custom_password" >
                <label class="custom-control-label" for="custom_password">
                 Show Password  </label>
            </div>
           
         </div> <!-- ./ col-md-4 -->

         <div class="col-md-12 mt-2 mb-3">
         <button class="pt-2 mb-3 btn btn-primary btn-shadow btn-lg w-100  login-btn ladda-button h-3-rem" data-style="zoom-in" type="submit"> <strong>  Login  </strong></button>
          </div> <!-- ./ col-md-3 -->
      </div><!-- ./ form-row -->
    </div>
</div></div>

</div>

</form>