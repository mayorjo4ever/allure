<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestigationResult;
use App\Models\InvestigationResultField;
use App\Models\InvestigationResultFile;
use App\Models\InvestigationTemplate;
use App\Models\PatientInvestigation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use function collect;
use function GuzzleHttp\json_encode;
use function public_path;
use function redirect;
use function view;

class TestController extends Controller
{
    public function tests (Request $request) { // same as investigations
          Session::put('page','tests'); Session::put('subpage','tests');
            $page_info = ['title'=>'All Tests ','icon'=>'fa fa-wrench','sub-title'=>'Below are samples of tests available'];
             $btns = [
                 ['name'=>"Create New Test",'action'=>"admin/add-edit-test", 'class'=>'btn btn-success'],
                 ];
          
              $tests = InvestigationTemplate::all();
            #  dd($bill_categs);
          return view('admin.tests.tests',compact('page_info','tests','btns'));
    }
    
    // addEditTest 
    public function addEditTest(Request $request, $id=null) {
       Session::put('page','tests'); Session::put('subpage','add-test');
        if($id==''){
           $page_info = ['title'=>'Create New Test Template','icon'=>'pe-7s-notebook','sub-title'=>'Create / Modify Test'];
           $template = new InvestigationTemplate(); $message = "New Test Successfully Created";
       }
       else { ##
           $page_info = ['title'=>'Edit Test ','icon'=>'pe-7s-notebook','sub-title'=>''];
           $template = InvestigationTemplate::with('fields')->findOrfail($id); $message = "Test Successfully Updated";
       }
//       dd($template);
       if($request->isMethod('post')){
           $data = $request->all(); # print "<pre>"; print_r($data); die; 
            $rules = [
                'name'=>"required|string|max:255",
                Rule::unique('investigation_templates')->ignore($template->id),
               ];
            $customMessage = [
               'name.required'=>"Please provide the Test Name",
               'name.unique'=>"This Test Already Exists"
                ];
             ##$validator = Validator::make($data, $rules,$customMessage);
            $this->validate($request, $rules, $customMessage);
            $template->name = $data['name'];            
            $template->requires_image = $data['requires_image'] ?? 0;            
            $template->price = str_replace(",", "",$data['price']);            
           
            // Delete existing fields not included in the request           
            if(empty($request->fields)):
                return redirect()->back()->with('error_message','You Must Add Fields'); 
            endif;
            
             $template->save();
            //
            $existingIds = collect($request->fields)->pluck('id')->filter()->toArray();
            InvestigationResultField::where('template_id', $template->id)
                ->whereNotIn('id', $existingIds)
                ->delete();
            
            // Update or create fields
            foreach ($request->fields as $fieldData) :
                 $options = null;
                    if (!empty($fieldData['options'])) {
                        // Convert comma-separated string into a clean array
                        $optionsArray = array_map('trim', explode(',', $fieldData['options']));
                        $options = json_encode(array_filter($optionsArray)); // remove empty values
                    }
                InvestigationResultField::updateOrCreate(
                    ['id' => $fieldData['id'] ?? null],
                    [
                        'template_id' => $template->id,
                        'label' => $fieldData['label'],
                        'type' => $fieldData['type'],
                        'options' => $options
                    ]
                );
            endforeach;
            //
            return redirect('admin/add-edit-test')->with('success_message',$message);
          //  return redirect('admin/bill-category')->with('success_message',$message);
            // return response()->json(['type'=>'success','success_message'=>$message,'url'=>'subjects']);
       }
            $btns = [                        
                ['name'=>"View Test ",'action'=>"admin/tests", 'class'=>'btn btn-primary'],
                ];

           return view('admin.tests.add_edit_test',compact('page_info','template','btns'));
    }
    
    public function manage_test_templates(Request $request,$id=null) {
         Session::put('page','tests'); Session::put('subpage','manage-tests');
            $page_info = ['title'=>'Manage Test Templates ','icon'=>'fa fa-wrench','sub-title'=>'Below are samples of tests available'];
             $btns = [
                 ['name'=>"Create New Test",'action'=>"admin/add-edit-test", 'class'=>'btn btn-success'],
                 ];
             if($request->isMethod('post')):
                 Session::put('template_id',$request->template_id);
                 return redirect('admin/manage-test-templates/'.$request->template_id);
             endif;             
             $tests = InvestigationTemplate::all();
             $temp_fields = [];
             
            #  dd($bill_categs);
          return view('admin.tests.test_templates',compact('page_info','tests','btns'));
 
    }
    
    public function pending_investigations() {
       Session::put('page','services'); Session::put('subpage','pending_investigations');
            $page_info = ['title'=>'Pending Investigations From Doctor ','icon'=>'fa fa-hourglass','sub-title'=>'Below are Test To be Investigated'];
             $btns = [
                 ['name'=>"Create New Test",'action'=>"admin/add-edit-test", 'class'=>'btn btn-success'],
                 ];
                 $pendingTests = PatientInvestigation::with(['patient', 'template'])
                    ->where('status', 'pending')
                    ->orderBy('appointment_id')
                    ->get()
                    ->groupBy('patient_id') // group by patient    
                    ->map(function ($testsByPatient) {
                        // Group under each appointment
                        return $testsByPatient->groupBy('appointment_id');
                        });
                    #    print "<pre>";
                   # print_r($pendingTests->toArray());
             
            #  dd($bill_categs);
          return view('admin.tests.pending_investigations',compact('page_info','pendingTests','btns'));
 
    }
    
    public function result_computation(Request $request, $param){        
        $info = base64_decode($param);  # test_id | patient_id | apppontment_id 
        $arr_info = explode("|",$info);
         Session::put('page','tests'); Session::put('subpage','manage-tests');
             $btns = [
                 ['name'=>"Create New Test",'action'=>"admin/add-edit-test", 'class'=>'btn btn-success'],
                 ];            
          $investigation = PatientInvestigation::with('template.fields', 'patient','results.files')->findOrFail($arr_info[0]);           
            // Map results by field_id for easy access in Blade
            $resultsByField = $investigation->results->keyBy('field_id');
           # dd($investigation); die; 
          $page_info = ['title'=>'Compute '. $investigation->template->name." Result ",'icon'=>'fa fa-keyboard','sub-title'=>'Patient: '. $investigation->patient->surname." ". $investigation->patient->firstname];            
          return view('admin.tests.result_computation',compact('page_info','btns','info','investigation','resultsByField'));
     }
     
     
     public function storeResult(Request $request, $id) {
        /* store and validate */ 
        $investigation = PatientInvestigation::with('template.fields')->findOrFail($id);
        $fields = $investigation->template->fields;          
        $rules = [];
        $messages = [];

        // 🔹 Build validation dynamically
        foreach ($fields as $field) {
            $key = "results.{$field->id}";
            $label = $field->label;

            switch ($field->type) {
                case 'text':
                case 'number':
                case 'textarea':
                case 'select':
                    $rules[$key] = 'nullable|string';
                    break;

                case 'file':
                    // Multiple images
                    $rules["{$key}"] = 'nullable|array';
                    $rules["{$key}.*"] = 'nullable|image|mimes:jpg,jpeg,png|max:4096';

                    $messages["{$key}.*.image"] = "Each '{$label}' must be an image.";
                    $messages["{$key}.*.mimes"] = "Each '{$label}' must be a JPG or PNG file.";
                    $messages["{$key}.*.max"] = "Each '{$label}' may not be greater than 4MB.";
                    break;
            }
        }
            
    $validated = $request->validate($rules, $messages);

          // Check if field type is file
          foreach ($request->results as $fieldId => $value) {
            if (is_array($value) && $request->hasFile("results.{$fieldId}")) {
                $files = $request->file("results.{$fieldId}");
                $manager = new ImageManager(new Driver());
                foreach ($files as $file) {
                    if ($file->isValid()) { 
                        // Generate unique filename
                        $filename = Str::uuid() . '.jpg';
                        //  Path to public folder (not storage)
                        $savePath = public_path("images/scannedresults/{$filename}");
                        //   Read and process with Intervention
                        $imageInstance = $manager->read($file->getPathname());
                        $imageInstance->toJpeg(99)->save($savePath);                         
                        //  Save or update record in DB
                        InvestigationResultFile::updateOrCreate(
                            ['investigation_result_id' => $fieldId, // or link to your result record
                                'file_path' => $filename],
                            ['file_path' => "images/scannedresults/{$filename}" ]
                        );
                    }
                }
            } else {
                // Handle non-file result fields
                InvestigationResult::updateOrCreate(
                    ['field_id' => $fieldId,
                        'investigation_id'=>$id
                    ],
                    [ 'value' => $value ]
                );
            }
        }
        return redirect()->back()->with('success_message',
                'Investigation results saved successfully.');
                   
            }

      
}
