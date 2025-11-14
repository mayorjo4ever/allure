<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use function redirect;
use function request;
use function response;
use function url;
use function view;


class LoginController extends Controller
{
    protected $username;

    public function __construct() {
        $this->username = $this->getUsername();
    }

    protected function getUsername() {
        $username = request()->input('username');
        $field_type = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'regno';
        request()->merge([$field_type =>$username]);
        return $field_type;
    }
//
//    public function username(){
//        return $this->username;
//    }


    public function login(Request $request) {
        // confirm if admin has already logged in
        if(Auth::guard('admin')->check()){
            return redirect('admin/dashboard');
        }
        if($request->ajax()){
            $data = $request->all();
           // print_r($data); die;

          // $rules = ['email' => 'required|email|max:100', 'password' => 'required'];
          // $customMessage = ['email.required'  => 'Email is required','email.email' => 'Valid email is required',
          //    'password.required' => 'Password is required'];
          //  $validator = Validator::make($data, $rules,$customMessage);

           //if($validator->fails()){ // or use $validator->passes()
            //    return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            //}
            // else {

             if(Auth::guard('admin')->attempt([$this->username=>$data['username'],'password'=>$data['password']])){
                    $redirectTo = url('/admin/dashboard');
                    return response()->json(['type'=>'success','url'=>$redirectTo,'message'=>"Login successful - redirecting..."]);
               }
                else {
                      return response()->json(['type'=>'incorrect','message'=>"Invalid login parameters"]);
                 }
            }
          #  Admin::where(['regno'=>'isaac'])->update(['password'=>Hash::make('123456')]);
        return view('admin.login');
    }

    ##
     public function logout(Request $request) : RedirectResponse {

        if(Auth::guard('admin')->check()){
            Auth::guard('admin')->logout();
        }
        $request->session()->invalidate();
        Session::flush();
        $request->session()->regenerateToken();

	return redirect('/');
    }

}
