<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Frame;
use App\Models\Lense;
use App\Models\LenseCategory;
use App\Models\LenseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;
use function asset;
use function redirect;
use function response;
use function view;

class LenseController extends Controller
{
   public function lense_category() {
      Session::put('page','lenses'); Session::put('subpage','lenses-categ');
      $page_info = ['title'=>'Lense Categories ','icon'=>'fa fa-camera','sub-title'=>'Below are categories of Lenses available'];
       $btns = [
           ['name'=>"View Lenses ",'action'=>"admin/lenses", 'class'=>'btn btn-primary'],
           ['name'=>"View Types",'action'=>"admin/lense-types", 'class'=>'btn btn-info'],
           ['name'=>"Create New Category",'action'=>"admin/add-edit-lense-category", 'class'=>'btn btn-success'],
           ];
      $categs = LenseCategory::get()->toArray();
      return view('admin.lenses.lense_categ',compact('page_info','categs','btns'));
    }
    
      public function lense_types() {
      Session::put('page','lenses'); Session::put('subpage','lense-types');
      $page_info = ['title'=>'Lense Types ','icon'=>'fa fa-camera','sub-title'=>'Below are Types of Lenses available'];
       $btns = [
           ['name'=>"View Lenses ",'action'=>"admin/lenses", 'class'=>'btn btn-primary'],
           ['name'=>"View Category",'action'=>"admin/lense-category", 'class'=>'btn btn-info'],
           ['name'=>"Create New Type",'action'=>"admin/add-edit-lense-type", 'class'=>'btn btn-success'],
           ];
      $types = LenseType::get()->toArray();
      return view('admin.lenses.lense_types',compact('page_info','types','btns'));
    }
    
     public function lenses (Request $request, $category = null) {
          Session::put('page','lenses'); Session::put('subpage','lenses');
            $page_info = ['title'=>'Our Lenses ','icon'=>'fa fa-camera','sub-title'=>'Below are samples of Lenses available'];
             $btns = [
                 ['name'=>"View Categories",'action'=>"admin/lense-category", 'class'=>'btn btn-primary'],
                 ['name'=>"View Types",'action'=>"admin/lense-types", 'class'=>'btn btn-info'],
                 ['name'=>"Create New Lense",'action'=>"admin/add-edit-lenses", 'class'=>'btn btn-success'],
                 ];
            if($category!=""){
                 $lenses = Lense::where(['categ_id'=>$category])->get()->toArray();
            }
            else {
                 $lenses = Lense::all()->toArray();
            }
            $categs = LenseCategory::all()->pluck('name','id')->toArray();
            $types = LenseType::all()->pluck('name','id')->toArray();
           ##  dd($bill_categs);
          return view('admin.lenses.lense_samples',compact('page_info','lenses','btns','categs','types'));
    }
    
     public function frames() {
          Session::put('page','frames'); Session::put('subpage','frames');
            $page_info = ['title'=>'Our Frames ','icon'=>'fa fa-glasses','sub-title'=>'Below are samples of Frames available'];
             $btns = [
                 ['name'=>"Create New Frame",'action'=>"admin/add-edit-frames", 'class'=>'btn btn-success'],
                 ];
          
                 $frames = Frame::all();
           
          return view('admin.frames.frames_samples',compact('page_info','frames','btns'));
    }

    public function addEditLenseCategory(Request $request, $did=null) {
       Session::put('page','lenses'); Session::put('subpage','lenses-categ');
        if($did==''){
           $page_info = ['title'=>'Create New Lense Category ','icon'=>'pe-7s-notebook','sub-title'=>'Create / Modify Lense category'];
           $categ = new LenseCategory; $message = "Lense Category Successfully Created";
       }
       else { ##
           $page_info = ['title'=>'Edit Lense Category ','icon'=>'pe-7s-notebook','sub-title'=>''];
           $categ = LenseCategory::find($did); $message = "Lense Category Successfully Updated";
       }

       if($request->isMethod('post')){
           $data = $request->all();
            $rules = [
                'name'=>"required|string|max:255",
                Rule::unique('lense_categories')->ignore($categ->id),
               ];
            $customMessage = [
               'name.required'=>"Please provide the Lense Category Name",
               'name.unique'=>"This Category already exists"
                ];
             ##$validator = Validator::make($data, $rules,$customMessage);
            $this->validate($request, $rules, $customMessage);
            $categ->name = $data['name'];            
            $categ->save();

            return redirect('admin/add-edit-lense-category')->with('success_message',$message);
          //  return redirect('admin/bill-category')->with('success_message',$message);
            // return response()->json(['type'=>'success','success_message'=>$message,'url'=>'subjects']);
       }
            $btns = [           
                ['name'=>"View Lenses ",'action'=>"admin/lenses", 'class'=>'btn btn-primary'],
                ['name'=>"View Types",'action'=>"admin/lense-types", 'class'=>'btn btn-info'],
                ['name'=>"View Categories ",'action'=>"admin/lense-category", 'class'=>'btn btn-success']
               ];

           return view('admin.lenses.add_edit_categ',compact('page_info','categ','btns'));
    }
    
    public function addEditLenseType(Request $request, $did=null) {
       Session::put('page','lenses'); Session::put('subpage','lense-types');
        if($did==''){
           $page_info = ['title'=>'Create New Lense Type ','icon'=>'fa fa-camera','sub-title'=>'Create / Modify Lense Type'];
           $type = new LenseType(); $message = "Lense Type Successfully Created";
       }
       else { ##
           $page_info = ['title'=>'Edit Lense Type ','icon'=>'fa fa-camera','sub-title'=>''];
           $type = LenseType::find($did); $message = "Lense Type Successfully Updated";
       }

       if($request->isMethod('post')){
           $data = $request->all();
            $rules = [
                'name'=>"required|string|max:255",
                Rule::unique('lense_types')->ignore($type->id),
               ];
            $customMessage = [
               'name.required'=>"Please provide the Lense Type Name",
               'name.unique'=>"This Type already exists"
                ];
             ##$validator = Validator::make($data, $rules,$customMessage);
            $this->validate($request, $rules, $customMessage);
            $type->name = $data['name'];            
            $type->save();

            return redirect('admin/add-edit-lense-type')->with('success_message',$message);
          //  return redirect('admin/bill-category')->with('success_message',$message);
            // return response()->json(['type'=>'success','success_message'=>$message,'url'=>'subjects']);
       }
            $btns = [           
                ['name'=>"View Lenses ",'action'=>"admin/lenses", 'class'=>'btn btn-primary'],
                ['name'=>"View Types",'action'=>"admin/lense-types", 'class'=>'btn btn-info'],
                ['name'=>"View Categories ",'action'=>"admin/lense-category", 'class'=>'btn btn-success']
               ];

           return view('admin.lenses.add_edit_type',compact('page_info','type','btns'));
    }
    
    public function addEditLenses(Request $request, $id=null) {
        Session::put('page','lenses'); Session::put('subpage','add-lenses');
        if($id==''){
           $page_info = ['title'=>'Create A New Lense','icon'=>'fa fa-camera','sub-title'=>'Create / Edit Lenses'];
           $lense = new Lense(); $message = "New Lense Successfully Saved";
       }
       else { ##
           $page_info = ['title'=>'Updating Lense Info','icon'=>'fa fa-database','sub-title'=>'Create / Edit Lenses'];
           $lense = Lense::find($id); $message = "Lense Successfully Updated";
       }
       ######## form submission
       if($request->isMethod('post')){
           $data = $request->all();
            # print "<pre>";   print_r($data);             
           $rules = [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('lenses')
                        ->where(function ($query) use ($request) {
                            return $query->where('type_id', $request->type);
                        })
                        ->ignore($lense->id), // allow updating same record
                ],
                'categ' => 'required',
            ];
            $customMessage = [
               'name.required'=>"Please provide the lense name",
               ## 'name.unique'=>"This Name has already been taken",
               'categ.required'=>"Please select the category "
                ];
            ##$validator = Validator::make($data, $rules,$customMessage);
            $this->validate($request, $rules, $customMessage);
                        
            $lense->name = $data['name'];
            $lense->categ_id = $data['categ'];            
            $lense->type_id = $data['type'];            
            $lense->purchase_price = str_replace(",", "",$data['price1']);
            $lense->sales_price = str_replace(",", "",$data['price2']);                                    
                             
            $cum_qty = $lense->cum_qty + $data['new_qty'];              
            $qty_rem = $data['init_qty'] + $data['new_qty'];
            $lense->cum_qty = $cum_qty;
            $lense->qty_rem = $qty_rem;
            if(!empty($data['mfc_date']) && !empty($data['exp_date'])) :
                $lense->has_expiry = true;
                $lense->mfc_date = $data['mfc_date'];
                $lense->exp_date = $data['exp_date'];
            endif;
           
            $lense->save();

            return redirect()->back()->with('success_message',$message); # redirect('admin/bill-samples')
            //  return redirect('admin/bill-category')->with('success_message',$message);
            // return response()->json(['type'=>'success','success_message'=>$message,'url'=>'subjects']);
       }
       $btns = [
           ['name'=>"View Types",'action'=>"admin/lense-types", 'class'=>'btn btn-info'],
           ['name'=>"View Categories ",'action'=>"admin/lense-category", 'class'=>'btn btn-success'],
           ['name'=>"View Lenses",'action'=>"admin/lenses", 'class'=>'btn btn-primary']
           ];
       $categs = LenseCategory::where('status',1)->orderBy('name')->get()->toArray();
       $types = LenseType::where('status',1)->orderBy('name')->get()->toArray();
      return view('admin.lenses.add_edit_lense_sample',compact('page_info','lense','btns','categs','types'));            
    }
    
    
    public function addEditFrames(Request $request, $id=null) {
        Session::put('page','frames'); Session::put('subpage','add-frames');
        if($id==''){
           $page_info = ['title'=>'Create A New Frame','icon'=>'fa fa-glasses','sub-title'=>'Create / Edit Frame'];
           $frame = new Frame(); $message = "New Frame Successfully Saved";
       }
       else { ##
           $page_info = ['title'=>'Updating Frame Info','icon'=>'fa fa-glasses','sub-title'=>'Create / Edit Frame'];
           $frame = Frame::findOrFail($id); $message = "Frame Successfully Updated";
       }
       ######## form submission
       if($request->isMethod('post')){
           $data = $request->all();                  
            # print "<pre>";   print_r($data);             
           $rules = [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('frames')
                        ->where(function ($query) use ($request) {
                            return $query->where('name', $request->name);
                        })
                        ->ignore($frame->id), // allow updating same record
                ],
            ];
            $customMessage = [
               'name.required'=>"Please provide the frame name",
               'name.unique'=>"This Name has already been taken",               
                ];
            ##$validator = Validator::make($data, $rules,$customMessage);
            $this->validate($request, $rules, $customMessage);                        
            $frame->name = $data['name'];
            $frame->purchase_price = str_replace(",", "",$data['price1']);
            $frame->sales_price = str_replace(",", "",$data['price2']);                                    
                             
            $cum_qty = $frame->cum_qty + $data['new_qty'];              
            $qty_rem = $data['init_qty'] + $data['new_qty'];
            $frame->cum_qty = $cum_qty;
            $frame->qty_rem = $qty_rem;            
           
            $frame->save();

            return redirect()->back()->with('success_message',$message); # redirect('admin/bill-samples')
            //  return redirect('admin/bill-category')->with('success_message',$message);
            // return response()->json(['type'=>'success','success_message'=>$message,'url'=>'subjects']);
       }
       $btns = [
           ['name'=>"View Frames",'action'=>"admin/frames", 'class'=>'btn btn-primary']
           ];
      
      return view('admin.frames.add_edit_frame_sample',compact('page_info','frame','btns'));            
    }
    
     public function upload_image(Request $request) {
       if($request->ajax()):
              $rules = ['picture'=>'mimes:jpg,jpeg,png'];
                $customMessage = ['picture.mimes'=>'Only Image File of type jpg, jpeg and png is allowed'];                
                $this->validate($request, $rules, $customMessage); //  
                
               $image_tmp = $request->file('picture'); 
                if($image_tmp->isValid()):
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand().uniqid().'.'.$extension; 
                    $image_path = "images/lenses/temp/".$imageName;    
                   // $watermark = "images/bg.png";
                   Session::put('current_temp_psp',$imageName);
                   Session::push('temp_psp', $imageName); 
                    // create new manager instance with desired driver
                    $manager = ImageManager::gd();               
                        $image = $manager->read($image_tmp);   
                        $image->resize(600,300);
                        // $image->place($watermark,'bottom-left',20,0,100);                    
                    $image->save($image_path);                    

                return response()->json([
                   'type'=>'success',
                   'message'=>'Upload Successful',
                   'path'=>asset($image_path)
               ]);
                endif; ## end if valid                  
       endif; ## end ajax            
    }
    
      public function updateLenseStatus(Request $request){
          if($request->ajax()){
            $data = $request->all(); $respStatus = "1";            
            if($data['status']=="active") :  $respStatus = "0";  endif;            
             Lense::where('id',$data['data_id'])->update(['status'=>$respStatus]);            
            return response()->json(['status'=>$respStatus]);
        }
    }
    
      public function updateLenseCategStatus(Request $request){
          if($request->ajax()){
            $data = $request->all(); $respStatus = "1";            
            if($data['status']=="active") :  $respStatus = "0";  endif;            
               LenseCategory::where('id',$data['data_id'])->update(['status'=>$respStatus]);            
            return response()->json(['status'=>$respStatus]);
        }
    }
     
    public function updateLenseTypeStatus(Request $request){
          if($request->ajax()){
            $data = $request->all(); $respStatus = "1";            
            if($data['status']=="active") :  $respStatus = "0";  endif;            
                LenseType::where('id',$data['data_id'])->update(['status'=>$respStatus]);            
            return response()->json(['status'=>$respStatus]);
        }
    }
    public function updateFrameStatus(Request $request){
          if($request->ajax()){
            $data = $request->all(); $respStatus = "1";            
            if($data['status']=="active") :  $respStatus = "0";  endif;            
                Frame::where('id',$data['data_id'])->update(['status'=>$respStatus]);            
            return response()->json(['status'=>$respStatus]);
        }
    }
}
