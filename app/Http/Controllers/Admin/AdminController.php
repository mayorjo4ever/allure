<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\ImportAdmins;
use App\Jobs\SendBirthdaySmsJob;
use App\Models\Admin;
use App\Models\CustomerSpecimen;
use App\Models\CustomerTicket;
use App\Models\DoctorAvailability;
use App\Models\SmsLog;
use App\Models\User;
use App\Services\TermiiSmsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use function admin_info;
use function collect;
use function now;
use function redirect;
use function response;
use function view;

class AdminController extends Controller
{
    public function __construct() {
        ## $this->middleware(['permission:view-admin','permission:create-admin']);
        if(Auth::guard('admin')->check()){
            $this->middleware(['permission:view-admin']);
        }
    }
     public function dashboard() {
       Session::put('page','dashboard'); Session::put('subpage','dashboard');
       $admin_id = Auth::guard('admin')->user()->id;
       $admin_name = admin_info($admin_id)['fullname'];
       $admin = Admin::find($admin_id);
       $my_roles = $admin->getRoleNames()->toArray();
       $page_info = ['title'=>'Welcome,  '.$admin_name,'icon'=>'pe-7s-home','sub-title'=> " Role : ".implode(" , ",$my_roles)];
      
       
       #sms notification
       #$admin = Auth::guard('admin')->user();
       #$admin->notify(new SendSmsNotification("Your Account was logged In to @ ".Carbon::now()));

       # $page_info = ['title'=>'Welcome,  '.Auth::guard('admin')->user()->name,'icon'=>'pe-7s-home','sub-title'=>'The best leading e-commerce platform'];
       # fetch total customers
       $customers = User::count();
       ## tickets created
       $this_year = Carbon::now()->year;
       $tickets_created = CustomerTicket::where(['create_mode'=>'completed','year'=>$this_year])->count();
       $completed_tickets = CustomerTicket::where(['create_mode'=>'completed','year'=>$this_year,'finalized'=>'yes'])->count();
       $pending_tickets = $tickets_created - $completed_tickets;
       ## get highest test ever done this year

       $results = CustomerSpecimen::select('bill_type_id', DB::raw('COUNT(bill_type_id) as count'))
               ->where('created_at','like',$this_year."%")
               ->groupBy('bill_type_id')
               ->orderByRaw('COUNT(bill_type_id) DESC')
               ->first();# ->toArray();
         $maxBill = !empty($results) ? $results['bill_type_id'] : [];
         $maxCount = !empty($results) ? $results['count'] : 0 ;
         
         #  view all smslogs
          $logs = SmsLog::with('user')->latest()->paginate(20);
          
          $birthday_users  = $this->upcoming_birthdays(); 
          $todays_celeb = $this->todays_celebrants(); 
          
       return view('admin.dashboard',compact('page_info','customers','tickets_created','completed_tickets','pending_tickets','maxBill','maxCount','todays_celeb','birthday_users')); #
    }


    public function updateAdminPassword(Request $requst) {
          Session::put('page','update_password'); Session::put('subpage','update_password');
          $page_info = ['title'=>'Manage Password','icon'=>'pe-7s-user','sub-title'=>'When you noticed vunerability, please always change your password, and subsequently every 3 months '];
        if($requst->isMethod('post')){
            $data = $requst->all(); // print "<pre>";
            // var_dump($data); die;
             if(!Hash::check($data['current_password'], Auth::guard('admin')->user()->password))
             {
                 return redirect()->back()->with('error_message','Your current password is incorrect');
             }
             else {
                 if($data['confirm_password'] == $data['new_password']){
                      Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>Hash::make($data['new_password'])]);
                      Auth::guard('admin')->logoutOtherDevices($current_psw);
                    return redirect()->back()->with('success_message','Your password has been updated');
                 }
                 else {
                     return redirect()->back()->with('error_message','New password and Confirm password does not match');
                 }
             }
        }
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.settings.update_admin_password')->with(compact('adminDetails','page_info'));
    }

     public function checkAdminPassword(Request $request) {
       $data = $request->all();
       if(Hash::check($data['current_password'], Auth::guard('admin')->user()->password)){
           return "true";  } else { return "false"; }
    }

    public function admins(){
       Session::put('page','admin_mgt'); Session::put('subpage','admin-staff');
       $page_info = ['title'=>'Administrative Staff','icon'=>'pe-7s-users','sub-title'=>'List of Administrative Staff'];
       $btns = [
            ['name'=>"Create New Staff",'action'=>"admin/add-edit-staff", 'class'=>'btn btn-success'],
            ['name'=>"Import More Staff",'action'=>"admin/staff/import", 'class'=>'btn btn-dark']
            ];
       $admins = Admin::get(); // ->toArray();
       
        #  $doctors = Admin::role('doctor')->get();       
        #  dd($doctors); 
       
       return view('admin.staff.staff',compact('page_info','admins','btns'));
    }
    
    public function get_doctor_availability(Request $request){
    if($request->ajax()):
          $data = $request->all(); 
           $doctor_id = $data['doctor_id'];
           $name = admin_info($doctor_id);
            # print "<pre>";
           # print_r($data); exit ; 
          $availability = DoctorAvailability::where('doctor_id',$doctor_id)
                 ->where('is_active', true)
                 ->get(['day_of_week', 'start_time', 'end_time']);
         return response()->json([
            'name'=>$name['fullname'],
            'days' => $availability->pluck('day_of_week'), // ["Mon","Wed","Fri"]
            'availability' => $availability // [{day_of_week:"Mon", start_time:"09:00", end_time:"14:00"}, ...]
         ]);
          # return response()->json(['days'=>$days]);
       endif; 
    }

     public function set_doctor_availability(Request $request){
        if($request->ajax()):
               $validator = Validator::make($request->all(), [
                'doctor_id'   => 'required|exists:users,id',
                'days'        => 'required|array',
                'days.*'      => 'in:Sun,Mon,Tue,Wed,Thu,Fri,Sat',
                'start_time'  => 'required|date_format:H:i',
                'end_time'    => 'required|date_format:H:i|after:start_time',
               ]);

               if ($validator->fails()) :
                    return response()->json([
                        'status' => 'error',
                        'errors' => $validator->errors()
                    ], 200); // Unprocessable Entity : 422
                  else :
            # submit 
          $validated = $validator->validated();
          foreach ($validated['days'] as $day) : 
              DoctorAvailability::updateOrCreate(
                    [
                        'doctor_id'   => $validated['doctor_id'],
                        'day_of_week' => $day,
                    ],
                    [
                        'start_time'  => $validated['start_time'],
                        'end_time'    => $validated['end_time'],
                        'is_active'   => $request->has('is_active'),
                    ]
                );
            endforeach; 

        return response()->json(['status'=>'success', 
             'message'=>'Availability saved successfully.']);
            endif; 
           endif; 
    }


    public function adminImportView() {
        Session::put('page','admin_mgt'); Session::put('subpage','import-staff');
        $page_info = ['title'=>'Import New Staff ','icon'=>'pe-7s-user','sub-title'=>'Importing Staff with ease '];
        $btns = [
            ['name'=>"Create New Staff",'action'=>"admin/add-edit-staff", 'class'=>'btn btn-success'],
            ['name'=>"View Staff",'action'=>"admin/staff", 'class'=>'btn btn-dark'],
            ['name'=>"Download Sample",'action'=>"admin/staff", 'class'=>'btn btn-info']
            ];
       # dd($subjects);
        return view('admin.staff.import_staff',compact('page_info','btns'));
    }

    public function readExcel(Request $request) {
      $data = $request->all();
      Excel::import(new ImportAdmins(), $data['file']);
      ## return redirect()->back()->with('success_message','Students successfully uploaded');
        return redirect('admin/staff')->with('success_message','Staff Successfully Uploaded');
    }
    ###################################


    public function addEditAdmin(Request $request, $id=null){
       Session::put('page','admin_mgt'); Session::put('subpage','add-staff');
       $page_info = ['title'=>'Create New Administrative Staff','icon'=>'pe-7s-users','sub-title'=>'Enroll New Administrative Staff, all other details whill be processed by themselves'];
       $btns = [
           ['name'=>"Import More Staff",'action'=>"admin/staff/import", 'class'=>'btn btn-success'],
           ['name'=>"View Staff",'action'=>"admin/staff", 'class'=>'btn btn-dark'],
          ];

       if($id==""){
           $admin = new Admin; $message = "Admin Profile Successfully Saved";
       }
       else {
           $admin = Admin::find($id); $message = "Admin Profile Successfully Updated";
           $page_info['title'] = "Update Administrative Staff Info";
       }
       ## updating student info
       if($request->isMethod('post')){
           $data = $request->all();
          # print "<pre>"; print_r($data);   die;
           $admin->title = $data['title'];
           $admin->surname = $data['surname'];
           $admin->firstname = $data['firstname'];
           $admin->othername = $data['othername'];
           $admin->email = $data['email'];
           $admin->regno = $data['regno'];
           $admin->mobile = $data['mobile'];
           ## $admin->name = $admin->surname ." ".$admin->firstname ." ". $admin->othername ;
           ### for new admin registration
           #####################################
           if($id=="" && $data['password']=="")
            { $admin->password = Hash::make(strtolower($data['surname']));  }
            ######## reset staff password
            if(isset($data['reset_password'])){
             $admin->password = Hash::make($data['password']);
             }
           $admin->save();
           return redirect('admin/staff')->with('success_message',$message);
       }
       // $admin->assignRole([]);
       return view('admin.staff.add_edit_staff',compact('page_info','admin','btns'));
    }

    ## display admin profile
    ### adminProfile
    public function adminProfile($id=null) {
        if($id!=""){
        $profile = Admin::find($id);
        print "<pre>";
         print_r($profile);
        }
    }

    ## assign role to admin
    public function assignRole($staff_id=null) { ## page view for assigning role
        Session::put('page','admin_mgt'); Session::put('subpage','assign_role');
        $page_info = ['title'=>'Assign Role For Staff','icon'=>'pe-7s-users','sub-title'=>'Specify which role a staff is allowed to have '];
        $btns = [
            ['name'=>"View Roles",'action'=>"admin/roles", 'class'=>'btn btn-dark'],
            ['name'=>"View Permissions",'action'=>"admin/permissions", 'class'=>'btn btn-success'],
            ['name'=>"View Staff",'action'=>"admin/staff", 'class'=>'btn btn-info'],
           ];
        $admins = Admin::get()->toArray();
        $roles = Role::all()->toArray();
        return view('admin.staff.staff_role', compact('page_info','btns','admins','roles','staff_id'));
    }
   ##
   public function getAdminRoles(Request $request) {
       if($request->ajax()){
          $data = $request->all();  $admin_id = $data['admin_id'];
          ##$all_roles = Role::all()->pluck('name','id');
          $all_roles = Role::all();
          $admin = Admin::find($admin_id);
          $my_roles = $admin->getRoleNames()->toArray();
          ##$assignedRoles = Admin::with('roles')->get()->toArray();
          ## $perms = $admin->getPermissionNames();
          ## $perms = $admin->getAllPermissions();
          ## $perms = $admin->getPermissionsViaRoles()->pluck('name');
          #print "<pre>";
          #print_r($all_roles);
          # print_r($my_roles);
          # exit;
          /** TO ASSIGN  : USE
           * All current roles will be removed from the user and replaced by the array given
           * $user->syncRoles(['writer', 'admin']);
          */

         return response()->json([
                'view'=>(String)View::make('admin.roles.role_list_ajax')->with(compact('all_roles','my_roles'))
            ]);
       } ## end if
   } ## end function

    public function setAdminRoles(Request $request) {
       if($request->ajax()){
          $data = $request->all();  // $admin_id = $data['admin_id'];
          $admin_id = $data['admin-staff'];
          $roles = $data['your_roles'];
          $admin = Admin::find($admin_id);
          $admin->syncRoles($roles); # remove every existing roles and assign the newly selected roles

          return response()->json([
              'status'=>'success',
              'message'=>'Roles successfully asigned for this Admin'
          ]);

       }
     }
     
     public function notifyUser(TermiiSmsService $sms)
        {
            $sms->send('2347030577951', 'Hello from Termii + Laravel!');
        }
        
        
        protected function upcoming_birthdays() {
        $today = now()->addDay();
        $days = 7; // how many days ahead to check

        // Build list of mm-dd values for today + next 6 days
        $dates = collect();
        for ($i = 0; $i < $days; $i++) {
            $dates->push($today->copy()->addDays($i)->format('m-d'));
        }

        $birthday_users = User::whereIn(\DB::raw("DATE_FORMAT(dob, '%m-%d')"), $dates)->orderByRaw("DATE_FORMAT(dob, '%m-%d')")->get();
        
        return $birthday_users; 
        
        # return view('birthdays.upcoming', compact('users'));
    }
    
    protected function todays_celebrants()
        {
            $today = now()->format('m-d');

            $users = User::whereRaw("DATE_FORMAT(dob, '%m-%d') = ?", [$today])->get();

            return $users;
        }
        
       public function sendTodaySms(Request $request, TermiiSmsService $smsService)
            {

                $userIds = $request->input('user_ids', []);

                $users = User::whereIn('id', $userIds)->get();

                foreach ($users as $user) {
                    SendBirthdaySmsJob::dispatch($user); // Add to queue
                }

                return redirect()->back()->with('success_message', 'SMS has been queued for selected users!');
            }

    public function sendTestEmail(){
        
        $to = "prissiedot@gmail.com"; // Change to the recipient's email

        Mail::raw("This is a test email from AlureICare!", function ($message) use ($to) {
            $message->to($to)
                    ->subject("App In Test Mode");
        });

        return "Test email has been sent to {$to}";
    }
        
}


## functions for admin usage
## $perms = Permission::all()->pluck('id')->toArray();
      ##$roles = Role::all()->toArray();
      ## $superAdmin = Role::find(1);
      ## $administrator = Role::find(2);
      ## $administrator->givePermissionTo('edit-role');##
      ##$superAdmin->syncPermissions($perms);

     ##  $admin = Admin::find(1);
       ## dd($admin);
       ## $admin->assignRole('Administrator');
       ## $admin->givePermissionTo(['create-student','view-student']);
       /**
       $city_code = 77051;
       $ng = 161;
       $city = City::with('state','country')->where('id',$city_code)->get()->toArray();
       $nigeria = Country::with(['state'=>function($query){
           $query->orderBy('name','asc');
       },'city'])->where('id',$ng)->get()->toArray();
        dd($nigeria); **/
