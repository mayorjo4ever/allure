<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Models\Country;
use App\Models\CustomerTicket;
use App\Models\FamilyGroup;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use function redirect;
use function response;
use function view;


class UserController extends Controller
{
    public function userImportView() {
       Session::put('page','customers'); Session::put('subpage','customers-import');
       $page_info = ['title'=>'Import More Customers ','icon'=>'pe-7s-user','sub-title'=>'Importing Customers with ease '];
       $btns = [
           ['name'=>"View Customers",'action'=>"admin/customers", 'class'=>'btn btn-dark']           
           ];        
      # dd($subjects);
       return view('admin.customers.import_customers',compact('page_info','btns'));   
    }
    
     public function readExcel(Request $request) {        
        $data = $request->all();                
        Excel::import(new UsersImport, $data['file']);        
        ## return redirect()->back()->with('success_message','Students successfully uploaded');
        return redirect('admin/customers')->with('success_message','Customers Uploaded Successfully');
    }
    ###################################
    
    public function students() {
       Session::put('page','customers'); Session::put('subpage','customers');
       $page_info = ['title'=>'All Customers ','icon'=>'pe-7s-user','sub-title'=>'This Record Only Shows The Last 100 Customers Saved'];
       $btns = [
           ['name'=>"Add New Customer",'action'=>"admin/add-edit-customer", 'class'=>'btn btn-success']
           ];        
        $students = User::limit(100)->orderBy('id','desc')->get()->toArray(); 
       return view('admin.customers.students',compact('page_info','btns','students'));   
    }
    
    public function families() {
       Session::put('page','customers'); Session::put('subpage','families');
       $page_info = ['title'=>'All Family Accounts','icon'=>'pe-7s-user','sub-title'=>'This Record Shows Customer Accounts Which Are of Family Types'];
       $btns = [
           ['name'=>"Add New Customer",'action'=>"admin/add-edit-customer", 'class'=>'btn btn-success']
           ];        
        $students = User::where(['family_host'=>1])->limit(100)->orderBy('id','desc')->get()->toArray(); 
       return view('admin.customers.families.families',compact('page_info','btns','students'));   
    }
 
    
    public function addEditStudent(Request $request, $id=null) {        
       Session::put('page','customers'); Session::put('subpage','customer-add');
       $page_info = ['title'=>'Create New Customer ','icon'=>'pe-7s-user','sub-title'=>'Create New / Update Customer Profile '];
       $btns = [
           ['name'=>"View All Customer",'action'=>"admin/customers", 'class'=>'btn btn-dark']
          ];        
       if($id=="") {
           $student = new User; 
           $message = "Customer Profile Successfully Saved";
       }
       else {
           $page_info['title'] = "Update Customer Info ";           
           $student = User::find($id); # ->get()->toArray();
           $message = "Customer Profile Successfully Updated";
       }
       
       ## updating student info
       if($request->isMethod('post')){
           $data = $request->all();     
           
           $validator = Validator::make($request->all(),
                   ['regno'=>'required','sex'=>'required',
                       'dob'=>'required','surname'=>'required',
                       'firstname'=>'required'],
                      ['regno.required'=>'Provide Hospital Registration Number',
                       'dob.required'=>'Select Date of Birth',
                       'sex.required'=>'Select Gender']); 
           
           if ($validator->fails()) :
                    return response()->json([
                        'status' => 'error',
                        'errors' => $validator->errors()
                    ], 200); 
           endif; 
           # print "<pre>";  print_r($data);  die; 
           /**$this->validate($request, 
                   ['regno'=>'required','sex'=>'required',
                       'dob'=>'required','surname'=>'required',
                       'firstname'=>'required'],
                   ['regno.required'=>'Provide Identity Number',
                       'dob.required'=>'Select Date of Birth',
                       'sex.required'=>'Select Gender']);
            * */
               
           #get id for outsider 
            /** if($data['account_type'] =="outsider" && empty($data['init-regno'])):
                $regno =  get_new_outsider_id();
            elseif($data['account_type'] =="corporate" && empty($data['init-regno'])) :
              $regno = get_new_corporate_id();
            else:  **/
            $regno = $data['regno']; ##  endif;
               
            $student->regno = $regno;
            $student->surname = $data['surname'];
            $student->firstname = $data['firstname'];
            $student->othername = $data['othername'];
            $student->sex = $data['sex'];
            $student->dob = $data['dob'];
            $student->phone = $data['phone'];
            $student->email = $data['email'];          
            $student->password = Hash::make(strtolower($data['surname']));           
            ##### ADDING OTHER INFORMATION ##################
            $student->hmo = $data['hmo'];
            $student->occupation = $data['occupation'];
            $student->employee_address = $data['employee_address'];
            $student->residence = $data['residence'];
            $student->country_id = $data['country'];
            $student->state_id = $data['state'];
            $student->city_id = $data['city'];
            $student->nok_name = $data['nok_name'];
            $student->nok_relationship = $data['nok_relationship'];
            $student->nok_phone = $data['nok_phone'];
            $student->nok_address = $data['nok_address'];
            $student->family_position = $data['family_position'];
            # $student->family_id = $family_id; # auto generated if account is family
            $student->family_host = $data['family_host']??0; # set to one if account type is family
            $fullname = $data['surname']." ".$data['firstname']." ".$data['othername'];
            #if(isset($data['reset_password'])){
            #  $student->password = Hash::make($data['password']);
            # }
            $student->save();
            ## 
            $host_id = $student->id; //die; 
            ## save / update the family || corporate account 
            /**
           if(in_array($data['account_type'],['corporate','family']) && isset($data['family_host']) && $data['family_host']==1):
               $family = FamilyGroup::firstOrCreate(['host_id'=>$host_id]);
               $family->host_id = $host_id; 
               $family->host_name = $fullname; 
               $family->save();
               User::where('id',$host_id)->update(['family_id'=>$family->id]);
           endif;**/
           return response()->json(['status'=>'success','message'=>$message]);
           ##return redirect('admin/customers')->with('success_message',$message);
       }
       
       if($request->ajax()):
           
           
       endif;
       
        return view('admin.customers.add_edit_customer')->with(compact('page_info','btns','student'));
    }
   ##
    
   public function calculate_age(Request $request) {
       if($request->ajax()):
           $data = $request->all();
           $final = "";
           $now = Carbon::now();
           switch ($data['age_range']):
               case "years": {
                   $final = $now->subYears($data['age_value'])->toDateTimeString();
               } break; 
               case "months":{
                $final = $now->subMonths($data['age_value'])->toDateTimeString();   
               } break; 
               case "weeks":{
                   $final = $now->subWeeks($data['age_value'])->toDateTimeString();   
               }break;
               case "days":{
                   $final = $now->subDays($data['age_value'])->toDateTimeString();   
               } break;
               
               case "hours":{
                   $final = $now->subHours($data['age_value'])->toDateTimeString();   
               } break;                          
           endswitch;
           
           return response()->json(['dob'=>$final]);
           
       endif;
   }
    
   public function patient_medical_report($regno) {
       Session::put('page','customers'); Session::put('subpage','medical-report');
       $regno = base64_decode($regno); 
       $user = User::where('regno',$regno)->get()->first();
       $name = $user->surname.',  '.$user->firstname.' '.$user->othername; 
       $page_info = ['title'=> $name."'s Medical Report ",'icon'=>'pe-7s-user','sub-title'=>'Below are list of medical reports '];
       # dd($name); exit; 
       $completedTickets = CustomerTicket::with('specimen','results')
                    ->where(['create_mode'=>'completed','finalized'=>'yes',
                        'customer_id'=>$user->id])
                        ->get()->toArray();
        # dd($completedTickets);
      return view('admin.customers.report_home')->with(compact('page_info','completedTickets'));
   }
   
   public function load_country_states(Request $request) {
        $data = $request->all(); $country_id = $data['country_id']; 
        $states = Country::getStates($country_id); $stud_id = base64_decode($data['stud_id']); 
         $student = ($stud_id >0)? User::find($stud_id) : new User;
        return response()->json([
            'view'=>(String)View::make('admin.customers.ajax_state_form')->with(compact('states','student'))
        ]);
    }
    
     public function load_state_cities(Request $request) {
        $data = $request->all(); $state_id = $data['state_id']; 
        $country_id = $data['country_id']; 
        if($country_id == 161):
            $cities = State::getLGA($state_id);
            else :
              $cities = State::getCities($state_id);
        endif;
      
        $stud_id = base64_decode($data['stud_id']); 
        
         $student = ($stud_id >0)? User::find($stud_id) : new User;
        return response()->json([
            'view'=>(String)View::make('admin.customers.ajax_city_form')->with(compact('cities','student'))
        ]);
    }
    
      ## #### Filter Customers That You Want To See sOn All Customer Page ############
     public function filter_customers_to_display(Request $request) {
         if($request->ajax()){
            $output="<table class='table table-hover table-sm'>";  $data = $request->all();
            $students = User::where('regno','LIKE','%'.$data['param']."%")
                    ->orWhere(DB::raw("CONCAT(surname,' ',firstname,' ',othername)"),'LIKE','%'.$data['param']."%")
                    ->orWhere('email','LIKE','%'.$data['param']."%")
                    ->orWhere('phone','LIKE','%'.$data['param']."%")
                    ->orWhere('hmo','LIKE','%'.$data['param']."%")
                    ->orWhere('enrole_no','LIKE','%'.$data['param']."%")
                    ->limit(100)
                    ->get(); 
                    // ->orWhere('firstname','LIKE','%'.$data['param']."%")
                    // ->orWhere('othername','LIKE','%'.$data['param']."%")
            return response()->json([
                'view'=>(String)View::make('admin.customers.filtered_customers_by_ajax')->with(compact('students'))
            ]);
         } ## end ajax
    }
    
    public function family_members($id){
        Session::put('page','customers'); Session::put('subpage','families');
        $param =  base64_decode($id);  
        $fam_info = explode("_",$param); // host_id (user_id) _ family_id  
        $familyInfo = FamilyGroup::find($fam_info[1]);
        $page_info = ['title'=>$familyInfo->host_name. "'s Family ","icon"=>'pe-7s-user','sub-title'=>''];       
               
        return view('admin.customers.families.home',compact('page_info','param','fam_info'));
    }
     ## STEP 1 B - AFTER SEARCHING FAMILY MEMBER -
       public function fetch_customer_family_info(Request $request) {
         if($request->ajax()){
             $data = $request->all(); #print "<pre>"; print_r($data); exit; 
             $customer = User::where('id',$data['custom_id'])->first()->toArray();
             
             return response()->json([
                'view'=>(String)View::make('admin.customers.families.confirm_add_member_by_ajax')->with(compact('customer'))
            ]);
         }
       }
       
       public function add_new_family_member(Request $request) {
            if($request->ajax()){
             $data = $request->all(); # print "<pre>"; print_r($data); exit; 
             $family_info = explode("_",$data['family_id']); # host _ id
             User::where('id',$data['my_id'])->update(['family_id'=>$family_info[1]]);
             return response()->json([
                 'type'=>'success',
                 'message'=>'Member Added Successfully'
             ]);
            }
       }
}

# #127,963