<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BillingCategory;
use App\Models\Drug;
use App\Models\DrugCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use function redirect;
use function response;
use function view;


class DrugController extends Controller
{
   public function drug_category() {
      Session::put('page','drugs'); Session::put('subpage','drugs-categ');
      $page_info = ['title'=>'Drug Categories ','icon'=>'fa fa-database','sub-title'=>'Below are categories of Drugs available'];
       $btns = [
           ['name'=>"View Drugs ",'action'=>"admin/drugs", 'class'=>'btn btn-primary'],
           ['name'=>"Create New Category",'action'=>"admin/add-edit-drug-category", 'class'=>'btn btn-success'],
           ];
      $categs = DrugCategory::get()->toArray();
      return view('admin.drugs.drug_categ',compact('page_info','categs','btns'));
    }
    
     public function drugs (Request $request, $category = null) {
          Session::put('page','drugs'); Session::put('subpage','bill-samples');
            $page_info = ['title'=>'Our Drugs ','icon'=>'fa fa-database','sub-title'=>'Below are samples of drugs available'];
             $btns = [
                 ['name'=>"View Categories",'action'=>"admin/drugs-category", 'class'=>'btn btn-primary'],
                 ['name'=>"Create New Drug",'action'=>"admin/add-edit-drugs", 'class'=>'btn btn-success'],
                 ];
            if($category!=""){
                 $drugs = Drug::where(['categ_id'=>$category])->get()->toArray();
            }
            else {
                 $drugs = Drug::all()->toArray();
            }
            $drugs_categs = DrugCategory::where('status',1)->pluck('name','id')->toArray();
           ##  dd($bill_categs);
          return view('admin.drugs.drug_samples',compact('page_info','drugs','btns','drugs_categs'));
    }

    public function addEditDrugCategory(Request $request, $did=null) {
       Session::put('page','drugs'); Session::put('subpage','drugs-categ');
        if($did==''){
           $page_info = ['title'=>'Create New Drug Category ','icon'=>'pe-7s-notebook','sub-title'=>'Create / Modify Drug category'];
           $drugcateg = new DrugCategory; $message = "Drug Category Successfully Created";
       }
       else { ##
           $page_info = ['title'=>'Edit Drug Category ','icon'=>'pe-7s-notebook','sub-title'=>''];
           $drugcateg = DrugCategory::find($did); $message = "Drug Category Successfully Updated";
       }

       if($request->isMethod('post')){
           $data = $request->all();
            $rules = [
                'name'=>"required|string|max:255",
                Rule::unique('drug_categories')->ignore($drugcateg->id),
               ];
            $customMessage = [
               'name.required'=>"Please provide the Drug Category Name",
               'name.unique'=>"This Category already exists"
                ];
             ##$validator = Validator::make($data, $rules,$customMessage);
            $this->validate($request, $rules, $customMessage);
            $drugcateg->name = $data['name'];            
            $drugcateg->save();

            return redirect('admin/add-edit-drug-category')->with('success_message',$message);
          //  return redirect('admin/bill-category')->with('success_message',$message);
            // return response()->json(['type'=>'success','success_message'=>$message,'url'=>'subjects']);
       }
            $btns = [                        
                ['name'=>"View Categories ",'action'=>"admin/drugs-category", 'class'=>'btn btn-primary'],
                ['name'=>"View Drugs ",'action'=>"admin/drugs", 'class'=>'btn btn-success']
               ];

           return view('admin.drugs.add_edit_categ',compact('page_info','drugcateg','btns'));
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
    
    # updateDrugStatus
        public function updateDrugStatus(Request $request){
          if($request->ajax()){
            $data = $request->all(); $respStatus = "1";            
            if($data['status']=="active") :  $respStatus = "0";  endif;            
             Drug::where('id',$data['data_id'])->update(['status'=>$respStatus]);            
            return response()->json(['status'=>$respStatus]);
        }
    }
    
    public function updateDrugCategStatus(Request $request){
          if($request->ajax()){
            $data = $request->all(); $respStatus = "1";            
            if($data['status']=="active") :  $respStatus = "0";  endif;            
                DrugCategory::where('id',$data['data_id'])->update(['status'=>$respStatus]);            
            return response()->json(['status'=>$respStatus]);
        }
    }
    

    public function addEditDrugSample(Request $request, $bid=null) {
       Session::put('page','drugs'); Session::put('subpage','add-drugs');
        if($bid==''){
           $page_info = ['title'=>'Create A New Drug','icon'=>'fa fa-database','sub-title'=>'Create / Edit Drugs'];
           $drug = new Drug(); $message = "New Drug Successfully Saved";
       }
       else { ##
           $page_info = ['title'=>'Updating Drug Info','icon'=>'fa fa-database','sub-title'=>'Create / Edit Drugs'];
           $drug = Drug::find($bid); $message = "Drug Successfully Updated";
       }
       ######## form submission
       if($request->isMethod('post')){
           $data = $request->all();
            # print "<pre>";   print_r($data); 
            /** $rules = [
                'name'=>"required|string|max:255|unique:bill_types", ## |unique:bill_types",
                'categ'=>"required",
               ]; */
           $rules = [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('drugs')->ignore($drug->id), // ignore current record on update
                ],
                'categ' => 'required',
            ];
            $customMessage = [
               'name.required'=>"Please provide the drug name",
               ## 'name.unique'=>"This Name has already been taken",
               'categ.required'=>"Please select the category "
                ];
            ##$validator = Validator::make($data, $rules,$customMessage);
            $this->validate($request, $rules, $customMessage);
                        
            $drug->name = $data['name'];
            $drug->categ_id = $data['categ'];            
            $drug->purchase_price = str_replace(",", "",$data['price1']);
            $drug->sales_price = str_replace(",", "",$data['price2']);                                    
                             
            $cum_qty = $drug->cum_qty + $data['new_qty'];              
            $qty_rem = $data['init_qty'] + $data['new_qty'];
            $drug->cum_qty = $cum_qty;
            $drug->qty_rem = $qty_rem;
            if(!empty($data['mfc_date']) && !empty($data['exp_date'])) :
                $drug->has_expiry = true;
                $drug->mfc_date = $data['mfc_date'];
                $drug->exp_date = $data['exp_date'];
            endif;
           
            $drug->save();

            return redirect()->back()->with('success_message',$message); # redirect('admin/bill-samples')
            //  return redirect('admin/bill-category')->with('success_message',$message);
            // return response()->json(['type'=>'success','success_message'=>$message,'url'=>'subjects']);
       }
       $btns = [
           ['name'=>"<-- View Categories ",'action'=>"admin/drugs-category", 'class'=>'btn btn-dark'],
           ['name'=>"View Drugs",'action'=>"admin/drugs", 'class'=>'btn btn-primary']
           ];
       $drugcategs = DrugCategory::where('status',1)->orderBy('name')->get()->toArray();
      return view('admin.drugs.add_edit_drug_sample',compact('page_info','drug','btns','drugcategs'));
    }
}
