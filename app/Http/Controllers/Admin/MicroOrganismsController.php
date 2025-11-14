<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AllTreatment;
use App\Models\Microorganism;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use function redirect;
use function response;
use function view;

class MicroOrganismsController extends Controller
{    
    public function index() {    
        Session::put('page','micro-organisms'); Session::put('subpage','micro-organisms');
        $page_info = ['title'=>'Micro Organisms and Their Treatments','icon'=>'pe-7s-ball','sub-title'=>''];
        $micros = Microorganism::with('treatment')->get()->toArray();
        # dd($micros);      
        return view('admin.micros.organisms',compact('micros','page_info'));
    }
    
    public function status_update(Request $request) {
         if($request->ajax()){
            $data = $request->all(); $respStatus = "1";            
            if($data['status']=="active") :  $respStatus = "0";  endif;            
            Microorganism::where('id',$data['micro_id'])->update(['status'=>$respStatus]);            
            return response()->json(['status'=>$respStatus]);
        }
    }
    public function microorg_treatment_status_update(Request $request) {
          if($request->ajax()){
            $data = $request->all(); $respStatus = "1";            
            if($data['status']=="active") :  $respStatus = "0";  endif;            
            AllTreatment::where('id',$data['data_id'])->update(['status'=>$respStatus]);            
            return response()->json(['status'=>$respStatus]);
        }
    }
    
    public function create_update_micros(Request $request, $mid=null) {
        Session::put('page','micro-organisms'); Session::put('subpage','create-micros');
        $page_info = ['title'=>'Micro Organisms and Their Treatments','icon'=>'pe-7s-ball','sub-title'=>''];
        $treatments = AllTreatment::all();
           if($mid==""):
            $page_info = ['title'=>'Create New Micro Organisms','icon'=>'pe-7s-ball','sub-title'=>'Create new micro-organism and select recommended treatment for it'];
            $micro = new Microorganism; $message = "New Micro Organisms Successfully Created";           
            
//            dd(microorganism_treatment_name()); 
//            die; 
             if($request->isMethod('post')):
                $data = $request->all();  # print "<pre>"; 
//                print_r($data);
//                die; 
                $micro->name = $data['micro_name'];        
                $micro->micro_type = $data['organism_type'];                           
                $micro->save();
                    
              if(!empty($data['recommends'])):
                $treatment = new Treatment; 
                $treatment->microorganism_id = $micro->id;
                $treatment->treatment = implode(",", $data['recommends']); 
                $treatment->save(); 
                # ::where(['microorganism_id'=>$micro->id])->update(['treatment'=>implode(",", $data['recommends'])]);
                return redirect('admin/micro-organisms')->with('success_message',$message); 
               endif;
            endif;           
            
            return view('admin.micros.add_micro')->with(compact('page_info','micro','treatments')); 
            else: ##
                $page_info = ['title'=>'Edit Micro Organism ','icon'=>'pe-7s-ball','sub-title'=>'Update the name or select new recommended treatment for this micro-organism'];
                $micro = Microorganism::with('treatment')->find($mid); $message = "Micro Organism Successfully Updated";
                
                if($request->isMethod('post')):
                    $data = $request->all();  # print "<pre>"; 
                    # print_r($data); 
                    $micro->name = $data['micro_name'];        
                    $micro->micro_type = $data['organism_type'];                           
                    $micro->save();
                    # save treatment 
                    if(!empty($data['recommends'])):
                      Treatment::where(['microorganism_id'=>$micro->id])->update(['treatment'=>implode(",", $data['recommends'])]);                       
                    endif;
                    # $micro->treatment = implode(",", $data['recommends']);
                    return redirect('admin/micro-organisms')->with('success_message',$message); 
                endif;
               return view('admin.micros.edit_micro')->with(compact('page_info','micro','treatments')); 
            endif;  
    }
    
    
    public function create_update_micros_treatment(Request $request, $mid=null) {
        Session::put('page','micro-organisms'); Session::put('subpage','create-micros-treatment');
        $page_info = ['title'=>'Add New Micro Organisms Treatment','icon'=>'pe-7s-ball','sub-title'=>''];        
           if($mid==""):
            $page_info = ['title'=>'Add New Micro Organisms Treatment','icon'=>'pe-7s-ball','sub-title'=>'Create new micro-organism and select recommended treatment for it'];
            $treatment = new AllTreatment; $message = "New Micro Organism Treatment Successfully Created";           
    
            if($request->isMethod('post')):
                $data = $request->all();  # print "<pre>"; 
//                print_r($data);
//                die; 
                $treatment->name = $data['treatment_name'];                       
                $treatment->save();
                
                return redirect('admin/micro-organism-treatments')->with('success_message',$message); 
 
            endif;           
            
            return view('admin.micros.add_treatment')->with(compact('page_info','treatment')); 
            else: ##
                $page_info = ['title'=>'Edit Micro Organisms Treatment ','icon'=>'pe-7s-ball','sub-title'=>'Update the name or select new recommended treatment for this micro-organism'];
                $treatment = AllTreatment::find($mid); $message = "Micro Organism Treatment Successfully Updated";
                
                if($request->isMethod('post')):
                    $data = $request->all();  # print "<pre>"; 
                    # print_r($data); 
                    $treatment->name = $data['treatment_name'];      
                    $treatment->save();
                    # save treatment 
                    
                    return redirect('admin/micro-organism-treatments')->with('success_message',$message); 
                endif;
               return view('admin.micros.edit_treatment')->with(compact('page_info','treatment')); 
            endif;  
    }
    
    public function micro_treatments(){
        Session::put('page','micro-organisms'); Session::put('subpage','micro-organism-treatments');
        $page_info = ['title'=>'List of Treatments for the Micro-Organisms','icon'=>'pe-7s-ball','sub-title'=>''];
        
        $treatments = AllTreatment::all(); 
        # dd($treatments); 
        return view('admin.micros.treatments')->with(compact('page_info','treatments'));
    }
    
    
}
