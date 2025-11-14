<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BillType;
use App\Models\CustomerSpecimen;
use App\Models\CustomerSpecimenResult;
use App\Models\CustomerTicket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use PDF;
use function get_new_ticket_id;
use function redirect;
use function response;
use function url;
use function users_name;
use function view;

class TicketController extends Controller
{
     public function create_ticket(Request $request, $id=null) {
       Session::put('page','tickets'); Session::put('subpage','ticket-add');
       $page_info = ['title'=>'Create New Bill Ticket ','icon'=>'pe-7s-user','sub-title'=>'Create New / Update Customer Ticket '];
       $btns = [
           ['name'=>"View All Tickets",'action'=>"admin/tickets", 'class'=>'btn btn-dark']
          ];
       if($id=="") {
           $ticket = new CustomerTicket;
           $message = "Customer Profile Successfully Saved";
       }
       else {
         $page_info['title'] = "Update Customer Ticket ";
         $ticket = CustomerTicket::find($id);
       }

       return view('admin.tickets.creation.create_ticket')->with(compact('page_info','btns','ticket'));
     }

       ## STEP 1 B - CTREATING CUSTOMER TICKET ## AFTER SEARCHED -
       public function fetch_customer_info(Request $request) {
         if($request->ajax()){
             $data = $request->all();
             // $customer = User::where('regno',$data['regno'])->first()->toArray();
             $customer = User::where('id',$data['custom_id'])->first()->toArray();
             return response()->json($customer); // $json)
         }
       }

       ## STEP 2 B - CREATING SPECIMEN TICKET ## AFTER SEARCHED -
       public function fetch_specimen_info(Request $request) {
         if($request->ajax()){
             $data = $request->all();
             $bill = BillType::where('id',$data['bill_id'])->first()->toArray();
             $user = User::where('id',$data['user_id'])->first()->toArray();
             $today = Carbon::now();
             $child_min_years = $today->subYears(15);
             $whom = ($user['dob'] < $child_min_years )?"adult":"children";
             $admin_id = Auth::guard('admin')->user()->id;
              ## fetch temporally saved bills
              $ticket = CustomerTicket::with('specimen')->where([
                 'created_by'=>$admin_id,
                 'create_mode'=>'new',
                 'customer_id'=>$data['user_id']])->get()->toArray();
               ## print "<pre>"; print_r($ticket); die;

              return response()->json([
                'view'=>(String)View::make('admin.tickets.creation.specimen_add_by_ajax')->with(compact('bill','user','whom','ticket'))
            ]);
         }
       }
       ##
       
    ## #### STEP 1 A - FOR CREATING TICKET ############
     public function search_customer_info(Request $request) {
         if($request->ajax()){
            $output="<table class='table table-hover table-sm'>";  $data = $request->all();
            $customers = User::where('regno','LIKE','%'.$data['param']."%")
                    ->orWhere(DB::raw("CONCAT(surname,' ',firstname,' ',othername)"),'LIKE','%'.$data['param']."%")
                    ->orWhere('email','LIKE','%'.$data['param']."%")
                    ->orWhere('phone','LIKE','%'.$data['param']."%")
                    ->limit(25)
                    ->get();

            if(!empty($customers)):
             foreach($customers as $key => $user) :
                $myname = $user->regno." | ".$user->surname." ".$user->firstname;
                $output.='<tr>'.
                '<td style="cursor:pointer" onclick="save_selected_customer(\''.$myname.'\',\''.$user->id.'\')">'.$user->regno.' '.
                ' &nbsp; '.$user->surname.' '.
                ' '.$user->firstname.' '.
                ' '.$user->othername.' </td>'.
                '</tr>';
                endforeach;

           endif;
           $tbc = count($customers) >0 ?"text-success":"text-danger";
           $output.='<tr><td class="'.$tbc.'">'.count($customers).' customer found </td></tr>';
           $output.= "</table>";

           return response($output);
         } ## end ajax
    }

     public function search_specimen_info(Request $request) {
         if($request->ajax()){
            $output="<table class='table table-hover table-sm'>";  $data = $request->all();
            $bills = BillType::where('name','LIKE','%'.$data['sparam']."%")
                    ->orWhere('specimen_sample','LIKE','%'.$data['sparam']."%")
                    ->limit(25)
                    ->get();

            if(!is_null($bills)) {
             foreach($bills as $key => $bill) {
                $output.='<tr>'.
                '<td style="cursor:pointer" onclick="save_selected_specimen(\''.$bill->id.'\',\''.$bill->name.'\')">'.$bill->name.' '.
                ' /  '.$bill->specimen_sample.'  </td> </tr>';
                }  ## end foreach
           }  ##  end if
           $output.= "</table>";

           return response($output);
         } ## end ajax
    }
     
       ## #### STEP 2 - FOR CREATING TICKET ############
       public function add_ticket_bill(Request $request) {
         if($request->ajax()){
             $data = $request->all();
             ## print "<pre>";##print_r($data); die;
             ## bill_id and user_id & specimen
             $admin_id = Auth::guard('admin')->user()->id;

             $message = "Bill Saved Successfully";

             $ticket = CustomerTicket::firstOrNew([
                 'created_by'=>$admin_id,
                 'create_mode'=>'new',
                 'customer_id'=>$data['user_id']
                 ]);

             $today = Carbon::now();
             $ticket->created_by = $admin_id;
             $ticket->create_mode = 'new';
             $ticket->customer_id = $data['user_id'];
             $ticket->year = $today->year;
             $ticket->save();

            $ticket_id = $ticket->id;

             ## process the specimen
             $specimen = CustomerSpecimen::firstOrNew([
                 'customer_id'=>$data['user_id'],
                 'ticket_id'=>$ticket_id,
                 'created_by'=>$admin_id,
                 'create_mode'=>'new',
                 'bill_type_id'=>$data['bill_id']
             ]);

             $specimen->customer_id = $data['user_id'];
             $specimen->created_by = $admin_id;
             $specimen->create_mode = 'new';
             $specimen->ticket_id = $ticket_id;
             $specimen->bill_type_id = $data['bill_id'];
             $specimen->specimen_sample = $data['specimen'];
             $specimen->bill_price = $data['price'];
             $specimen->save();

             ## save the specimen
             return response()->json([
                 'type'=>'success',
                 'message'=>$message
                ]);
         }
       }

    public function delete_ticket_bill($id) {
        CustomerSpecimen::where('id',$id)->delete();
        $msg = "Bill has been deleted successfully";
        return response()->json(['type'=>'success','message'=>$msg]);
    }
    
    public function delete_ticket_bill_2($ticket_no,$bill_id) {
         $ticket = base64_decode($ticket_no);
        CustomerSpecimen::where('bill_type_id',$bill_id)
                ->where('ticket_no',$ticket)->delete();
          
        $msg = bill_name($bill_id)." Successfully deleted from the investigations";
        
        $tcost = CustomerSpecimen::where(['ticket_no'=>$ticket])->sum('bill_price');
            
            CustomerTicket::where([
                 'ticket_no'=>$ticket,                
                 'create_mode'=>'completed'                 
                 ])->update([
                     'total_cost'=>$tcost                    
                 ]);
        ##'payment_completed'=>'no','payment_finalized'=>'no'
            
        return redirect()->back()->with('success_message',$msg);
        # return response()->json(['type'=>'success','message'=>$msg]);
    }
   
    
    public function reverse_finalized_ticket($ticket_no) {
        $ticket = base64_decode($ticket_no);        
        $msg = " $ticket Ticket Successfully Reversed";
        
        CustomerTicket::where([
            'ticket_no'=>$ticket,                
            'create_mode'=>'completed'                 
            ])->update([
                'finalized'=>'no'                    
            ]);        
            
        return redirect()->back()->with('success_message',$msg);
        # return response()->json(['type'=>'success','message'=>$msg]);
    }
    
    public function ticket_summary(Request $request) {
         if($request->ajax()){
             $data = $request->all(); ## print "<pre>"; print_r($data); die;
             $admin_id = Auth::guard('admin')->user()->id;
             $ticket = CustomerTicket::with('specimen','user')->where([
                 'created_by'=>$admin_id,
                 'create_mode'=>'new',
                 'customer_id'=>$data['user_id']])->get()->toArray();

              //  print "<pre>"; print_r($ticket); die;
             return response()->json([
                'view'=>(String)View::make('admin.tickets.creation.ticket_summary_by_ajax')->with(compact('ticket'))
            ]);
         }
    }
     public function finalize_ticket_summary_2(Request $request) {
         if($request->ajax()){
             $data = $request->all();  print "<pre>"; print_r($data); die;
             $admin_id = Auth::guard('admin')->user()->id;
             $tcost = CustomerSpecimen::where('ticket_id',$data['ticket_id'])->sum('bill_price');
             $ticket = CustomerTicket::with('specimen','user')->where([
                 'ticket_no'=>$data['ticket_no'],
                 'create_mode'=>'completed',
                 'customer_id'=>$data['user_id']])->get()->toArray();

              //  print "<pre>"; print_r($ticket); die;
             return response()->json([
                'view'=>(String)View::make('admin.tickets.creation.ticket_summary_by_ajax')->with(compact('ticket'))
            ]);
         }
    }
    
    

    public function submit_customer_ticket(Request $request) {
        if($request->ajax()){
             $data = $request->all(); ## print "<pre>"; print_r($data); die;
             $admin_id = Auth::guard('admin')->user()->id;
             $ticket = CustomerTicket::find($data['ticket_id']);
             $tcost = CustomerSpecimen::where('ticket_id',$data['ticket_id'])->sum('bill_price');

             ## print $tcost; die;
                ###########################################
                $ticket->hospital = $data['hospital'];
                $ticket->doctor = $data['doctor'];
                $ticket->consultant = $data['consultant'];
                $ticket->clinical_details = $data['medical_report'];
                $ticket->request_date = $data['request_date'];
                $ticket->date_collected = $data['date_collected'];
                $ticket_no = get_new_ticket_id();
                $ticket->ticket_no = $ticket_no;
                $ticket->create_mode = 'completed';
                $ticket->total_cost = $tcost;
                $ticket->amount_paid = 0;
                $ticket->save();

                CustomerSpecimen::where('ticket_id',$data['ticket_id'])->update(
                   ['ticket_no'=>$ticket_no,'create_mode'=>'completed'
                  ]);

               return response()->json([
                'type'=>'success','message'=>'Bill Created Successfully','url'=>
                   url('admin/create-ticket')
            ]);
         }
    }


    public function tickets(){
       Session::put('page','tickets'); Session::put('subpage','tickets');
       $page_info = ['title'=>"View Customer's Ticket",'icon'=>'pe-7s-user','sub-title'=>'View All Customer Ticket Request '];
       $btns = [
           ['name'=>"View All Tickets",'action'=>"admin/tickets", 'class'=>'btn btn-dark']
          ];
        ## $pendingTickets = CustomerTicket::with('specimen')->where(['create_mode'=>'completed'])->get()->toArray();
         # print "<pre>"; print_r($pendingTickets); die;
        return view('admin.tickets.tickets.tickets')->with(compact('btns','page_info'));
    }

    public function load_pending_tickets(Request $request) {
        
        if(!empty($request['filteration'])):
            $customers = User::select('id')->where('regno','LIKE','%'.$request['filteration']."%")
                ->orWhere('surname','LIKE','%'.$request['filteration']."%")
                ->orWhere('firstname','LIKE','%'.$request['filteration']."%")
                ->orWhere('othername','LIKE','%'.$request['filteration']."%")
                ->orWhere('email','LIKE','%'.$request['filteration']."%")
                ->orWhere('phone','LIKE','%'.$request['filteration']."%")
                ->limit(25)
                ->get()->pluck('id')->toArray();
                 
            $pendingTickets = CustomerTicket::with('specimen','results')
                 ->where('create_mode','completed')
                 ->where('finalized','no')
                ->whereIn('customer_id',$customers)              
                ->get()->toArray();
        else :
            $pendingTickets = CustomerTicket::with('specimen','results')
                ->where('create_mode','completed')
                ->where('finalized','no')
                ->get()->toArray();
        endif;
       # print "<pre>"; print_r($pendingTickets); exit;

        return response()->json([
        'view'=>(String)View::make('admin.tickets.process.pending_ticket_by_ajax')->with(compact('pendingTickets'))
        ]);
    }

    public function load_completed_tickets(Request $request) {
        $now = Carbon::now(); ##
        ## $now->subDay();
        $today = $now->toDateString();
        $real_date = $now->toDayDateTimeString();
        ##  print $today; die;
        $completedTickets = CustomerTicket::with('specimen')
                ->where(['create_mode'=>'completed','finalized'=>'yes'])
                ->where('date_finalized','like',$today."%")
                ->get()->toArray();
       ##  print "<pre>"; print_r($completedTickets); die;
        return response()->json([
        'view'=>(String)View::make('admin.tickets.completed.completed_ticket_by_ajax')->with(compact('completedTickets','real_date'))
        ]);
    }

    public function load_completed_tickets_by_dates(Request $request) {
        $data = $request->all();
        $dfrom = Carbon::parse($data['comp_from'])->startOfDay();
        $dto = Carbon::parse($data['comp_to'])->endOfDay();
        $real_date = " From  ".$dfrom->toDayDateTimeString(). " To ". $dto->toDayDateTimeString();
        ##  print $today; die;
      #  $dfrom->toFormattedDayDateString()
        $completedTickets = CustomerTicket::with('specimen')
                ->where(['create_mode'=>'completed','finalized'=>'yes'])
                ->whereBetween('date_finalized',[$dfrom,$dto])
                ->get()->toArray();
       ##  print "<pre>"; print_r($completedTickets); die;
        return response()->json([
          'type'=>'success',
        'view'=>(String)View::make('admin.tickets.completed.completed_ticket_by_ajax')->with(compact('completedTickets','real_date'))
        ]);
    }

    public function search_customer_completed_ticket(Request $request) {
         if($request->ajax()){
            $output="<table class='table table-hover table-sm'>";  $data = $request->all();
            $customers = User::select('id')->where('regno','LIKE','%'.$data['param']."%")
                    ->orWhere('surname','LIKE','%'.$data['param']."%")
                    ->orWhere('firstname','LIKE','%'.$data['param']."%")
                    ->orWhere('othername','LIKE','%'.$data['param']."%")
                    ->orWhere('email','LIKE','%'.$data['param']."%")
                    ->orWhere('phone','LIKE','%'.$data['param']."%")
                    ->limit(25)
                    ->get()->pluck('id')->toArray();
             ##print "<pre>";

            if(!empty($customers)) {
                $tickets = CustomerTicket::select('id','customer_id','ticket_no')->whereIn('customer_id',$customers)
                        ->where(['create_mode'=>'completed','finalized'=>'yes'])->get(); #->toArray();
            }
            else {
            $tickets = CustomerTicket::select('id','customer_id','ticket_no')
                        ->where(['create_mode'=>'completed','finalized'=>'yes'])
                        ->Where('ticket_no','LIKE','%'.$data['param']."%")
                        ->orWhere('hospital','LIKE','%'.$data['param']."%")
                        ->limit(25)
                        ->get(); #->toArray();
            }
           ## print_r($tickets); die;

           if(!empty($tickets))  {

             foreach($tickets as $key => $user) {
                $output.='<tr>'.
                '<td style="cursor:pointer" onclick="save_selected_ticket(\''.$user->ticket_no.'\')">'.$user->ticket_no.' '.
                ' &nbsp; '. users_name($user->customer_id).' '.' </td>'.
                '</tr>';
                }  ## end foreach
           }  ##  end if

           $output.= "</table>";

           return response($output);
         } ## end ajax
    }

    public function process_ticket($ticket_no) {
        $ticket_no = base64_decode($ticket_no);
        $ticket = CustomerTicket::with('specimen','results')->where('ticket_no',$ticket_no)->get()->toArray();
        Session::put('page','tickets'); Session::put('subpage','process-ticket');
        $page_info = ['title'=>"Process ". users_name($ticket[0]['customer_id'])."'s Ticket",'icon'=>'pe-7s-user','sub-title'=>"Ticket No :  $ticket_no "];
        $btns = [
           ['name'=>"View All Tickets",'action'=>"admin/tickets", 'class'=>'btn btn-dark']
          ];
          ## print "<pre>";        print_r($ticket); die;
           if($ticket[0]['finalized']=="yes"){
               return redirect('admin/tickets')->with('error_message','The Processing of This Ticket Has Already Been Completed');
           }
        return view('admin.tickets.process.process_view')->with(compact('btns','page_info','ticket'));
    }

    public function bill_result_template_loader(Request $request) {
        if($request->ajax()){
            $data = $request->all(); #  print "<pre>";  print_r($data); die;
            $ticket_no = $data['ticket_no']; $bill_id = $data['bill_id'];
            # print "<pre>";
            $bill_info = BillType::with('category','template')->find($data['bill_id'])->toArray();
           # dd($bill_info); exit;

            $result_info = CustomerTicket::with(['results'=>function($query)use($bill_id){
               $query->where('bill_type_id',$bill_id);
            }])->where('ticket_no',$ticket_no)->get()->toArray();

            # dd($result_info); exit;

            $template_type = $bill_info['template_type'];

             #print "<pre>";  print_r($template_type); die;

             if($template_type == "text_form") :
                return response()->json([
                    'view'=>(String)View::make('admin.tickets.process.text_result_template_by_ajax')->with(compact('bill_info','result_info','ticket_no','bill_id'))
                    ]);
             
            elseif($template_type == "param_form"):
                 return response()->json([
                    'view'=>(String)View::make('admin.tickets.process.param_result_template_by_ajax')->with(compact('bill_info','result_info','ticket_no','bill_id'))
                    ]);           
            ## if bill needs no medical report - just comment
            elseif(empty($template_type) && $bill_info['req_med_report']==0  && $bill_info['for_sale']==0) :
                return response()->json([
                    'view'=>(String)View::make('admin.tickets.process.items_with_no_report_by_ajax')->with(compact('bill_info','result_info','ticket_no','bill_id'))
                    ]);  
            ## items for sale 
            elseif($template_type == "for_sale" && $bill_info['req_med_report']==0  && $bill_info['for_sale']==1 ) :
                # print "<pre>"; print_r($bill_info); die; 
                return response()->json([
                    'view'=>(String)View::make('admin.tickets.process.items_for_sales_by_ajax')->with(compact('bill_info','result_info','ticket_no','bill_id'))
                    ]);       
            // no template has been set up 
             elseif($bill_info['req_med_report']==1 && empty($template_type)):
                return response()->json([
                    'view'=>(String)View::make('admin.tickets.process.redr_setup_report_template')->with(compact('bill_info','result_info','ticket_no','bill_id'))
                    ]);  
            endif;
        } ## end ajax
    } ## end function

    ### submit result
    public function submit_specimen_report(Request $request) {
        if($request->ajax()){
             $data = $request->all();  # print "<pre>";  print_r($data); die;
             $type = $data['report_type'];  $ticket_no = $data['ticket_no'];
             $bill_id = $data['bill_id'];
             $date_perform = Carbon::now(); $admin_id = Auth::guard('admin')->user()->id;
             // text report type
             #####################
             $customer_info = CustomerTicket::where('ticket_no',$ticket_no)->get()->first()->toArray();
             $bill_info = BillType::with('template')->find($bill_id)->toArray();
             $specimen =  CustomerSpecimen::where([
                        'customer_id'=>$customer_info['customer_id'],
                        'ticket_id'=>$customer_info['id'],
                        'ticket_no'=>$ticket_no,
                        'bill_type_id'=>$bill_id])->first();
             
             # print "<pre>";  print_r($customer_info); die;

             if($type=="text"):
                 $savedResult = CustomerSpecimenResult::firstOrNew([
                     'customer_id'=>$customer_info['customer_id'],
                     'ticket_no'=>$ticket_no,   'bill_type_id'=>$bill_id,
                     'template_id'=>$bill_info['template'][0]['id']
                    ]);
                 $savedResult->customer_id = $customer_info['customer_id'];
                 $savedResult->ticket_no = $ticket_no;
                 $savedResult->bill_type_id = $bill_id;
                 $savedResult->ticket_id = $customer_info['id'];
                 $savedResult->template_id = $bill_info['template'][0]['id'];
                 $savedResult->raw_text_val = $data['report'];
                 $savedResult->comment = $data['comment'];
                 $savedResult->save();
                 ## update the customer specimen too
                   CustomerSpecimen::where([
                        'customer_id'=>$customer_info['customer_id'],
                        'ticket_id'=>$customer_info['id'],
                        'ticket_no'=>$ticket_no,
                        'bill_type_id'=>$bill_id])->update([
                        'process_completed'=>'yes',
                        'date_perform'=>$date_perform,
                        'result_uploaded_by'=>$admin_id
                        ]);
                 return response()->json([
                     'type'=>'success','message'=>'Report Saved Successfully'
                     ]);
             endif; ## end text
             
             if($type =="param"):
                ## print "<pre>";  print_r($data); die;
                foreach($data['temp_id'] as $k=>$template_id ){
                     $savedResult = CustomerSpecimenResult::firstOrNew([
                     'customer_id'=>$customer_info['customer_id'],
                     'ticket_no'=>$ticket_no,   'bill_type_id'=>$bill_id,
                     'template_id'=>$template_id
                    ]);
                    $savedResult->customer_id = $customer_info['customer_id'];
                    $savedResult->ticket_no = $ticket_no;
                    $savedResult->bill_type_id = $bill_id;
                    $savedResult->ticket_id = $customer_info['id'];
                    $savedResult->template_id = $template_id;
                    $savedResult->result = $data['scores'][$k];
                    $savedResult->comment = $data['comments'][$k];
                    $savedResult->save();
                    ## update th customer specimen too
                    CustomerSpecimen::where([
                        'customer_id'=>$customer_info['customer_id'],
                        'ticket_id'=>$customer_info['id'],
                        'ticket_no'=>$ticket_no,
                        'bill_type_id'=>$bill_id])->update([
                        'process_completed'=>'yes',
                        'date_perform'=>$date_perform,
                        'result_uploaded_by'=>$admin_id
                        ]);
                } ## end foreach
                return response()->json([
                     'type'=>'success','message'=>'Report Saved Successfully'
                     ]);
             endif; ## end param
             
             if($type == "no_report"):                                
                 $savedResult = CustomerSpecimenResult::firstOrNew([
                     'customer_id'=>$customer_info['customer_id'],
                     'ticket_no'=>$ticket_no,   'bill_type_id'=>$bill_id,                     
                    ]); ## 'template_id'=>$bill_info['template'][0]['id']  - removed
                 $savedResult->customer_id = $customer_info['customer_id'];
                 $savedResult->ticket_no = $ticket_no;
                 $savedResult->bill_type_id = $bill_id;
                 $savedResult->ticket_id = $customer_info['id'];
                 # $savedResult->template_id = $bill_info['template'][0]['id'];
                 $savedResult->raw_text_val = $data['report2'];
                 # $savedResult->comment = $data['comment'];
                 $savedResult->save();
                 ## update th customer specimen too
                   CustomerSpecimen::where([
                        'customer_id'=>$customer_info['customer_id'],
                        'ticket_id'=>$customer_info['id'],
                        'ticket_no'=>$ticket_no,
                        'bill_type_id'=>$bill_id])->update([
                        'process_completed'=>'yes',
                        'date_perform'=>$date_perform,
                        'result_uploaded_by'=>$admin_id
                        ]);
                 return response()->json([
                     'type'=>'success','message'=>'Report Saved Successfully'
                     ]);
             endif;
             
            if($type == "for_sale"):
                  if($customer_info['payment_completed']=="no"):
                     return response()->json([
                        'type'=>'error','message'=>'The Payment has not been completed '
                     ]);                  
                     elseif($bill_info['qty_rem'] < $specimen['qty_buy']): ## confirm if the item buying is still available
                        return response()->json([
                            'type'=>'error','message'=>'The Quantity you are buying is no more available'
                        ]);                  
                     else:
                         
                       $qty_left = $bill_info['qty_rem'] - $specimen['qty_buy'];
                             
                    $savedResult = CustomerSpecimenResult::firstOrNew([
                     'customer_id'=>$customer_info['customer_id'],
                     'ticket_no'=>$ticket_no,   'bill_type_id'=>$bill_id,                     
                    ]); ## 'template_id'=>$bill_info['template'][0]['id']  - removed
            
                 $savedResult->customer_id = $customer_info['customer_id'];
                 $savedResult->ticket_no = $ticket_no;
                 $savedResult->bill_type_id = $bill_id;
                 $savedResult->ticket_id = $customer_info['id'];
                 # $savedResult->template_id = $bill_info['template'][0]['id'];
                 $savedResult->raw_text_val = "Sold To Customer";
                 # $savedResult->comment = $data['comment'];
                 $savedResult->save();
                 ## update th customer specimen too
                   CustomerSpecimen::where([
                        'customer_id'=>$customer_info['customer_id'],
                        'ticket_id'=>$customer_info['id'],
                        'ticket_no'=>$ticket_no,
                        'bill_type_id'=>$bill_id])->update([
                        'process_completed'=>'yes',
                        'date_perform'=>$date_perform,
                        'result_uploaded_by'=>$admin_id
                        ]);
                   # Update the Qty remaining too on bill type
                   BillType::where('id',$bill_id)->update(['qty_rem'=>$qty_left]);
                   # print "<pre>";   print_r($bill_info); die;
                    return response()->json([
                     'type'=>'success','message'=>'Sales Successfully Approved'
                     ]);
                 endif;
             endif; #  end for_sale

        } ## end ajax
    }

    public function save_specimen_perform_date(Request $request) {
         if($request->ajax()){
             $data = $request->all(); ##   print "<pre>";  print_r($data); die;
             CustomerSpecimen::where('id',$data['spec'])->update(['date_perform'=>$data['date']]);
             return response()->json([
                'type'=>'success','message'=>'Date Performed Successfully Saved '
                ]);

         }// end ajax
    }

    public function save_pathologist_comment(Request $request) {
         if($request->ajax()){
             $data = $request->all(); ##   print "<pre>";  print_r($data); die;
             CustomerSpecimen::where('id',$data['spec'])->update(['comment'=>$data['comment']]);
             return response()->json([
                'type'=>'success','message'=>'Pathologist Comment Successfully Saved '
                ]);
         }// end ajax
    }

    public function finalize_test_process(Request $request) {
         if($request->ajax()){
             $data = $request->all();  #print "<pre>";  print_r($data); die;
             $now = $data['date']; $admin_id = Auth::guard('admin')->user()->id;
             ## update ticket
             CustomerTicket::where('ticket_no',$data['ticket_no'])->update(
                     [
                         'finalized'=>'yes',
                         'date_finalized'=>$now,
                         'finalized_by'=>$admin_id
                       ]
             );
             return response()->json([
                'type'=>'success','message'=>'Ticket Successfully Finalized ',
                 'url'=>url('admin/tickets')
                ]);
         }// end ajax
    }

    public function print_ticket_result($ticket,$specimens) {
      # print "<pre>";  // print_r($request->all()); die;
        $ticket_no = base64_decode($ticket);
        $spec_code = explode(',',$specimens);  $bill_ids = array_map(fn($code)=> base64_decode($code), $spec_code);
        $ticket_info = CustomerTicket::with(['payment',
            'specimen'=>function($query)use($bill_ids){ $query->whereIn('bill_type_id',$bill_ids);},
            // 'results'=>function($query)use($bill_ids){ $query->whereIn('bill_type_id',$bill_ids);}
            ])->where('ticket_no',$ticket_no)->get()->toArray();
         # print_r($ticket_info); die;
         $page_info = ['title'=> users_info($ticket_info[0]['customer_id'])['fullname']."_".str_replace('/','',$ticket_no)."_Result_Printout",'icon'=>'pe-7s-user','sub-title'=>'Final Printout '];
       
         return view('admin.tickets.printing.printout')->with(compact('ticket_info','page_info'));
    }
    // download_ticket_result
    public function download_ticket_result($ticket,$specimens) {
        $page_info = ['title'=>"Result Download",'icon'=>'pe-7s-file','sub-title'=>'Final Printout '];
        # print "<pre>";  // print_r($request->all()); die;
         $ticket_no = base64_decode($ticket);
         $spec_code = explode(',',$specimens);  $bill_ids = array_map(fn($code)=> base64_decode($code), $spec_code);
         $ticket_info = CustomerTicket::with([
             'specimen'=>function($query)use($bill_ids){ $query->whereIn('bill_type_id',$bill_ids);},
             // 'results'=>function($query)use($bill_ids){ $query->whereIn('bill_type_id',$bill_ids);}
             ])->where('ticket_no',$ticket_no)->get()->toArray();
        $filename = str_replace("/","",$ticket_no)."_result.pdf";
        $pdf = PDF::loadView('admin.tickets.download.download',compact('ticket_info','page_info'));
        return $pdf->download($filename);

     }

    public function fetch_customer_completed_ticket_info(Request $request) {
        if($request->ajax()){
            $data = $request->all(); $ticket_no = $data['ticket_no'];
            $now = Carbon::now();
            $real_date = $now->toDayDateTimeString();
            ##  print $today; die;
            $completedTickets = CustomerTicket::with('specimen')
                    ->where(['create_mode'=>'completed','finalized'=>'yes',
                        'ticket_no'=>$ticket_no])
                    #->where('date_finalized','like',$today."%")
                    ->get()->toArray();
           ##  print "<pre>"; print_r($completedTickets); die;
            return response()->json([
                'type'=>'success',
            'view'=>(String)View::make('admin.tickets.completed.completed_ticket_by_ajax')->with(compact('completedTickets','real_date'))
            ]);
        }
    }
    
    public function add_more_investigation(Request $request){
        if($request->ajax()){
             $data = $request->all(); 
             $ticket_no = $data['ticket_no'];
             $user_id = $data['user_id'];
             
             return response()->json([
                'type'=>'success',
            'view'=>(String)View::make('admin.tickets.process.specimen_search_form')->with(compact('ticket_no','user_id'))
            ]);
        }
    }
    
     public function search_specimen_info_2(Request $request) {
         if($request->ajax()){
            $output="<table class='table table-hover table-sm'>";  $data = $request->all();
            $bills = BillType::where('name','LIKE','%'.$data['sparam']."%")
                    ->orWhere('specimen_sample','LIKE','%'.$data['sparam']."%")
                    ->limit(25)
                    ->get();

            if(!is_null($bills)) {
             foreach($bills as $key => $bill) {
                $output.='<tr>'.
                '<td style="cursor:pointer" onclick="save_selected_specimen_2(\''.$bill->id.'\',\''.$bill->name.'\')">'.$bill->name.' '.
                ' /  '.$bill->specimen_sample.'  </td> </tr>';
                }  ## end foreach
           }  ##  end if
           $output.= "</table>";

           return response($output);
         } ## end ajax
    }


    
    ## STEP 2 B  - DURING TICKET PROCESSING ## AFTER SEARCHED -
       public function fetch_specimen_info_2(Request $request) {
         if($request->ajax()){
             $data = $request->all(); 
           #  print "<pre>"; print_r($data); 
           /*
                Array
                (
                    [bill_id] => 16
                    [user_id] => 11045
                    [ticket_no] => 25/FEMC/0001
                )
            **/
             ## 
             $bill = BillType::where('id',$data['bill_id'])->first()->toArray();
             $user = User::where('id',$data['user_id'])->first()->toArray();
             $today = Carbon::now();
             $child_min_years = $today->subYears(15);
             $whom = ($user['dob'] < $child_min_years )?"adult":"children";
             $admin_id = Auth::guard('admin')->user()->id;
              ## fetch temporally saved bills
              $ticket = CustomerTicket::with('specimen')->where([
                 'ticket_no'=>$data['ticket_no'],
                 'customer_id'=>$data['user_id'],
                 'create_mode'=>'completed'])->get()->toArray();
               
            # print "<pre>"; print_r($ticket); die;

              return response()->json([
                'view'=>(String)View::make('admin.tickets.process.specimen_add_by_ajax')->with(compact('bill','user','whom','ticket'))
            ]);
         }
       }
       ###
       #### STEP 2 - FOR FINALIZING ADD MORE INVESTIGATION  ############
       public function add_ticket_bill_2(Request $request) {
         if($request->ajax()){
             $data = $request->all();
             // print "<pre>";   print_r($data); // die;
             ## bill_id and user_id & specimen
             $admin_id = Auth::guard('admin')->user()->id;

             $message = "Bill Added Successfully";

             $ticket = CustomerTicket::firstOrNew([
                 'ticket_no'=>$data['ticket_no'],                
                 'create_mode'=>'completed',
                 'customer_id'=>$data['user_id']
                 ]);

             $today = Carbon::now();
             $ticket->ticket_no = $data['ticket_no'];
             $ticket->create_mode = 'completed';
             $ticket->customer_id = $data['user_id'];            
             $ticket->save();

            $ticket_id = $ticket->id;
            
            #validate the bill - in case of buying above qty available
            
            $bill_info = BillType::bill_info($data['bill_id']); 
            
            if($bill_info['for_sale']==1 && $data['qty_buy'] > $bill_info['qty_rem']):
                 return response()->json([
                 'type'=>'error',
                 'message'=>'The Quantity You Are Selling Out Is Not Available'
                ]); 
                elseif($bill_info['for_sale']==1  &&  $data['qty_buy'] <= 0):
                 return response()->json([
                 'type'=>'error',
                 'message'=>'Enter Correct Quantity To Sell Out ( Qty = '. $data['qty_buy'].' )'
                ]); 
            endif;
            
           #  print_r($bill_info); die; 
            # exit; 
             ## process the specimen
             $specimen = CustomerSpecimen::firstOrNew([
                 'customer_id'=>$data['user_id'],
                 'ticket_id'=>$ticket_id,
                 'ticket_no'=>$data['ticket_no'],
                 'created_by'=>$admin_id,
                 'create_mode'=>'completed',
                 'bill_type_id'=>$data['bill_id']
             ]);
             
             
             $specimen->customer_id = $data['user_id'];
             $specimen->created_by = $admin_id;
             $specimen->create_mode = 'completed';
             $specimen->ticket_id = $ticket_id;
             $specimen->ticket_no = $data['ticket_no'];
             $specimen->bill_type_id = $data['bill_id'];
             $specimen->specimen_sample = $data['specimen'];
             //for product selling 
             if($bill_info['for_sale']==1):
                $specimen->bill_price = ($data['price'] * $data['qty_buy']);
                $specimen->qty_buy = $data['qty_buy']; 
                    else :
                 $specimen->bill_price = $data['price'];
             endif;
             
             $specimen->save();
            
             
             $tcost = CustomerSpecimen::where(['ticket_id'=>$ticket_id,'ticket_no'=>$data['ticket_no']])->sum('bill_price');
            
            CustomerTicket::where([
                 'ticket_no'=>$data['ticket_no'],                
                 'create_mode'=>'completed',
                 'customer_id'=>$data['user_id']
                 ])->update([
                     'total_cost'=>$tcost,
                     'payment_completed'=>'no',
                     'payment_finalized'=>'no'
                 ]);
             ## save the specimen
             return response()->json([
                 'type'=>'success',
                 'message'=>$message
                ]);
         }
       }

}

