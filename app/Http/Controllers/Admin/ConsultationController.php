<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Appointment;
use App\Models\BillType;
use App\Models\Consultation;
use App\Models\ConsultationNote;
use App\Models\CustomerBill;
use App\Models\DoctorAvailability;
use App\Models\Drug;
use App\Models\Frame;
use App\Models\InvestigationTemplate;
use App\Models\Lense;
use App\Models\PatientInvestigation;
use App\Models\Prescription;
use App\Models\Questionnaire;
use App\Models\QuestionnaireResponse;
use App\Models\User;
use App\Models\UsersHistory;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Spatie\Permission\Traits\HasRoles;
use function GuzzleHttp\json_encode;
use function now;
use function optional;
use function redirect;
use function response;
use function view;

class ConsultationController extends Controller
{
    use HasRoles;
    
    public function manage_consultation_notes(Request $request){
        Session::put('page','services'); Session::put('subpage','consultation_notes');        
        $page_info = ['title'=>'Manage Consultation Notes','icon'=>'pe-7s-pen','sub-title'=> "  "];
        $notes = ConsultationNote::first(); 
        ## when submitting
        if($request->isMethod('post')):
            ConsultationNote::where('id',1)
                ->update(['notes'=>$request->complaint_forms]);
        return redirect()->back()->with('success_message','Note Updated Successfully');
        endif;
        return view('admin.appointments.consultation_notes',compact('page_info','notes')); #
    }

    
    public function new_appointment($ref_no = null){
        Session::put('page','services'); Session::put('subpage','new_app');        
        if($ref_no !=""): 
            $user_id = base64_decode($ref_no);  $user = User::find($user_id); 
            $page_info = ['title'=>'New Appointment For '.strtoupper($user->surname).", ".$user->firstname." ".$user->othername,'icon'=>'pe-7s-home','sub-title'=> " Hospital Card No: <strong>".$user->regno."</strong>"]; 
            $doctors = Admin::role('Doctor')->get(); 
           # print "<pre>"; print_r($doctors); die;
           return view('admin.appointments.new_app_doctor')->with(compact('page_info','user','doctors')); #
           else:
             $page_info = ['title'=>'Make New Appointment For Customer','icon'=>'pe-7s-home','sub-title'=> " Select the Customer, Available Doctor and Appointment Time To Meet : "];
             return view('admin.appointments.new_app',compact('page_info')); #
        endif;      
    }
        
     ## #### Filter Customers That You Want To See On All Customer Page ############
    public function filter_customers_to_display(Request $request) {
    if ($request->ajax()) {
        $data = $request->all();

        $students = User::where('regno', 'LIKE', "%{$data['param']}%")
            ->orWhere(DB::raw("CONCAT_WS(' ', surname, firstname, othername)"), 'LIKE', "%{$data['param']}%")
            ->orWhere('email', 'LIKE', "%{$data['param']}%")
            ->orWhere('phone', 'LIKE', "%{$data['param']}%")
            ->orWhere('hmo', 'LIKE', "%{$data['param']}%")
            ->orWhere('enrole_no', 'LIKE', "%{$data['param']}%")
            ->limit(100)
            ->get();

        return response()->json([
            'view' => (string) View::make('admin.appointments.filtered_customers_by_ajax')
                        ->with(compact('students'))
        ]);
    }
}
    // when getting time slot for customer 
    public function get_doctor_slots(Request $request){
        if($request->ajax()):
            $date = $request->date; // e.g. "2025-09-06"
            $doctorId = $request->doctor_id; 
            $dayOfWeek = Carbon::parse($date)->format('D'); // e.g. "Mon"
            // Find doctor availability for that day
            $availability = DoctorAvailability::where('doctor_id', $doctorId)
                ->where('day_of_week', $dayOfWeek)
                ->where('is_active', true)
                ->first();
                if (!$availability) {
                    return response()->json(['slots' => []]); // no slots
                }
               $start = Carbon::parse($availability->start_time);
               $end   = Carbon::parse($availability->end_time);
               $interval = 5; $now = Carbon::now(); // new

                $slots = [];
                while ($start->lessThan($end)) {
                    $slotTime = $start->copy(); // new
                    $time = $start->format('H:i');
                    $isPast = $date == $now->toDateString() && $slotTime->lessThan($now); 
                    
                    // Check if this slot is already booked
                    $isBooked = Appointment::where('doctor_id', $doctorId)
                        ->whereDate('appointment_date', $date)
                        ->whereTime('appointment_date', $time)
                        ->where('status', '!=', 'canceled')
                        ->exists();
                    $slots[] = [
                        'time' => $time,
                        'booked' => $isBooked || $isPast
                    ];
                    $start->addMinutes($interval);
                }
                return response()->json(['slots' => $slots]);
        endif;
    }
    
    public function book_doctor_appointment(Request $request){
        if($request->ajax()):
         #y print "<pre>"; print_r($request->all()); 
          $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
          ]);
        $appointmentDateTime = Carbon::parse($validated['date'].' '.$validated['time']);

        // Check if already booked
        $exists = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $appointmentDateTime)
            ->where('status', '!=', 'canceled')
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'This slot is already booked. Please choose another.'
            ], 200);
        }

        $appointment = Appointment::create([
            'doctor_id' => $request->doctor_id,
            'user_id'   => $request->user,    #  auth()->id(), // logged in patient
            'appointment_date' => $appointmentDateTime,
            'status' => 'pending',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Appointment booked successfully!',
            'appointment' => $appointment
        ]);
         endif;          
    }
    ## booking another appointment 
     public function book_doctor_next_appointment(Request $request){
        if($request->ajax()):
        # print "<pre>"; print_r($request->all()); 
          $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
          ]);
        $appointmentDateTime = Carbon::parse($validated['date'].' '.$validated['time']);

        // Check if already booked
        $exists = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $appointmentDateTime)
            ->where('status', '!=', 'canceled')
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'This slot is already booked. Please choose another.'
            ], 200);
        }
                  
        $newAppointment = Appointment::create([
            'doctor_id' => $request->doctor_id,
            'user_id'   => $request->user,    #  auth()->id(), // logged in patient
            'appointment_date' => $appointmentDateTime,
            'status' => 'pending',
        ]);         
        
        $oldAppointment = Appointment::find($request->app_id);
        $oldAppointment->next_appointment_id = $newAppointment->id;
        $oldAppointment->save(); 
        
        return response()->json([
            'status' => 'success',
            'message' => 'Appointment booked successfully!',
            'appointment' => $newAppointment
        ]);
         endif;          
    }
    
    ### view all appointments 
    public function allAppointments(Request $request){
        Session::put('page','services'); Session::put('subpage','all_apps');        
        $page_info = ['title'=>'All Booked Appointments','icon'=>'pe-7s-clock','sub-title'=> "  "];
        
        if(Session::get('app_staus') == null):
            Session::put('app_staus','pending');
        endif;
        
        if($request->isMethod('post')):
             Session::put('app_staus',$request->app_status);
        endif;
        
        $appointments = Appointment::with(['doctor','patient'])
                ->where('status',Session::get('app_staus'))
                ->orderBy('appointment_date','asc')
                ->paginate(20);
         
          # print "<pre>"; print_r($doctors); die;
        $header = "All Appointment";
        return view('admin.appointments.all_apps',compact('page_info','appointments','header')); #
      
    }
    
    ### view all approved Appointments
    public function viewApprovedApps(){
        Session::put('page','services'); Session::put('subpage','app_confirmed');        
        $page_info = ['title'=>'All Confirmed Appointments','icon'=>'pe-7s-clock','sub-title'=> "  "];
        $doctor = Auth('admin')->user();
       
       //  dd($doctor); die; 
        
        if($doctor->hasPermissionTo('view-all-appointed-patient')):
            $appointments = Appointment::with(['doctor','patient']) # ,'investigations.results'
                ->whereIn('status',['confirmed','checked_in'])   #,'in_consultation','completed'              
                ->orderBy('appointment_date','asc')
                ->get();  
        elseif($doctor->hasPermissionTo('view-own-appointed-patient')):
            $appointments = Appointment::with(['doctor','patient']) # ,'investigations.results'
                ->whereIn('status',['confirmed','checked_in'])    #,'in_consultation','completed'
                ->where('doctor_id',$doctor->id)
                ->orderBy('appointment_date','asc')
                ->get(); 
        endif;
        
         # print "<pre>"; 
            ## print_r($doctors); die;        
        return view('admin.appointments.confirmed_apps',compact('page_info','appointments')); #
      
        /**
         * Appointment::with(['consultation','questions',
             'investigations.results','prescriptions.item'])
                 ->findOrFail($data['app_id']);
         */
    }
    ### view all awiting patients 
    public function view_awaiters(){
        Session::put('page','services'); Session::put('subpage','app_waiters');        
        $page_info = ['title'=>'All Awaiting Patients','icon'=>'pe-7s-clock','sub-title'=> "  "];
        
        $doctor = Auth('admin')->user();
        if($doctor->hasPermissionTo('view-all-appointed-patient')):
           $appointments = Appointment::with(['doctor','patient']) # 'investigations.results','prescriptions.item','bills'
                ->whereIn('status',['checked_in','in_consultation'])                 
                ->orderBy('appointment_date','asc')
                ->get(); 
          elseif($doctor->hasPermissionTo('view-own-appointed-patient')):
           $appointments = Appointment::with(['doctor','patient']) # 'investigations.results','prescriptions.item','bills'
                ->whereIn('status',['checked_in','in_consultation'])                 
                ->where('doctor_id',$doctor->id)
                  ->orderBy('appointment_date','asc')
                ->get(); 
           endif;
          #print "<pre>"; print_r($appointments->toArray()); die;        
        return view('admin.appointments.all_waiters',compact('page_info','appointments')); #      
    }
    
    public function confirmAppointment($id, SmsService $sms) {
        $appointment = Appointment::with(['patient','doctor'])->findOrFail($id); $status = "confirmed";
        $appointment->status = $status;
        $appointment->save();
        $email = optional($appointment->patient)->email; # if mail exists
       # if ($email) {
           # Mail::to($email)->send(new AppointmentStatusMail($appointment, $status));
       # }
        return response()->json(['status' => 'success', 'message' => 'Appointment confirmed, and notification sent ']);
    }
    
    public function cancelAppointment($id, SmsService $sms) {
        $appointment = Appointment::findOrFail($id);
        $appointment->status = 'canceled';
        $appointment->save();
       
        return response()->json(['status' => 'success', 'message' => 'Appointment canceled']);
    }
    
    
    public function checkinAppointment($id) {
        $appointment = Appointment::with('patient')->findOrFail($id); # print "<pre>"; 
        // print_r($appointment->toArray());  echo  Carbon::now(); 
        // exit; 
        $checkin_time = Carbon::now();
        $appointment->checkedin = true;
        $appointment->checkin_time = $checkin_time;
        $appointment->status = "checked_in";
        $appointment->save();                
        return response()->json(['status' => 'success','checkin_time'=>$checkin_time->toDateTimeString(), 'message' => $appointment->patient->surname." ". $appointment->patient->firstname."  Have Successfully Check In For His Appointment"]);
    }
    
    public function admittedAppointment($id) {
       $appointment = Appointment::with('patient')->findOrFail($id); # print "<pre>";                
       # update appoitment 
       if($appointment->status=="checked_in"): $appointment->status = "in_consultation"; $appointment->save(); endif;
       # output view 
        Session::put('page','services'); Session::put('subpage','app_consulting');        
        Session::put('app_id',$id);
        $title = $appointment->patient->surname." ".$appointment->patient->firstname." ".$appointment->patient->othername;
        $subtitle = "<strong class='h5'>File No: ".$appointment->patient->regno."</strong>";
        $page_info = ['title'=>$title."'s Profile",'icon'=>'pe-7s-user','sub-title'=> $subtitle];
        
    return view('admin.appointments.in_consultation',compact('page_info','appointment')); #
      
    }
    
    public function getPatentInfo(Request $request,$id) {
        $info_type = $request->info_type;
       # print "<pre>";  print_r($request->all()); die; print $info_type; 
        
        if($info_type === "profile"):            
            $info = User::find($id); 
            return response()->json([
                'status'=>'success',
                'view'=>(String)View::make('admin.appointments.ajax.patient_info',compact('info'))]);
        
            elseif($info_type === "history"):
               $info = User::with('history')->find($id);      
                return response()->json([
                'status'=>'success',
                'view'=>(String)View::make('admin.appointments.ajax.medical_info',compact('info'))]);
            
            elseif($info_type === "consultation"):
                $info = User::with('history')->find($id);      
                return response()->json([
                'status'=>'success',
                'view'=>(String)View::make('admin.appointments.ajax.consultation',compact('info'))]); 
                
                
            elseif($info_type === "appointments"):
                // print_r($request->all()); die; print $info_type; 
                /* print_r($request->all()) = (
                        [info_type] => appointments
                        [app_id] => 1
                    )
                 */#   print "<pre>"; 
                $current_appointments = Appointment::findOrFail($request->app_id); 
               ## print_r($current_appointments->toarray());
                $past_appointments = Appointment::where('user_id',$current_appointments->user_id)
                        ->whereIn('status',['completed','checked_out']) 
                        ->whereNot('id',$request->app_id)
                        ->get();
                // print_r($past_appointments->toarray());
                
                return response()->json([
                'status'=>'success',
                'view'=>(String)View::make('admin.appointments.ajax.previous_consultation',compact('past_appointments'))]); 
                
        endif;
    }
    
    public function addConsultTasks(Request $request,$id) {
        $consult_type = $request->input('consult_type');
        # print "<pre>";  print_r($request->all()) ;  print $id;  die; 
        # we have questionnaire,notes,investigations,diagnosis,prescriptions
        if($consult_type === "notes"):  
             $appointment = Appointment::with(['consultation'])
                 ->findOrFail($request->app_id);
                $default_note = ConsultationNote::first();
            return response()->json([
                'status'=>'success',
                'view'=>(String)View::make('admin.appointments.ajax.notes_body',compact('appointment','default_note'))]);
        
            elseif($consult_type === "questionnaire"):
                return response()->json([
                'status'=>'success',
                'view'=>(String)View::make('admin.appointments.ajax.question_body')]);
        
            elseif($consult_type === "investigations"):
                return response()->json([
                'status'=>'success',
                'view'=>(String)View::make('admin.appointments.ajax.adding_tests_body')]);
        
            elseif($consult_type === "consultation"):
                $info = User::with('history')->find($id);      
                return response()->json([
                'status'=>'success',
                'view'=>(String)View::make('admin.appointments.ajax.consultation',compact('info'))]);                
                
            elseif($consult_type === "prescriptions"):
             return response()->json([
                'status'=>'success',
                'view'=>(String)View::make('admin.appointments.ajax.adding_prescription_body')]);
        
        endif;
    }
    
    public function fetchCustomerMedicalHistory($id) {
         $info = User::with('history')->find($id);         
         return response()->json($info);         
    }
    
    public function updateCustomerMedicalHistory(Request $request, $id) {
        // print "<pre>"; print_r($request->all()); 
        // print $id; 
        $info = User::find($id);
        UsersHistory::updateOrCreate(
            ['user_id'=>$id,'regno'=>$info->regno],
            ['history'=>$request->input('history'),
                'drug_history'=>$request->input('drug-history'),
                'family_history'=>$request->input('family-history')]
        );
        return response()->json(['status' => 'success', 'message' => $info->usrname." ".$info->firstname." Medical History Successfully Saved"]);
    }
    
    // when doctor's making comment during appointment
    public function  save_doctors_comment(Request $request,$patient_id,$app_id) {
       // print "<pre>"; print_r($request->all()); exit;
        $doctorId = Auth()->id();
        $rules = [
                'report'=>"required|string|min:50",                
               ];
            $customMessage = [
               'report.required'=>"The report must not be empty",
               'report.min'=>"The report or commemts must be a minimum of 50 characters"
                ];
        $validator = Validator::make($request->all(),$rules,$customMessage); 
        if ($validator->fails()) :
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 200); 
       endif; 
        Consultation::updateOrCreate(
                ['appointment_id'=>$app_id,
                    'user_id'=>$patient_id],
                ['visit_date'=>Carbon::now(),
                    'doctor_id'=>$doctorId,
                    'regno'=>$request->input('regno'),
                    'complaint'=>$request->input('report')
                ]
        );
        
        return response()->json([
            'status'=>'success',
            'message'=> " Report Successfully  Saved "            
        ]);
    }
    
    public function save_patient_diagnostics(Request $request,$patient_id){
        #print "<pre>"; print_r($request->all()); exit; 
        if($request->ajax()):
            if($request->diagnosis == ""):
                return response()->json([
                    'status'=>'error',
                    'message'=>'Please Enter What you are Diagonising !!'
                    ]);  endif;
           
            Consultation::updateOrCreate(
                ['appointment_id'=>$request->app_id,
                    'user_id'=>$request->patient_id],
                ['diagnosis'=>$request->diagnosis,
                 'regno'=>$request->regno,
                 'doctor_id'=>Auth('admin')->user()->id,
                 'visit_date'=>Carbon::now()]
                );
        
            return response()->json([
                'status'=>'success',
                'message'=> " Diagnosis Successfully  Saved "            
            ]);
        endif;
    }
    
    public function display_consultation_summary(Request $request) {
         $data = $request->all(); 
         $appointment = Appointment::with(['consultation','questions',
             'investigations.results','prescriptions.item','bills'])
                 ->findOrFail($data['app_id']);
         $billings = BillType::where('status',1)->get();
         $default_note = ConsultationNote::first();
         
        # print "<pre>"; print_r($appointment->toarray()); die; 
         
         return response()->json([
            'status'=>'success',
             'body'=>(String)View::make('admin.appointments.ajax.notes_body',compact('appointment','default_note')),
             'view'=>(String)View::make('admin.appointments.ajax.consultation_summary',compact('appointment','billings'))
             ]);             
        }
  
    public function display_dummy_consultation_summary(Request $request) {
         $data = $request->all(); 
         $appointment = Appointment::with(['consultation','questions',
             'investigations.results','prescriptions.item','bills'])
                 ->findOrFail($data['app_id']);
         $billings = BillType::where('status',1)->get();
         $default_note = ConsultationNote::first();
         
        # print "<pre>"; print_r($appointment->toarray()); die; 
         
         return response()->json([
            'status'=>'success',
             'body'=>(String)View::make('admin.appointments.ajax.dummy_notes_body',compact('appointment','default_note')),
             'view'=>(String)View::make('admin.appointments.ajax.dummy_consultation_summary',compact('appointment','billings'))
             ]);             
        }
    
    public function search_for_question(Request $request) {
        $text = $request->input('question');
        $questions = Questionnaire::where('question','LIKE',"%{$text}%")
                ->where('status',1)
                ->get(); 
        return response()->json([
            'status'=>'success',            
             'view'=>(String)View::make('admin.appointments.ajax.question_displayer',compact('questions'))
             ]);
        }
        
    public function search_for_investigations(Request $request) {
        $text = $request->input('test');
        $tests = InvestigationTemplate::where('name','LIKE',"%{$text}%")
                ->where('status',1)
                ->get(); 
        return response()->json([
            'status'=>'success',            
             'view'=>(String)View::make('admin.appointments.ajax.test_displayer',compact('tests'))
             ]);
    }
    
    public function add_patient_investigation(Request $request,$patient_id,$app_id) {        
      
        $data   = $request->all(); 
        $doctor = Auth()->id();  /*
            Array
            (
                [_token] => Fvptr3klYGuKlV8fwHN5PRALLyLnxVpWikQHp7Ns
                [test_id] => 3
                [regno] => 00/182/23
                [patient_id] => 846
                [app_id] => 8
            )         */
        $investigation = InvestigationTemplate::findOrFail($request->test_id);
        # print_r($data);
        PatientInvestigation::updateOrCreate(
                ['patient_id'=>$request->patient_id,
                    'appointment_id'=>$request->app_id,
                    'doctor_id'=>Auth('admin')->user()->id,
                    'investigation_template_id'=>$request->test_id,
                    'status'=>'pending'],
                ['investigation_template_id'=>$request->test_id,
                    'price'=>$investigation->price]
        );
        return response()->json(['status' => 'success', 'message' => 'Investigation Saved Successfully']); 
      }
      
              
     public function save_doctors_question(Request $request,$patient_id,$app_id) {        
      $quid = $request->input('quid'); // 
      $question = Questionnaire::find($quid);
      #print $question->question; 
      switch($question->type){
          case "boolean":
            $answer =  $request->input('answer-'.$quid); 
              # print "Answer = ".$answer;
              if($answer==""):
                  return response()->json(['status' => 'error', 'message' => 'Please Select an option']);
                  else :
                    QuestionnaireResponse::updateOrCreate(
                        [
                            'questionnaire_id' => $quid,
                            'patient_id' => $request->patient_id,
                            'appointment_id' => $request->app_id,
                            'regno' => $request->regno,
                        ],
                        ['answer' => $answer]
                    );
              return response()->json(['status' => 'success', 'message' => 'Responses saved successfully']); 
              endif;
            break; 
          case "choice":
             $answers =  $request->input('answers');               
             if(empty($answers)):
                  return response()->json(['status' => 'error', 'message' => 'Please Select one or more options']);
                  else : $answer = json_encode($answers);
                    QuestionnaireResponse::updateOrCreate(
                        [
                            'questionnaire_id' => $quid,
                            'patient_id' => $request->patient_id,
                            'appointment_id' => $request->app_id,
                            'regno' => $request->regno,
                        ],
                        ['answer' => $answer]
                    );
              return response()->json(['status' => 'success', 'message' => 'Responses saved successfully']); 
              endif;
            break; 
            
          case "text":
             $answer =  $request->input('answer-'.$quid); 
              # print "Answer = ".$answer;
              if($answer==""):
                  return response()->json(['status' => 'error', 'message' => "Please Enter Patient's Response"]);
                  else :
                    QuestionnaireResponse::updateOrCreate(
                        [
                            'questionnaire_id' => $quid,
                            'patient_id' => $request->patient_id,
                            'appointment_id' => $request->app_id,
                            'regno' => $request->regno,
                        ],
                        ['answer' => $answer]
                    );
              return response()->json(['status' => 'success', 'message' => 'Responses saved successfully']); 
              endif;
              break; 
      }      
    }
    
    public function load_investigation_result(Request $request){
        $id = $request->investg_id ; 
       $investigation = PatientInvestigation::with('template.fields', 'patient', 'results.files')
             ->findOrFail($id);
        $resultsByField = $investigation->results->keyBy('field_id');

        
        return response()->json([
            'status'=>'success',            
             'view'=>(String)View::make('admin.appointments.ajax.result_displayer',compact('investigation','resultsByField'))
             ]);
    }
    
    
    public function bill_search(Request $request) {
        $query = trim($request->get('q', ''));

        if (strlen($query) < 2) {
            return response()->json([]);
        }
        // Search drugs
          $drugs = Drug::where('name', 'like', "%{$query}%")
            ->where('status',1)
            ->select('id', 'name', 'sales_price', 'qty_rem')
            ->get()
            ->map(function ($drug) {
                $drug->type = 'drug';
                return $drug;
            }); 
        // Search lenses
          $lenses = Lense::where('name', 'like', "%{$query}%")
            ->where('status',1)   
            ->select('id', 'name', 'type_id', 'sales_price', 'qty_rem')
            ->get()
            ->map(function ($lens) {
                $lens->type = $lens->type_name; // from accessor
                return $lens;
            });
            $frames = Frame::where('name', 'like', "%{$query}%")
            ->where('status',1)
            ->select('id', 'name', 'sales_price', 'qty_rem')
            ->get()
            ->map(function ($frame) {
                $frame->type = 'frame';
                return $frame;
            }); 
            
        // Merge & return
         $results = $drugs
        ->concat($lenses)
        ->concat($frames)
        ->values();

        return response()->json($results);
    }
    
    
    // storing the prescrition items         
        public function submitPrescribedBills(Request $request) {
            // echo "<pre>"; print_r($request->all());    echo "</pre>";  die; 
            
             $doctor_id = Auth('admin')->user()->id;
             $validated = $request->validate([
                    'patient_id' => 'required|exists:users,id',
                    'app_id' => 'required|exists:appointments,id',
                    'prescriptions' => 'required|array|min:1',
                    'prescriptions.*.item_id' => 'required|integer',
                    'prescriptions.*.item_type' => 'required|string', // |in:drug,lens
                    'prescriptions.*.quantity' => 'required|integer|min:1',
                    'prescriptions.*.dosage' => 'nullable|string',                 
                ]);

            foreach ($validated['prescriptions'] as $item) {
                if ($item['item_type'] === 'drug') {
                    $product = Drug::find($item['item_id']);
                }
                else if ($item['item_type'] === 'frame') {
                    $product = Frame::find($item['item_id']);
                }
                else {
                    $product = Lense::find($item['item_id']);
                }
                // Disallow prescribing more than available
                if($item['quantity'] > $product->qty_rem) {
                    return response()->json([
                        'type'=>'error',
                        'message' => "Cannot prescribe more than available stock for {$product->name}"
                    ]);
                }
                $profit = ($product->sales_price - $product->purchase_price) * $item['quantity'];
                Prescription::create([
                    'appointment_id' => $validated['app_id'],
                    'patient_id' => $validated['patient_id'],
                    'doctor_id' => $doctor_id,
                    'item_id' => $product->id,
                    'item_type' => $item['item_type'],
                    'type_id' => $item['item_type'] === 'lens' ? $product->type_id : null,
                    'type_name' => $item['item_type'] === 'lens' ? $product->type_name : null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->sales_price,                   
                    'purchase_price' => $product->purchase_price,                   
                    'profit' => $profit,                   
                    'total_price' => $product->sales_price * $item['quantity'],
                    'dosage' => $item['dosage'],
                ]);
                
                $product->qty_rem = ($product->qty_rem - $item['quantity']); 
                $product->save(); 

               }
                return response()->json(['type'=>'success',
                'message'=>'Prescription saved successfully!']);
              }
              
              public function finalizeAppointment($app_id, $bills, $finalamount){                  
                $bill_id = $bills == "null" ? null : explode(",",$bills); 
                $bill_type_ids = $bill_id == null ? null :  implode(',',$bill_id) ; 
                #$billTypes = $bills == "null" ? null :  BillType::whereIn('id',$bill_id)->get();                 
                $appointment = Appointment::findOrFail($app_id);
                
                $final_bill = CustomerBill::updateOrCreate(
                        ['appointment_id'=>$app_id,
                            'patient_id'=>$appointment->user_id],
                        ['bill_type_ids'=>$bill_type_ids,
                            'total_cost'=>$finalamount]
                   );
               }
               
               
             public function finalize2Appointment($app_id, Request $request){ 
                $bills = $request->input('bills', []); // array                
                $final_fees = $request->input('final_fees', 0);
               # print "<pre>"; print "[app_id] => $app_id";  print_r($request->all()); die; 
                
                $appointment = Appointment::findOrFail($app_id);
                $bill_type_ids = empty($bills) ? null :  implode(',',$bills);
                $ticketno = $this->generatePaymentRef($appointment->id);
                $customer_bill = CustomerBill::updateOrCreate(
                        ['appointment_id'=>$app_id,
                            'patient_id'=>$appointment->user_id],
                        ['bill_type_ids'=>$bill_type_ids,
                            'ticketno'=>$ticketno,
                            'total_cost'=>$final_fees]
                   );
                // close appoitment
                $appointment->status = 'completed';
                $appointment->ticketno = $ticketno;
                $appointment->customer_bill_id = $customer_bill->id;
                $appointment->save();
                ## update patient info and bill info
                PatientInvestigation::where(['appointment_id'=>$app_id])
                        ->update(['customer_bill_id'=>$customer_bill->id]);
                Prescription::where(['appointment_id'=>$app_id])
                        ->update(['customer_bill_id'=>$customer_bill->id]);
                
                return response()->json([
                    'status'=>'success',
                    'message'=>'Appointment Finalized Sucessfully'
                ]);                
                
               }
    
               
    private function generatePaymentRef($id) {
        $prefix = 'AEC';
        $datePart = now()->format('ymd'); // e.g. 20251106
        $random = str_pad($id, 4, '0', STR_PAD_LEFT); // pad appointment ID

        return "{$prefix}{$datePart}{$random}";
    }               
    
    // deleting investigations 
    function delete_patient_investigation(Request $request){
        if($request->ajax()):
            $params = explode("|",$request->params);  # id | name            
            PatientInvestigation::where('id',$params[0])
                    ->delete();             
            return response()->json([
                'status'=>'success',
                'message'=>$params[1]." Successfully Deleted "
            ]);         
        endif; 
    }
    
    // deleting prescription 
    function delete_patient_prescription(Request $request){
        if($request->ajax()):
            $params = explode("|",$request->params);  # id | name  | type          
            Prescription::where('id',$params[0])
                    ->delete();             
            return response()->json([
                'status'=>'success',
                'message'=>$params[1]." (".$params[2].") Successfully Deleted "
            ]);         
        endif; 
    }
    
}
 