<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
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
       Session::put('page','billings'); Session::put('subpage','new_account');
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
     public function updateOrganizationStatus(Request $request){
          if($request->ajax()){
            $data = $request->all(); $respStatus = "1";            
            if($data['status']=="active") :  $respStatus = "0";  endif;            
               Organization::where('id',$data['data_id'])->update(['status'=>$respStatus]);            
            return response()->json(['status'=>$respStatus]);
        }
    }
    
    public function organizational_bodies() {
        Session::put('page','billings'); Session::put('subpage','organizations');
            $page_info = ['title'=>'Organizational Bodies','icon'=>'fa fa-users','sub-title'=>'Below are list of Our Bank Accounts'];
             $btns = [
                 ['name'=>"Create New Organizational Body",'action'=>"admin/add-edit-organization", 'class'=>'btn btn-success'],
                 ];            
           $organizations = Organization::all();                       
          return view('admin.insurance.organ_bodies',compact('page_info','organizations','btns'));
    }
    public function add_edit_organization(Request $request, $id=null) {
       Session::put('page','billings'); Session::put('subpage','new_organization');
        if($id==''){
           $page_info = ['title'=>'Create New Organizational Body','icon'=>'fa fa-users','sub-title'=>'Create / Edit  Bank Account'];
           $organization = new Organization(); $message = "Organizational Body Successfully Saved";
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
