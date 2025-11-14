<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerSpecimen;
use App\Models\CustomerTicket;
use App\Models\PaymentLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use function response;
use function view;

class ReportController extends Controller
{
    public function daily_reports(Request $request) {
         Session::put('page','reports'); Session::put('subpage','daily');
         $page_info = ['title'=>'Daily Reports ','icon'=>'pe-7s-notebook','sub-title'=>''];
     
        return view('admin.reports.daily',compact('page_info'));
    }
    
    public function all_reports(Request $request) {
         Session::put('page','reports'); Session::put('subpage','all_reports');
         $page_info = ['title'=>'Over-All Reports ','icon'=>'pe-7s-notebook','sub-title'=>'You can view all forms of reports by daily, weekly, monthly or anually from here'];     
        return view('admin.reports.overall',compact('page_info'));
    }
    
    public function weekly_reports(Request $request) {
         Session::put('page','reports'); Session::put('subpage','weekly');
         $page_info = ['title'=>'Weekly Reports ','icon'=>'pe-7s-notebook','sub-title'=>''];
     
        return view('admin.reports.weekly',compact('page_info'));
    }
    
    public function monthly_reports(Request $request) {
         Session::put('page','reports'); Session::put('subpage','monthly');
         $page_info = ['title'=>'Monthly Reports ','icon'=>'pe-7s-notebook','sub-title'=>''];
     
        return view('admin.reports.monthly',compact('page_info'));
    }
    
    public function fetch_daily_reports(Request $request) {
         if($request->ajax()){
            $data = $request->all();      
            #print "<pre>"; 
              $rules = [
                  'calendar'=>'required','report_types'=>'required'
              ];              
              $messages = [
                  'calendar.required'=>'Please Select A Date',                 
                  'report_types.required'=>'You Must select one or more report type'                 
              ];
             $validator = Validator::make($data, $rules,$messages);
             if($validator->fails()){ // or use $validator->passes()
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }
            
             if($validator->passes()){ // or use $validator->passes()
                ## start fetching report ###
                 ##++++++++++++++++++++++++++##
                $dfrom = Carbon::parse($data['calendar'])->startOfDay();
                $dto = Carbon::parse($data['calendar'])->endOfDay();
                
                $customers = []; $bills = [];  $payments = []; 
                ######### CUSTOMERS ##############
                if(in_array('customer',$data['report_types'])):                    
                    # $customers = CustomerTicket::whereBetween('created_at',[$dfrom,$dto])->get()->groupBy('customer_id')->toArray(); ## 
                    $customers = CustomerTicket::select('customer_id', DB::raw('count(*) as total'))
                        ->whereBetween('created_at', [$dfrom, $dto])
                        ->groupBy('customer_id')->get()->toArray(); 
    
                endif;
                ######### BILLS ##############
                 if(in_array('bills',$data['report_types'])):
                   # $bills = CustomerSpecimen::whereBetween('created_at',[$dfrom,$dto])->get()->groupBy('bill_type_id')->toArray(); ## 
                        $bills = CustomerSpecimen::select('bill_type_id', DB::raw('count(*) as total'))
                           ->whereBetween('created_at', [$dfrom, $dto])
                           ->groupBy('bill_type_id')
                           ->get()->toArray();
                endif;
                
                ######### PAYMENTS ##############
                 if(in_array('payment',$data['report_types'])):                 
                    $payments = PaymentLog::with(['ticket'
                     ])->whereBetween('date_paid',[$dfrom,$dto])->get()->groupBy('ticket_id')->toArray(); 
                endif;
                
                #print_r($customers);
                #exit;
                 
                 return response()->json(['type'=>'success',
                'view'=>(String)View::make('admin.reports.ajax.daily_report')->with(compact('data','customers','bills','payments'))
            ]);
    }
         }
    }
    ######################
    public function fetch_overall_reports(Request $request) {
         if($request->ajax()){
            $data = $request->all();      
            # print "<pre>";   print_r($data);
              $rules = [
                  'dfrom'=>'required','dto'=>'required','report_types'=>'required'
              ];              
              $messages = [
                  'dfrom.required'=>'Please Select A Date From',                 
                  'dto.required'=>'Please Select A Date To',                 
                  'report_types.required'=>'You Must select one or more report type'                 
              ];
             $validator = Validator::make($data, $rules,$messages);
             if($validator->fails()){ // or use $validator->passes()
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }            
            
             if($validator->passes()){ // or use $validator->passes()
                ## start fetching report ###
                 ##++++++++++++++++++++++++++##
                $dfrom = Carbon::parse($data['dfrom'])->startOfDay();
                $dto = Carbon::parse($data['dto'])->endOfDay();
                
                $customers = []; $bills = [];  $payments = []; $tickets = [];
                ######### CUSTOMERS ##############
                if(in_array('customer',$data['report_types'])):                    
                    # $customers = CustomerTicket::whereBetween('created_at',[$dfrom,$dto])->get()->groupBy('customer_id')->toArray(); ## 
                    ## fetching customers with specific investigations 
                    if(!empty($data['investigations'])):
                        $customers = CustomerSpecimen::select('customer_id', DB::raw('count(*) as total'))
                            ->whereBetween('created_at', [$dfrom, $dto])
                            ->whereIn('bill_type_id',$data['investigations'])
                            ->groupBy('customer_id')->get()->toArray(); 
                        else:
                         $customers = CustomerTicket::select('customer_id', DB::raw('count(*) as total'))
                        ->whereBetween('created_at', [$dfrom, $dto])
                        ->groupBy('customer_id')->get()->toArray(); 
                    endif;
                   
                
                
                endif;
                ######### BILLS ##############
                 if(in_array('bills',$data['report_types'])):
                   # $bills = CustomerSpecimen::whereBetween('created_at',[$dfrom,$dto])->get()->groupBy('bill_type_id')->toArray(); ## 
                        $bills = CustomerSpecimen::select('bill_type_id', DB::raw('count(*) as total'))
                           ->whereBetween('created_at', [$dfrom, $dto]);
                        if(!empty($data['investigations'])):
                         $bills = $bills->whereIn('bill_type_id',$data['investigations']);
                        endif;
                           $bills = $bills->groupBy('bill_type_id')                           
                           ->get()->toArray();
                endif;
                
                ######### PAYMENTS ##############
                 if(in_array('payment',$data['report_types'])):                 
                    $payments = PaymentLog::with(['ticket'])
                         ->whereBetween('date_paid',[$dfrom,$dto])
                         ->get()->groupBy('ticket_id')->toArray(); 
                endif; 
                
                ## TICKETS 
                 if(in_array('tickets',$data['report_types'])):                 
                    $tickets =  CustomerTicket::with(['payment'
                     ])->whereBetween('request_date',[$dfrom,$dto])->get()->toArray(); 
                endif;
                
               # print_r($tickets);
               # exit;
                 
                 return response()->json(['type'=>'success',
                'view'=>(String)View::make('admin.reports.ajax.daily_report')->with(compact('data','customers','bills','payments','tickets'))
            ]);
    }
         }
    }
    
}
