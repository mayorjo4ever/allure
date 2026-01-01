<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\CustomerBill;
use App\Models\Organization;
use App\Models\PaymentInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;
use PDF;
use function abort;
use function new_org_invoice_no;
use function redirect;
use function response;
use function view;

class InsuranceController extends Controller
{
    public function accounts() {
        Session::put('page','billings'); Session::put('subpage','accounts');
            $page_info = ['title'=>'Our Bank Accounts','icon'=>'pe-7s-notebook','sub-title'=>'Below are list of Our Bank Accounts'];
             $btns = [
                 ['name'=>"Create New Account",'action'=>"admin/add-edit-account", 'class'=>'btn btn-success'],
                 ];
            
            $accounts = Account::all();
            
           
          return view('admin.insurance.accounts',compact('page_info','accounts','btns'));
    }
      public function add_edit_account(Request $request, $id=null) {
       Session::put('page','billings'); Session::put('subpage','accounts');
        if($id==''){
           $page_info = ['title'=>'Create New Bank Account','icon'=>'pe-7s-cash','sub-title'=>'Create / Edit  Bank Account'];
           $account = new Account(); $message = "New Bank Account Successfully Saved";
       }
       else { ##
           $page_info = ['title'=>'Edit Bank Account ','icon'=>'pe-7s-notebook','sub-title'=>' '];
           $account = Account::find($id); $message = "Bank Account Successfully Updated";
       }
       ######## form submission
       if($request->isMethod('post')){          
         #  print "<pre>";   print_r($data); die;             
           $rules = [
                'bank' => [
                    'required',
                    'string',
                    'max:255',
                    // Rule::unique('accounts')->ignore($account->id), // ignore current record on update
                ],
                'name' => [
                    'required',
                    'string',
                    'max:255',                   
                ],
                'number' => ['required','digits:10'],
            ];
            $customMessage = [
               'bank.required'=>"Please provide the Bank Name",
               ## 'name.unique'=>"This Name has already been taken",
               'amount.required'=>"Please provide the amount "
                ];
            ##$validator = Validator::make($data, $rules,$customMessage);
            $this->validate($request, $rules, $customMessage);
            $isMain = $request->is_main_account ?? 0;             
            $account->bank = $request->bank;
            $account->name = $request->name;
            $account->number = $request->number;
            if($isMain==1):
                Account::where('active',1)->update(['active'=>0]);
            endif;
            $account->active = $isMain; 
            $account->status = 1;
            
            $account->save();

            return redirect('admin/accounts')->with('success_message',$message); # redirect('admin/bill-samples')
            //  return redirect('admin/bill-category')->with('success_message',$message);
            // return response()->json(['type'=>'success','success_message'=>$message,'url'=>'subjects']);
       }
       $btns = [
           ['name'=>"<-- View Organizations ",'action'=>"admin/organizations", 'class'=>'btn btn-dark'],
           ['name'=>"View Our Accounts",'action'=>"admin/accounts", 'class'=>'btn btn-primary']];       
      return view('admin.insurance.add_edit_account',compact('page_info','account','btns'));
    }
    
     public function updateBankAccountStatus(Request $request){     
          if($request->ajax()){
            $data = $request->all(); $respStatus = "1";            
            if($data['status']=="active") :  $respStatus = "0";  endif;            
                Account::where('id',$data['data_id'])->update(['status'=>$respStatus]);            
            return response()->json(['status'=>$respStatus]);
        }
    }
    
     public function load_organizational_bodies(Request $request){     
          if($request->ajax()){
            $data = $request->all(); $respStatus = "1";            
            $bodies = Organization::where('status',1)->get(); // active bodies            
            return response()->json([
                'view' => (string) View::make('admin.insurance.organ_bodies_ajax')
                        ->with(compact('bodies'))
                  ]);
        }
    }
    
    public function check_our_initial_bills(Request $request) {
         if($request->ajax()){
             $org_id = $request->org_id;  $bills = explode(",",$request->new_bills);
             $initial_bills = PaymentInvoice::with('user','bill')->where('organization_id',$org_id)
                     ->where('status','opened')->get();
             $new_bills = CustomerBill::with('user')->whereIn('id',$bills)->get();
             return response()->json([
                 'initial_bills'=>(string)View::make('admin.insurance.organ_init_bills_ajax')->with(compact('initial_bills','org_id')),
                 'new_bills'=>(string)View::make('admin.insurance.organ_new_bills_ajax')->with(compact('new_bills','org_id'))
               ]);
         }
    }
/**
    public function submit_organization_bill(Request $request) {
         if($request->ajax()){
             # print "<pre>";  // print_r($request->all()); die;      
             $org_id = $request->organization_id; 
             $bills = CustomerBill::with('user')->whereIn('id',$request->bill_ids)->get();
            # print_r($bills->toarray()); die;
             $account = Account::where('active',1)->first();
             $i = 0; 
             $user = Auth('admin')->user();
             
             foreach($bills as $bill):               
                 $invoice = PaymentInvoice::updateOrCreate([
                     'organization_id'=>$org_id,
                     'customer_bill_id'=>$bill->id,
                     'appointment_id'=>$bill->appointment_id,
                     'patient_id'=>$bill->patient_id,
                     'account_id'=>$account->id
                 ],[
                     'amount'=>($bill->total_cost - $bill->amount_paid),
                     'discount'=>$request->discounts[$i],
                     'created_by'=>$user->id
                 ]);
                 $i++;
             endforeach;
            # die; 
             $initial_bills = PaymentInvoice::with('user','bill')->where('organization_id',$org_id)
                     ->where('status','opened')->get();
             
             return response()->json([
                 'our_bills'=>(string)View::make('admin.insurance.organ_init_bills_ajax')->with(compact('initial_bills','org_id'))
              ]);
         }
    }
    
   **/
    
    public function submit_organization_bill(Request $request)
    {
        if (!$request->ajax()) {
            abort(403);
        }

        $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'bill_ids'        => 'required|array',
            'bill_ids.*'      => 'exists:customer_bills,id',
        ]);

        $org_id  = $request->organization_id;
        $billIds = $request->bill_ids;

        // 🔒 Prevent cross-organization reuse
        $conflict = PaymentInvoice::whereIn('customer_bill_id', $billIds)
            ->where('organization_id', '!=', $org_id)
            ->exists();

        if ($conflict) {
            return response()->json([
                'status'=>'error',
                'message' => 'One or more bills are already assigned to another organization.'
            ],200);
        }

        $bills   = CustomerBill::with('user')->whereIn('id', $billIds)->get();
        $account = Account::where('active', 1)->firstOrFail();
        $user    = Auth('admin')->user();

        foreach ($bills as $i => $bill) {
            PaymentInvoice::updateOrCreate(
                [
                    'organization_id'   => $org_id,
                    'customer_bill_id'  => $bill->id,
                ],
                [
                    'appointment_id' => $bill->appointment_id,
                    'patient_id'     => $bill->patient_id,
                    'account_id'     => $account->id,
                    'amount'         => ($bill->total_cost - $bill->amount_paid),
                    'discount'       => $request->discounts[$i] ?? 0,
                    'created_by'     => $user->id,
                ]
            );
        }

        $initial_bills = PaymentInvoice::with('user', 'bill')
            ->where('organization_id', $org_id)
            ->where('status', 'opened')
            ->get();

        return response()->json([
            'our_bills' => (string) view(
                'admin.insurance.organ_init_bills_ajax',
                compact('initial_bills', 'org_id')
            )
        ]);
    }

    
     public function updateOrganizationStatus(Request $request){
          if($request->ajax()){
            $data = $request->all(); $respStatus = "1";            
            if($data['status']=="active") :  $respStatus = "0";  endif;            
               Organization::where('id',$data['data_id'])->update(['status'=>$respStatus]);            
            return response()->json(['status'=>$respStatus]);
        }
    }
    
    public function organizational_bodies() {
        Session::put('page','organizations'); Session::put('subpage','organizations');
            $page_info = ['title'=>'Organizational Bodies','icon'=>'fa fa-users','sub-title'=>'Below are list of Our Bank Accounts'];
             $btns = [
                 ['name'=>"Create New Organizational Body",'action'=>"admin/add-edit-organization", 'class'=>'btn btn-success'],
                 ];            
           $organizations = Organization::withSum(
            ['openedInvoices as total_opened_amount' => function ($query) {
                $query->where('status', 'opened');
            }],
            'amount'
            )->get();                       
          return view('admin.insurance.organ_bodies',compact('page_info','organizations','btns'));
    }
    
    public function organization_bills($id) {
        $organization = Organization::with('openedInvoices.user','openedInvoices.bill')->findOrFail($id);        
        //print "<pre>";   print_r($organization->toarray()); die;   
         $page_info = ['title'=>$organization->name."'s Bills",'icon'=>'pe pe-7s-cash','sub-title'=>'Invoice Bills To be Paid'];       
        Session::put('page','organizations'); Session::put('subpage','organizations');
        return view('admin.insurance.organ_invoice_bills',compact('page_info','organization'));
    }
    
    public function delete_organization_invoice_bill(Request $request){
        if($request->ajax()):
            # print "<pre>"; print_r($request->all()); 
            $id = explode('|',$request->params)[0]; 
            $invoice = PaymentInvoice::findOrFail($id);
            $invoice->delete();            
         return response()->json(['message'=>'Invoice Deleted Successfully' ]);
        endif;
        
    }
     
    public function finalize_organization_invoice(Request $request , $id){
        if($request->ajax()):
            # print "<pre>"; print_r($request->all()); 
            $invoice_no = new_org_invoice_no($id); 
            $organ_body = PaymentInvoice::
                where(['organization_id'=>$id,'status'=>'opened'])
                ->update([
                    'status'=>'closed',
                    'invoice_number'=>$invoice_no
                ]);                       
         return response()->json(['message'=>"Invoice Finalized Successfully With No: $invoice_no" ]);
        endif;
        
    }
    
    public function organizations_unpaid_invoices($invoice_no = null) {
        // $organization = Organization::with('closedInvoices.user','openedInvoices.bill')->findOrFail($id);        
        $invoices = PaymentInvoice::where('status','closed')
                ->where('payment_completed','0')
                ->distinct()->select('invoice_number','organization_id')           
                ->get(); 
        
        if($invoice_no !=""):
            $organ_invoice = PaymentInvoice::with(['user',
                'bill',
                'appointment.investigations.template',
                'appointment.prescriptions.item'                
                ])
                ->where('invoice_number',$invoice_no)                
                ->where('status','closed')                
                ->get(); 
                $organ_id= PaymentInvoice::select('organization_id')->where('invoice_number',$invoice_no)->first();  
                $organization = Organization::find($organ_id->organization_id);
               # print "<pre>";   print_r($organ_invoice->toarray()); die;   
            $page_info = ['title'=>$organization->name."'s Bills - #".$invoice_no,'icon'=>'pe pe-7s-cash','sub-title'=>'Invoice Bills To be Paid'];       
           Session::put('page','organizations'); Session::put('subpage','organizations');
           return view('admin.insurance.organ_unpaid_invoice_bills',compact('page_info','organ_invoice','organization','invoice_no'));
     
        endif;        
        
        # print "<pre>";   print_r($invoices->toarray()); die;   
        $page_info = ['title'=>"List of Unpaid Invoices ",'icon'=>'pe pe-7s-cash','sub-title'=>'Invoice To be Paid'];       
        Session::put('page','organizations'); Session::put('subpage','unpaid-invoices');
        return view('admin.insurance.unpaid_invoices',compact('page_info','invoices'));    
    }
    
      public function download_organization_unpaid_invoice($invoice_no) {
        $page_info = ['title'=>"Result Download",'icon'=>'pe-7s-file','sub-title'=>'Invoice Notes '];
       # print "<pre>";   print_r($invoice_no); // die;
         $organ_invoice = PaymentInvoice::with(['user',
            'bill','appointment.consultation',
            'appointment.investigations.template',
            'appointment.prescriptions.item'                
            ])
            ->where('invoice_number',$invoice_no)                
            ->where('status','closed')                
            ->get(); 
            $organ_id = PaymentInvoice::select('organization_id')->where('invoice_number',$invoice_no)->first();  
            $organization = Organization::find($organ_id->organization_id);
           // $account = Account::where('active',1)->first(); 
           #   print "<pre>";   print_r($organ_invoice->toarray()); die;   
             
        $fullname = str_replace(" ","_",$organization->name)."_".str_replace("/","",$invoice_no);         
        $filename = $fullname."_Invoice.pdf";
        ## removed ,'account' from compact
        $pdf = PDF::loadView('admin.insurance.download.unpaid_invoice',compact('organ_invoice','invoice_no','organization','page_info'));
        return $pdf->download($filename);

     }
    
    public function organizations_paid_invoices($invoice_no = null) {
        
    }
    
    
    public function add_edit_organization(Request $request, $id=null) {
       Session::put('page','organizations'); Session::put('subpage','organizations');
        if($id==''){
           $page_info = ['title'=>'Create New Organizational Body','icon'=>'fa fa-users','sub-title'=>'Create / Edit  Bank Account'];
           $organization = new Organization(); $message = "Organizational Body Successfully Saved";
           //print "<pre>";   print_r($organization->toarray()); die; 
       }
       else { ##
           $page_info = ['title'=>'Edit Organizational Body ','icon'=>'fa fa-group','sub-title'=>' '];
           $organization = Organization::find($id); $message = "Organizational Body Successfully Updated";
       }
       ######## form submission
       if($request->isMethod('post')){          
          ##print "<pre>";   print_r($request->all()); die;             
           $rules = [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('organizations')->ignore($organization->id), // ignore current record on update
                ],
                'address' => [
                    'required',
                    'string',
                    'max:255',                   
                ],
                'number' => ['required','digits:11'],
            ];
            $customMessage = [
               'name.required'=>"Please provide the Organization Name",
               'name.unique'=>"This Name has already been taken",
               'address.required'=>"Please Provide the Organization Address "
                ];
            ##$validator = Validator::make($data, $rules,$customMessage);
            $this->validate($request, $rules, $customMessage);           
            $organization->name = $request->name;
            $organization->address = $request->address;
            $organization->phone = $request->number;            
            $organization->email = $request->email;
            $organization->enrole_no = $request->enrole_no;
            $organization->status = 1;            
            $organization->save();

            return redirect('admin/organizations')->with('success_message',$message); # redirect('admin/bill-samples')
            //  return redirect('admin/bill-category')->with('success_message',$message);
            // return response()->json(['type'=>'success','success_message'=>$message,'url'=>'subjects']);
       }
       $btns = [
           ['name'=>"<-- View Organizations ",'action'=>"admin/organizations", 'class'=>'btn btn-dark'],
           ['name'=>"View Our Accounts",'action'=>"admin/accounts", 'class'=>'btn btn-primary']];       
      return view('admin.insurance.add_edit_organization',compact('page_info','organization','btns'));
    }
     
}

## Birth of Jesus 
## gal 1:6-9
## luk 1:5-10
## luk 2:8