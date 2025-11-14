<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BillingCategory;
use App\Models\BillType;
use App\Models\SpecimenResultTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;
use function abort;
use function redirect;
use function response;
use function view;

class BillingController extends Controller
{
    public function bill_category() {
      Session::put('page','billings'); Session::put('subpage','category');
      $page_info = ['title'=>'Billing Categories ','icon'=>'pe-7s-notebook','sub-title'=>'Below are categories of billings available'];
       $btns = [
           ['name'=>"Create New Category",'action'=>"admin/add-edit-bill-category", 'class'=>'btn btn-success'],
           ];

      $billcategs = BillingCategory::get()->toArray();
      return view('admin.billings.billing_categ',compact('page_info','billcategs','btns'));
    }

    public function addEditBillCategory(Request $request, $bid=null) {
       Session::put('page','billings'); Session::put('subpage','add_category');
        if($bid==''){
           $page_info = ['title'=>'Create New Billing Category ','icon'=>'pe-7s-notebook','sub-title'=>'create / edit billing category'];
           $billcateg = new BillingCategory; $message = "Billing Category Successfully Saved";
       }
       else { ##
           $page_info = ['title'=>'Edit Billing Category ','icon'=>'pe-7s-notebook','sub-title'=>'Below are the list of subjects available'];
           $billcateg = BillingCategory::find($bid); $message = "Billing Category Successfully Updated";
       }

       if($request->isMethod('post')){
           $data = $request->all();
            $rules = [
                'name'=>"required|string|max:255",
                Rule::unique('billing_categories')->ignore($billcateg->id),
               ];
            $customMessage = [
               'name.required'=>"Please provide the bill category name",
               'name.unique'=>"This Category already exists"
                ];
             ##$validator = Validator::make($data, $rules,$customMessage);

            $this->validate($request, $rules, $customMessage);

            $billcateg->name = $data['name'];
            $billcateg->description = $data['description'];
            $billcateg->save();

            return redirect('admin/add-edit-bill-category')->with('success_message',$message);
          //  return redirect('admin/bill-category')->with('success_message',$message);
            // return response()->json(['type'=>'success','success_message'=>$message,'url'=>'subjects']);
       }
       $btns = [
           ['name'=>"<-- View Categories ",'action'=>"admin/bill-category", 'class'=>'btn btn-dark'],
           ['name'=>"View Bill Templates ",'action'=>"admin/manage-subject-for-levels", 'class'=>'btn btn-primary']];

           return view('admin.billings.add_edit_billing',compact('page_info','billcateg','btns'));
    }

    public function updateCategStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $respStatus = "1";
            if($data['status']=="active") :
                $respStatus = "0";
            endif;
            BillingCategory::where('id',$data['categ_id'])->update(['status'=>$respStatus]);
            return response()->json(['status'=>$respStatus]);
        }
    }
    
    # updateBillTypeStatus
        public function updateBillTypeStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $respStatus = "1";
            if($data['status']=="active") :  $respStatus = "0";  endif;
            BillType::where('id',$data['bill_type_id'])->update(['status'=>$respStatus]);
            return response()->json(['status'=>$respStatus]);
        }
    }
    
    

    public function add_edit_bill_sample(Request $request, $bid=null) {
       Session::put('page','billings'); Session::put('subpage','add_bill_sample');
        if($bid==''){
           $page_info = ['title'=>'Create New General Bill  ','icon'=>'pe-7s-notebook','sub-title'=>'Create / Edit General Bill'];
           $billtype = new BillType(); $message = "New General Bill Successfully Saved";
       }
       else { ##
           $page_info = ['title'=>'Edit General Bill ','icon'=>'pe-7s-notebook','sub-title'=>' '];
           $billtype = BillType::find($bid); $message = "General Bill Successfully Updated";
       }
       ######## form submission
       if($request->isMethod('post')){
           $data = $request->all();
            # print "<pre>";   print_r($data); die;             
           $rules = [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('bill_types')->ignore($billtype->id), // ignore current record on update
                ],
                'amount' => 'required',
            ];
            $customMessage = [
               'name.required'=>"Please provide the bill name",
               ## 'name.unique'=>"This Name has already been taken",
               'amount.required'=>"Please provide the amount "
                ];
            ##$validator = Validator::make($data, $rules,$customMessage);
            $this->validate($request, $rules, $customMessage);
                        
            $billtype->name = $data['name'];
            $billtype->amount = str_replace(',','',$data['amount']);
            $billtype->status = 1;
            
            $billtype->save();

            return redirect()->back()->with('success_message',$message); # redirect('admin/bill-samples')
            //  return redirect('admin/bill-category')->with('success_message',$message);
            // return response()->json(['type'=>'success','success_message'=>$message,'url'=>'subjects']);
       }
       $btns = [
           ['name'=>"<-- View Categories ",'action'=>"admin/bill-category", 'class'=>'btn btn-dark'],
           ['name'=>"View Bill Types ",'action'=>"admin/bill-samples", 'class'=>'btn btn-primary']];
       $billcategs = BillingCategory::where('status',1)->orderBy('name')->get()->toArray();
      return view('admin.billings.add_edit_billing_sample',compact('page_info','billtype','btns','billcategs'));
    }

    public function bill_samples (Request $request) {
          Session::put('page','billings'); Session::put('subpage','bills');
            $page_info = ['title'=>'All General Bills ','icon'=>'pe-7s-notebook','sub-title'=>'Below are list of General bills available'];
             $btns = [
                 ['name'=>"Create New Bill",'action'=>"admin/add-edit-bill", 'class'=>'btn btn-success'],
                 ];
            
                 $bill_types = BillType::all()->toArray();
            
            $bill_categs = BillingCategory::all()->pluck('name','id')->toArray();
           ##  dd($bill_categs);
          return view('admin.billings.bill_samples',compact('page_info','bill_types','btns','bill_categs'));
    }

    public function manageBillTemplate(Request $request,$id,$temp_id=null) {
        Session::put('page','billings'); Session::put('subpage','bill-template-setup');
        $bill_sample = BillType::with(['category','template'])->find($id);
        $subpg = $bill_sample->category->name;
        $page_info = ['title'=>$bill_sample->name." - Result  Template ",'icon'=>'pe-7s-notebook','sub-title'=>$subpg." / ".$bill_sample->name];
        $btns = [
             ['name'=>"View Bill Category",'action'=>"admin/bill-category", 'class'=>'btn btn-dark'],
             ['name'=>"View Bill Types",'action'=>"admin/add-edit-bill-sample", 'class'=>'btn btn-primary'],
             ];
        ## dd($editTemp);
        return view('admin.billings.bill_sample_template',compact('page_info','bill_sample','btns','temp_id'));
    }
    ## end function

    public function startBillTemplateSetup(Request $request) {
        if($request->ajax()){
         $data = $request->all();
         $bill_type_id = $data['bill_type']; $temp_id = $data['temp_id'];
         $bill_sample = BillType::with(['category','template'])->find($bill_type_id)->toArray();
         # print "<pre>"; # print_r($temp_id); die;
         ## for editing existing template
         if($temp_id !=""){$editTemp = SpecimenResultTemplate::find($temp_id); }
            else { $editTemp = new SpecimenResultTemplate; }
          # print_r($editTemp); die; 
         if($data['result_temp'] == "param_form"){
             return response()->json([
                'view'=>(String)View::make('admin.billings.param_template_form_ajax')->with(compact('bill_type_id','bill_sample','editTemp'))
            ]);
         }
         else { ## text form
              return response()->json([
                'view'=>(String)View::make('admin.billings.text_template_form_ajax')->with(compact('bill_type_id','bill_sample','editTemp'))
            ]);
         }
       } ## end ajax

    }# end function

    function submit_param_bill_template_form(Request $request){
        if($request->ajax()){
         $data = $request->all();## print "<pre>"; print_r($data); die;
         ## validate the form
         $rules = ['name' => 'required','towhom'=>'required'];
             $customMessage = ['name.required'=>'Provide The Result Name',
                'towhom.required'=>'Select Whom it Belongs'
            ];
           if($request->has('has_unit')){
              $rules = array_merge($rules ,['unit' => 'required']) ; $customMessage = array_merge($customMessage, ['unit.required'=>'Provide The Unit Value']);
           }
           if($request->has('has_ref')){
              $rules = array_merge($rules ,['ref_value'=>'required']) ; $customMessage = array_merge($customMessage, ['ref_value.required'=>'Provide The Reference Value']);
           }
           $validator = Validator::make($data, $rules,$customMessage);
           ## check
           if($validator->fails()){ // or use $validator->passes()
                return response()->json(['type'=>'error','errors'=>$validator->messages()]);
             }
            else {
                ## update bill type
                BillType::where('id',$data['bill_type_id'])->update(['template_type'=>'param_form']);
                ## create / update templates
                if($data['temp_id']==""){
                     $templates = new SpecimenResultTemplate;
                     $message = "New Bill Result Template Saved Successfully";
                }
                else {
                     $templates = SpecimenResultTemplate::find($data['temp_id']);
                     $message = " Result Template Updated Successfully";
                }

                 $templates->bill_type_id = $data['bill_type_id'];
                 $templates->name = $data['name'];
                 $templates->age_range = $data['towhom'];
                 if($request->has('has_unit')){
                   $templates->unit = $data['unit'];
                   $templates->has_unit = 1;
                 }
                 if($request->has('has_ref')){
                   $templates->ref_val = $data['ref_value'];
                   $templates->has_ref_val = 1;
                 }
                 $templates->save();
                return response()->json(['type'=>'success','message'=>$message,'url'=>url('admin/bill-sample-template/'.$data['bill_type_id'])]);
            }
        } // end ajax request
    } // end function

    function submit_text_bill_template_form(Request $request){
        if($request->ajax()){
         $data = $request->all(); ## print "<pre>"; print_r($data); die;
         ## validate the form
         $rules = ['result_text'=>'required'];
         $customMessage = ['result_text.required'=>'Provide The Result Template'];

        $validator = Validator::make($data, $rules,$customMessage);
        ## check
        if($validator->fails()){ // or use $validator->passes()
             return response()->json(['type'=>'error','errors'=>$validator->messages()]);
          }
            else {
                ## update bill type
                BillType::where('id',$data['bill_type_id'])->update(['template_type'=>'text_form']);
                ## create / update templates
                if($data['temp_id']==""){
                     $templates = new SpecimenResultTemplate;
                     $message = "New Bill Result Template Saved Successfully";
                }
                else {
                     $templates = SpecimenResultTemplate::find($data['temp_id']);
                     $message = " Result Template Updated Successfully";
                }

                 $templates->bill_type_id = $data['bill_type_id'];
                 $templates->raw_text_val = $data['result_text'];
                 $templates->status = 1; 
                 $templates->save();

                return response()->json(['type'=>'success','message'=>$message,'url'=>url('admin/bill-sample-template/'.$data['bill_type_id'])]);
            }
        } // end ajax request
    } // end function
    
     public function update_bill_template_child_status(Request $request) {
          if($request->ajax()){
            $data = $request->all(); $respStatus = "1";            
            if($data['status']=="active") :  $respStatus = "0";  endif;            
             SpecimenResultTemplate::where('id',$data['data_id'])->update(['status'=>$respStatus]);            
            return response()->json(['status'=>$respStatus]);
        }
     }
}
