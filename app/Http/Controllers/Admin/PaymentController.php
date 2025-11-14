<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerBill;
use App\Models\CustomerTicket;
use App\Models\PaymentLog;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;
use function paymode_amount;
use function response;
use function users_name;
use function view;


class PaymentController extends Controller
{
    
     public function payments_receipts() {
         Session::put('page','billings'); Session::put('subpage','pending-payments');       
         $btns = [
           ['name'=>"View All Tickets",'action'=>"admin/tickets", 'class'=>'btn btn-dark']
          ]; 
         $page_info['title'] = "All Payments And Receipts ";                                            
       return view('admin.tickets.payment.ticket_payment')->with(compact('page_info','btns'));
    }
    
    #############################
     public function list_pending_payments(Request $request) {
          if($request->ajax()){
            ## print "<pre>"; $data = $request->all();  print_r($data);  die;            
            ## $payments = CustomerTicket::with('payment')->where(['create_mode'=>'completed','payment_completed'=>'no'])->get()->toArray(); ## groupBy('ticket_id')
            $payments = CustomerBill::with('payment')->where(['payment_completed'=>false])->get()->toArray(); ## groupBy('ticket_id')
            # print_r($payments);  die; 
             return response()->json(['type'=>'success',
                'view'=>(String)View::make('admin.tickets.payment.customer_pending_payment_ajax')->with(compact('payments'))
                ]);
          }
     }
     
    public function ticket_payment() {
         Session::put('page','ticket-payment'); Session::put('subpage','ticket-payment');       
         $btns = [
           ['name'=>"View All Tickets",'action'=>"admin/tickets", 'class'=>'btn btn-dark']
          ]; 
         $page_info['title'] = "Payments & Receipts ";                                            
       return view('admin.tickets.payment.ticket_payment')->with(compact('page_info','btns'));
    }
    
    public function fetch_customer_payment_info(Request $request) {
         if($request->ajax()){
              $data = $request->all();      
            # print "<pre>"; 
              $rules = [
                  'ticketno'=>'required|string|max:20|exists:customer_bills'
              ];              
              $messages = [
                  'ticketno.required'=>'Please supply the ticket number',
                  'ticket_no.string'=>'Ticket Number must be a string type',
                  'ticketno.max'=>'Ticket Number cannot be more than 20 characters',
                  'ticketno.exists'=>'This Ticket Number does not exists',
              ];
              
             $validator = Validator::make($data, $rules,$messages);
             if($validator->fails()){ // or use $validator->passes()
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
            }
             if($validator->passes()){ // or use $validator->fails()
                 # $payments = CustomerTicket::with('specimen','payment')
                 $payments = CustomerBill::with('investigations.template','prescriptions.item','payment')
                         ->where(['ticketno'=>$data['ticketno']])->first()->toArray(); 
             #     print_r($payments); die; 
                 return response()->json(['type'=>'success',
                'view'=>(String)View::make('admin.tickets.payment.customer_paym_search_output_ajax')->with(compact('payments'))
            ]);   
            }
              //print_r($data); die; 
         }
    }
    
    ########################
    public function submit_ticket_payment(Request $request) {
        if($request->ajax()){
            $data = $request->all();  $ticket_no = $data['ticketno']; 
            ## notes for amount index 
            ## cash = 0 , pos = 1, transfer = 2
            $paymodes = $data['paymode']; 
            $amounts = $data['amounts']; 
            $admin_id = Auth::guard('admin')->user()->id;
            #$ticket_info = CustomerTicket::with('specimen','payment')->where('ticket_no',$ticket_no)->first()->toArray();
            $ticket_info = CustomerBill::with('payment')->where('ticketno',$ticket_no)->first()->toArray();
            ## check if paid before
            $prev_paid  = 0;  $tcost = 0; 
            if(!empty($ticket_info['payment'])){
                foreach($ticket_info['payment'] as $paid){
                    $prev_paid += $paid['amount_paid'];
                }
            } 
            $tcost = $ticket_info['total_cost'];
           
             ##print "<pre>";             
            // loop through the payments 
            ## print_r($prev_paid);  die;
            $total = $prev_paid; 
            foreach ($paymodes as $paymode){
            $total += str_replace(",","",paymode_amount($paymode, $amounts));
            $paylog = new PaymentLog;
            $paylog->ticketno = $ticket_no;                        
            $paylog->appointment_id  = $ticket_info['appointment_id']; 
            $paylog->customer_bill_id  = $ticket_info['id']; 
            $paylog->amount_paid = str_replace(",","",paymode_amount($paymode, $amounts)); 
            $paylog->paymode = $paymode; 
            $paylog->date_paid = Carbon::now();
            $paylog->collected_by = $admin_id;
            $paylog->save();
            } ## end foreach  
            ## update ticket
            $paym_comp = ($total >= $tcost);  ## payment completed
            $amount_paid = ($total >= $tcost) ? $tcost : $total; 
            $refund = ($total >= $tcost) ? ($total - $tcost ) : 0; 
            #############
            CustomerBill::where(['id'=>$ticket_info['id']])
                ->update(['amount_paid'=>$amount_paid,
                    'refund'=>$refund,
                    'payment_completed'=>$paym_comp
                  ]);  
                          
             return response()->json(['type'=>'success',
                'message'=>" Total of N $total Payment Has been Made Successfully now"]);
        }
    }
     ####
    
    
    ## about to make payment 
    public function search_payment_info(Request $request) {
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
                        ->where('create_mode','completed')->get(); #->toArray();                
            }
            else {
            $tickets = CustomerTicket::select('id','customer_id','ticket_no')
                        ->where('create_mode','completed')
                        ->Where('ticket_no','LIKE','%'.$data['param']."%")
                        ->orWhere('hospital','LIKE','%'.$data['param']."%")
                        ->limit(25)
                        ->get(); #->toArray();                               
                 }  
           ## print_r($tickets); die; 
             
           if(!empty($tickets))  {           
             foreach($tickets as $key => $user){
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
    
     public function fetch_ticket_payment_by_dates(Request $request) {
          if($request->ajax()){
            $data = $request->all(); 
            # print "<pre>";             
            # print_r($data);  die;
            $dfrom = Carbon::parse($data['pay_sum_from'])->startOfDay();
            $dto = Carbon::parse($data['pay_sum_to'])->endOfDay();
             
            $payments = PaymentLog::with(['ticket'
                ])->whereBetween('date_paid',[$dfrom,$dto])->get()->groupBy('ticket_id')->toArray(); ## 
            # print_r($payments);  die; 
             return response()->json(['type'=>'success',
                'view'=>(String)View::make('admin.tickets.payment.customer_paym_date_search_ajax')->with(compact('payments'))
                ]);
          }
     }
    #############################
     public function fetch_ticket_payment_by_tickets(Request $request) {
          if($request->ajax()){
            $data = $request->all(); 
            # print "<pre>";             
            # print_r($data);  die;
            $dfrom = Carbon::parse($data['ticket_from'])->startOfDay();
            $dto = Carbon::parse($data['ticket_to'])->endOfDay();
             
            $payments = CustomerTicket::with(['payment'
                ])->whereBetween('request_date',[$dfrom,$dto])->get()->toArray(); ## groupBy('ticket_id')
            # print_r($payments);  die; 
             return response()->json(['type'=>'success',
                'view'=>(String)View::make('admin.tickets.payment.customer_paym_ticket_search_ajax')->with(compact('payments'))
                ]);
          }
     }
     
    
     public function print_receipt($ticket_no) {
         $page_info['title'] = "Payments & Receipts ";
         $ticket_no = base64_decode($ticket_no); 
         $ticket_info = CustomerBill::with(['investigations.template','prescriptions.item',
             'appointment.patient','payment'])->where('ticketno',$ticket_no)->get()->first();
         #print "<pre>"; 
         #print_r($ticket_info->toarray());  die; 
          // Instantiate the classes
        $barcode = new DNS1D();
        $qrcode = new DNS2D();
        $codeno = $ticket_no;
        // Generate barcodes
        // $barcodeImage = $barcode->getBarcodePNG($codeno, 'C128',1.5,40,'000',true);
        $barcodeImage = $qrcode->getBarcodePNG($codeno, 'QRCODE');
        # $qrcodeImage = $qrcode->getBarcodePNG('Hello World', 'QRCODE');
        
         return view('admin.tickets.receipt.printout')->with(compact('ticket_info','page_info','barcodeImage'));
     }
}
